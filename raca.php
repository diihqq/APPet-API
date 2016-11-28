<?php
function ListaRacas($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta raca no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT R.idRaca, R.Nome as 'NomeRaca', R.Descricao, R.idEspecie, E.Nome as 'NomeEspecie' FROM Raca as R INNER JOIN Especie as E on R.idEspecie = E.idEspecie") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT R.idRaca, R.Nome as 'NomeRaca', R.Descricao, R.idEspecie, E.Nome as 'NomeEspecie' FROM Raca as R INNER JOIN Especie as E on R.idEspecie = E.idEspecie WHERE idRaca = " .$id) or die(mysqli_error($conexao));
	}
	
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idRaca' => $dados['idRaca'],
							'NomeRaca' => $dados['NomeRaca'],
							'Descricao' => $dados['Descricao'],
							'idEspecie' => $dados['idEspecie'],
							'NomeEspecie' => $dados['NomeEspecie']);
	}
	
	return $resposta;
}

function ListaRacasPorEspecie($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta raca no banco
	if($id == 0){
		$resposta = mensagens(14);
	}else{
		$query = mysqli_query($conexao,"SELECT R.idRaca, R.Nome as 'NomeRaca', R.Descricao, R.idEspecie, E.Nome as 'NomeEspecie' FROM Raca as R INNER JOIN Especie as E on R.idEspecie = E.idEspecie WHERE R.idEspecie = " .$id . " order by R.Nome") or die(mysqli_error($conexao));
		
		//faz um looping e cria um array com os campos da consulta
		while($dados = mysqli_fetch_array($query))
		{
			$resposta[] = array('idRaca' => $dados['idRaca'],
								'NomeRaca' => $dados['NomeRaca'],
								'Descricao' => $dados['Descricao'],
								'idEspecie' => $dados['idEspecie'],
								'NomeEspecie' => $dados['NomeEspecie']);
		}
	}
	return $resposta;
}
?>