<?php

$ServerBD = $_SERVER['SERVER_NAME'];

if(!isset($PortaBD)){
    $conexao = mysqli_connect($ServerBD, "root", "ALUNOS");
}else{
    $conexao = mysqli_connect($ServerBD .":" .$PortaBD, "root", "ALUNOS");   
}

//$conect = mysqli_connect('localhost', "root", "ALUNOS");

// Caso a conex�o seja reprovada, exibe na tela uma mensagem de erro
if (!$conexao) die ('<div id="erro2">Falha na coneco com o Banco de Dados!</div>');

// Caso a conex�o seja aprovada, ent�o conecta o Banco de Dados.	
$db = mysqli_select_db($conexao,"appet");

?>