<?php
// é pra tratar um POST, se não for, dá 404
if(!isset($_POST)) require_once "/includes/404.php";

// Pega os dados da postagem (recebe no campo "vote")
$dados = json_decode($_POST['vote'],true);
$poll_description = $dados['poll_description'];
$options = $dados['options'];

// Emite o cabeçalho de que se trata de json
header('Content-Type: application/json');

// Verifica se tá preenchido ok, caso não, retorna um 0
$erro=0;
if (strlen($poll_description)<2) $erro=1;
if (count($options)<2) $erro=2;
for ($x=0;$x<count($options);$x++)
  if(strlen($options[$x])<2) $erro=3;
if($erro)	// Deu erro, manda 0 e termina
{
	echo 0;
	return;
}

// Executa a gravação dos dados no banco de dados
$ln = DBConnect();
// Principal
$cp = array(
			'Description' => $poll_description,
			'Views' => 0);
// Abre a conexão
$nid=DBCreate($ln,"Question",$cp,true);
// Opções (lê o array secundário)
for ($x=0;$x<count($options);$x++)
{
	$cp = array(
		'IdQuestion' => $nid,
		'Id' => $x+1,
		'Description' => $options[$x],
		'Polling' => 0);
	DBCreate($ln,"QuestionOption",$cp);
}
// Fecha a conexão
DBClose($ln);

// Descomente pra debugar e ter um output pra ver
//$arq = fopen("/tmp/saida_json.txt",'a+');
//fwrite($arq, date('Y-m-d H:i').print_r($poll_description,true).' - '.$opcoes."\n");
//fclose($arq);


// Forma o retorno
$ret = array( 'poll_id', $nid);
echo json_encode($ret);
?>