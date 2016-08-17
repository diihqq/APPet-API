<?php
function ListaEspecies($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta espécie no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT * FROM Especie") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT * FROM Espece WHERE idEspecie = " .$id) or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idEspecie' => $dados['idEspecie'],
							'Nome' => $dados['Nome']);
	}
	
	return $resposta;
}

?>