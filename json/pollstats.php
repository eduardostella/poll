<?php
// Não foi enviado parâmetro do Id e das estatisticas, retorna 404
// if ($numparam!=3)	require_once ABSPATH.'/includes/404.php';
// Pega o parâmetro definido no "loader"
$idquestion = $param[1];
$valido = strtolower($param[2]);

if ($valido != "stats") require_once ABSPATH.'/includes/404.php';

// Conecta ao banco, puxa a questão passada e as opções disponíveis
$ln = DBConnect();
$poll =  DBRead($ln,'Question','WHERE Id='.$idquestion,'Views');
$questions = DBRead($ln,'QuestionOption','WHERE IdQuestion='.$idquestion,'Id AS option_id,Polling AS qty');
DBClose($ln);

// Se não achou, retorna o 404
if (!$poll) require_once ABSPATH.'/includes/404.php';

//array_push($poll, 'options'=>$questions);
$ret = array('views'=>$poll[0]['Views'],'votes'=>$questions);

// Emite o cabeçalho de que se trata de json
header('Content-Type: application/json');

/* Retorna o json codificado 
   { views: <nro>,
     votes: [{option_id: <id>,
             {qty: "<qty>"}, 
             ...
             {option_id: <id>,
             {qty: "<description>"}]
   }
*/
echo json_encode($ret);
?>