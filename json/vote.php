<?php
// é pra tratar um POST, se não for, dá 404
if(!isset($_POST)) require_once ABSPATH."/includes/404.php";

// Pega os dados da postagem
$idquestion = (int)$param[1];						// Recebido no arquivo /loader.php
$option_id = (int)json_decode($_POST['vote'],true)['option_id'];	// Recebido pela postagem do JSON

// Verifica se existe o Id, caso não exista, retorna um 404
$existe = DBFastRead('QuestionOption',"WHERE IdQuestion=$idquestion AND Id=$option_id",'Id');
if (!$existe) require_once ABSPATH.'/includes/404.php';

// Incrementa um voto na votação
DBFastExecute("UPDATE QuestionOption SET Polling=Polling+1 WHERE IdQuestion=$idquestion AND Id=$option_id");

// Emite o cabeçalho de que se trata de json
header('Content-Type: application/json');
echo $option_id;
?>