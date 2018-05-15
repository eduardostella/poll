<?php
// Não foi enviado parâmetro do Id, retorna 404
if ($numparam==1)	require_once ABSPATH.'/includes/404.php';
// Pega o parâmetro definido no "loader.php"
$idquestion = $param[1];

// Conecta ao banco, puxa a questão passada e as opções disponíveis
$ln = DBConnect();		
$poll =  DBRead($ln,'Question','WHERE Id='.$idquestion,'Id,Description');
$questions = DBRead($ln,'QuestionOption','WHERE IdQuestion='.$idquestion,'Id AS option_id,Description AS option_description');
DBExecute($ln,"UPDATE Question SET Views=Views+1 WHERE Id=$idquestion;");
DBClose($ln);

// Se não achou, retorna o 404
if (!$poll) require_once ABSPATH.'/includes/404.php';

//array_push($poll, 'options'=>$questions);
$ret = array('poll_id'=>$poll[0]['Id'],'poll_description'=>$poll[0]['Description'],'options'=>$questions);

// Emite o cabeçalho de que se trata de json
header('Content-Type: application/json');

/* Retorna o json codificado 
   { poll_id: <id>,
     poll_description: "<description>",
     options: [{option_id: <id>,
               {option_description: "<description"}, 
               ...
               {option_id: <id>,
               {option_description: "<description>"}]
   }
*/
echo json_encode($ret);
?>