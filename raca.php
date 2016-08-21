<?php
function ListaRacas($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta raca no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT idRaca, Nome, Descricao, idEspecie FROM Raca") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT idRaca, Nome, Descricao, idEspecie FROM Raca WHERE idRaca = " .$id) or die(mysqli_error($conexao));
	}
	
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idRaca' => $dados['idRaca'],
							'Nome' => utf8_encode($dados['Nome']),
							'Descricao' => utf8_encode($dados['Descricao']),
							'idEspecie' => $dados['idEspecie']);
	}
	
	return $resposta;
}

function ListaRacasPorEspecie($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta raca no banco
	if($id == 0){
		$resposta = mensagens(2);
	}else{
		$query = mysqli_query($conexao,"SELECT idRaca, Nome, Descricao, idEspecie FROM Raca WHERE idEspecie = " .$id) or die(mysqli_error($conexao));
	}
	
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idRaca' => $dados['idRaca'],
							'Nome' => utf8_encode($dados['Nome']),
							'Descricao' => utf8_encode($dados['Descricao']),
							'idEspecie' => $dados['idEspecie']);
	}
	
	return $resposta;
}
?>