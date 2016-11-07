<?php

function ListaMedicamentos($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, M.Inicio, M.Fim, M.FrequenciaDiaria, M.HorasDeEspera FROM Evento as E LEFT JOIN Medicamento as M on E.idEvento = M.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Medicamento' ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, M.Inicio, M.Fim, M.FrequenciaDiaria, M.HorasDeEspera FROM Evento as E LEFT JOIN Medicamento as M on E.idEvento = M.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Medicamento' AND E.idEvento = " .$id) or die(mysqli_error($conexao));
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
							'Inicio' => $dados['Inicio'],
							'Fim' => $dados['Fim'],
							'FrequenciaDiaria' => $dados['FrequenciaDiaria'],
							'HorasDeEspera' => $dados['HorasDeEspera']);
	}
	
	return $resposta;
}

function AtualizaMedicamento($id){
	
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
				
				//Campos da Tabela Medicamento
				if(!isset($dados["Inicio"])){
					$Inicio = 'CURDATE()'; //Se o campo Inicio não for passado será pressuposto que o inicio é a data atual
				}else{
					$Inicio = mysqli_real_escape_string($conexao,$dados["Inicio"]);
				}
				
				if(!isset($dados["Fim"])){
					$Fim = 'CURDATE()'; //Se o campo Fim não for passado será pressuposto que o fim é a data atual
				}else{
					$Fim = mysqli_real_escape_string($conexao,$dados["Fim"]);
				}
								
				if(!isset($dados["HorasDeEspera"])){
					$HorasDeEspera = 'NULL';
				}else{
					$HorasDeEspera = mysqli_real_escape_string($conexao,$dados["HorasDeEspera"]);
				}
				
				//Atualiza medicamento no banco
				$query = mysqli_query($conexao, "UPDATE Medicamento SET Inicio = '" .$Inicio ."', Fim = '" .$Fim ."',
				HorasDeEspera = " .$HorasDeEspera ." WHERE idEvento=" .$id) or die(mysqli_error($conexao));
				
				$query2 = mysqli_query($conexao,"UPDATE Evento SET Nome = '". $Nome ."', Observacoes = '" .$Observacoes ."' WHERE idEvento=" .$id) or die(mysqli_error($conexao));
				
				$resposta = mensagens(10);
			}
		}
	}

	return $resposta;

}

function ExcluiMedicamento($id){
	
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
		
		//Exclui medicamento e alerta no banco
		$query = mysqli_query($conexao, "DELETE FROM Medicamento WHERE idEvento=" .$id) or die(mysqli_error($conexao));
		$query2 = mysqli_query($conexao, "DELETE FROM Evento WHERE idEvento=" .$id . " and Tipo = 'Medicamento'") or die(mysqli_error($conexao));
		$resposta = mensagens(11);
	}

	return $resposta;
	
}

?>