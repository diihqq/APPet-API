<?php

function ListaCompromissos($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora FROM Evento as E LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Compromisso' ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora FROM Evento as E LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Compromisso' AND E.idEvento = " .$id) or die(mysqli_error($conexao));
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
							'NomeLocal' => $dados['NomeLocal'],
							'Latitude' => $dados['Latitude'],
							'Longitude' => $dados['Longitude'],
							'DataHora' => $dados['DataHora']);
	}
	
	return $resposta;
}

function ListaCompromissosPendentes($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora, DATEDIFF(C.DataHora, NOW()) as 'DiasAteCompromisso' FROM Evento as E LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Compromisso' AND DataHora > NOW() ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora, DATEDIFF(C.DataHora, NOW()) as 'DiasAteCompromisso' FROM Evento as E LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Compromisso' AND DataHora > NOW() ORDER BY E.idEvento") or die(mysqli_error($conexao));
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
							'NomeLocal' => $dados['NomeLocal'],
							'Latitude' => $dados['Latitude'],
							'Longitude' => $dados['Longitude'],
							'DataHora' => $dados['DataHora']);
	}
	
	return $resposta;
}

function AtualizaCompromisso($id){
	
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
			if(!isset($dados["NomeLocal"]) || !isset($dados["Latitude"]) || 
		   !isset($dados["Longitude"]) || !isset($dados["DataHora"]))
			{
				$resposta = mensagens(3);
			}
			else
			{
				include("conectar.php");
				
				//Evita SQL injection
				$NomeLocal = mysqli_real_escape_string($conexao,$dados["NomeLocal"]);
				$Latitude = mysqli_real_escape_string($conexao,$dados["Latitude"]);
				$Longitude = mysqli_real_escape_string($conexao,$dados["Longitude"]);
				$DataHora = mysqli_real_escape_string($conexao,$dados["DataHora"]);
				
				//Atualiza compromisso no banco
				$query = mysqli_query($conexao, "UPDATE Compromisso SET NomeLocal = '" .$NomeLocal ."', Latitude = '" .$Latitude ."',
				Longitude = '" .$Longitude ."', DataHora = '" .$DataHora ."'
				WHERE idEvento=" .$id) or die(mysqli_error($conexao));
				$resposta = mensagens(10);
			}
		}
	}

	return $resposta;

}

function ExcluiCompromisso($id){
	
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
		
		//Exclui compromisso e alerta no banco
		$query = mysqli_query($conexao, "DELETE FROM Compromisso WHERE idEvento=" .$id) or die(mysqli_error($conexao));
		$query2 = mysqli_query($conexao, "DELETE FROM Evento WHERE idEvento=" .$id . " and Tipo = 'Compromisso'") or die(mysqli_error($conexao));
		$resposta = mensagens(11);
	}

	return $resposta;
	
}

?>