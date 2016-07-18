<?php

$ServerBD = $_SERVER['SERVER_NAME'];
$PortaBD = $_SERVER ['SERVER_PORT'];

if(isset($PortaBD)){
    $conect = mysqli_connect($ServerBD, "root", "ALUNOS");
}else{
    $conect = mysqli_connect($ServerBD .":" .$PortaBD, "root", "ALUNOS");   
}

//$conect = mysqli_connect('localhost', "root", "ALUNOS");

// Caso a conexão seja reprovada, exibe na tela uma mensagem de erro
if (!$conect) die ('<div id="erro2">Falha na coneco com o Banco de Dados!</div>');

// Caso a conexão seja aprovada, então conecta o Banco de Dados.	
$db = mysqli_select_db($conect,"spypet");

?>