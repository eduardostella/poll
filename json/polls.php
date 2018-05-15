<?php
header('Content-Type: application/json');

// Lê do banco 
$polls =  DBFastRead('Question','','Id,Description');

// Retorna o json
echo json_encode($polls);
?>