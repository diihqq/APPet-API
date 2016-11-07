<?php

function ListaVacinas($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses FROM Evento as E LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Vacina' ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses FROM Evento as E LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Vacina' AND E.idEvento = " .$id) or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idEvento' => $dados['idEvento'],
							'Nome' => $dados['Nome'],
							'Observacoes' => $dados['Observacoes'],
							'FlagAlerta' => $dados['FlagAlerta'],
							'idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => $dados['NivelAlerta'],
							'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
							'idAnimal' => $dados['idAnimal'],
							'Tipo' => $dados['Tipo'],
							'Aplicada' => $dados['Aplicada'],
							'DataAplicacao' => $dados['DataAplicacao'],
							'DataValidade' => $dados['DataValidade'],
							'FrequenciaAnual' => $dados['FrequenciaAnual'],
							'QtdDoses' => $dados['QtdDoses']);
	}
	
	return $resposta;
}

function QtdVacinasNaoAplicadas($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT Count(Aplicada) as 'QtdVacinasNaoAplicadas' FROM Vacina WHERE Aplicada = 0") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT Count(Aplicada) as 'QtdVacinasNaoAplicadas' FROM Vacina WHERE Aplicada = 0") or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('QtdVacinasNaoAplicadas' => $dados['QtdVacinasNaoAplicadas']);
	}
	
	return $resposta;
}

function ListaVacinasVencidas($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses, DATEDIFF(CURDATE(), V.DataValidade) as 'DiasVencidos' FROM Evento as E LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Vacina' AND V.DataValidade < CURDATE() ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses, DATEDIFF(CURDATE(), V.DataValidade) as 'DiasVencidos' FROM Evento as E LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Vacina' AND V.DataValidade < CURDATE() ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idEvento' => $dados['idEvento'],
							'Nome' => $dados['Nome'],
							'Observacoes' => $dados['Observacoes'],
							'FlagAlerta' => $dados['FlagAlerta'],
							'idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => $dados['NivelAlerta'],
							'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
							'idAnimal' => $dados['idAnimal'],
							'Tipo' => $dados['Tipo'],
							'Aplicada' => $dados['Aplicada'],
							'DataAplicacao' => $dados['DataAplicacao'],
							'DataValidade' => $dados['DataValidade'],
							'FrequenciaAnual' => $dados['FrequenciaAnual'],
							'QtdDoses' => $dados['QtdDoses'],
							'DiasVencidos' => $dados['DiasVencidos']);
	}
	
	return $resposta;
}

function AtualizaVacina($id){
	
	//Recupera conteudo recebido na request
	$conteudo = file_get_contents("php://input");
	$resposta = array();

	//Verifica se o id foi recebido
	if($id == 0){
		$resposta = mensagens(9);
	}
	else{
		//Verifica se o conteudo foi recebido
		if(empty($conteudo)){
			$resposta = mensagens(2);
		}
		else{
			//Converte o json recebido pra array
			$dados = json_decode($conteudo,true);
			
			//Verifica se as infromações esperadas foram recebidas
			if(!isset($dados["Nome"]))
			{
				$resposta = mensagens(3);
			}
			else
			{
				include("conectar.php");
				
				//Evita SQL injection
				$Nome = mysqli_real_escape_string($conexao,$dados["Nome"]);
				
				//Campos da Tabela Vacina
				if(!isset($dados["Observacoes"])){
					$Observacoes = 'NULL';
				}else{
					$Observacoes = mysqli_real_escape_string($conexao,$dados["Observacoes"]);
				}
				
				if(!isset($dados["DataAplicacao"])){
					$DataAplicacao = 'NULL';
				}else{
					$DataAplicacao = mysqli_real_escape_string($conexao,$dados["DataAplicacao"]);
				}
				
				if(!isset($dados["DataValidade"])){
					$DataValidade = 'NULL';
				}else{
					$DataValidade = mysqli_real_escape_string($conexao,$dados["DataValidade"]);
				}
				
				if(!isset($dados["QtdDoses"])){
					$QtdDoses = 'NULL';
				}else{
					$QtdDoses = mysqli_real_escape_string($conexao,$dados["QtdDoses"]);
				}
				
				if(!isset($dados["Aplicada"])){
					$Aplicada = 0; //Se o campo aplicada não for passado será pressuposto que a vacina ainda não foi aplicada
				}else{
					$Aplicada = mysqli_real_escape_string($conexao,$dados["Aplicada"]);
				}
				
				//Atualiza vacina no banco
				$query = mysqli_query($conexao, "UPDATE Vacina SET Aplicada = " .$Aplicada .", DataAplicacao = '" .$DataAplicacao ."',
				DataValidade = '" .$DataValidade ."', QtdDoses = " .$QtdDoses ." 
				WHERE idEvento=" .$id) or die(mysqli_error($conexao));
				
				$query2 = mysqli_query($conexao,"UPDATE Evento SET Nome = '". $Nome ."', Observacoes = '" .$Observacoes ."' WHERE idEvento=" .$id) or die(mysqli_error($conexao));
				
				$resposta = mensagens(10);
			}
		}
	}

	return $resposta;

}

function ExcluiVacina($id){
	
	//Recupera conteudo recebido na request
	$resposta = array();

	//Verifica se o id foi recebido
	if($id == 0){
		$resposta = mensagens(9);
	}
	else{
		include("conectar.php");
		
		//Evita SQL injection		
		$id = mysqli_real_escape_string($conexao,$id);
		
		//Exclui vacina e alerta no banco
		$query = mysqli_query($conexao, "DELETE FROM Vacina WHERE idEvento=" .$id) or die(mysqli_error($conexao));
		$query2 = mysqli_query($conexao, "DELETE FROM Evento WHERE idEvento=" .$id . " and Tipo = 'Vacina'") or die(mysqli_error($conexao));
		$resposta = mensagens(11);
	}

	return $resposta;
	
}

?>