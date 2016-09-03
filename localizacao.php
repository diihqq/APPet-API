<?php
function ListaLocalizacoesPorDesaparecimento($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta localizacoes no banco
	if($id == 0){
		$resposta = mensagens(14);
	}else{
		$query = mysqli_query($conexao,"SELECT L.idLocalizacao, L.Latitude, L.Longitude, L.idDesaparecimento, D.DataDesaparecimento, D.idAnimal FROM Localizacao as L INNER JOIN Desaparecimento as D on L.idDesaparecimento = D.idDesaparecimento WHERE L.idDesaparecimento = " .$id) or die(mysqli_error($conexao));
	
		//faz um looping e cria um array com os campos da consulta
		while($dados = mysqli_fetch_array($query))
		{
			$resposta[] = array('idLocalizacao' => $dados['idDesaparecimento'],
								'Latitude' => $dados['Latitude'],
								'Longitude' => $dados['Longitude'],
								'idDesaparecimento' => $dados['idDesaparecimento'],
								'DataDesaparecimento' => $dados['DataDesaparecimento'],
								'idAnimal' => $dados['idAnimal']);
		}
	}
	return $resposta;
}

function InsereLocalizacao(){
	
	//Recupera conteudo recebido na request
	$conteudo = file_get_contents("php://input");
	$resposta = array();

	//Verifica se o conteudo foi recebido
	if(empty($conteudo)){
		$resposta = mensagens(2);
	}
	else{
		//Converte o json recebido pra array
		$dados = json_decode($conteudo,true);
		
		//Verifica se as infromações esperadas foram recebidas
		if(!isset($dados["Latitude"]) || !isset($dados["Longitude"]) || !isset($dados["idDesaparecimento"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$Latitude = mysqli_real_escape_string($conexao,$dados["Latitude"]);
			$Longitude = mysqli_real_escape_string($conexao,$dados["Longitude"]);
			$idDesaparecimento = mysqli_real_escape_string($conexao,$dados["idDesaparecimento"]);
			

			//Recupera o próximo ID de Localizacao
			$idLocalizacao = 1;
			$query = mysqli_query($conexao, "SELECT idLocalizacao FROM Localizacao ORDER BY idLocalizacao DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idLocalizacao = $dados["idLocalizacao"];
			}
			$idLocalizacao++;
			
			//Insere localizacao
			$query = mysqli_query($conexao,"INSERT INTO Localizacao VALUES(" .$idLocalizacao .",'" .$Latitude ."','" .$Longitude ."','" .$idDesaparecimento ."')") or die(mysqli_error($conexao));
			$resposta = mensagens(7);

		}
	}

	return $resposta;
}
?>