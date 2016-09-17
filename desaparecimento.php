<?php
function ListaDesaparecimentosPorAnimal($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta desaparecimentos no banco
	if($id == 0){
		$resposta = mensagens(14);
	}else{
		$query = mysqli_query($conexao,"SELECT D.idDesaparecimento, D.dataDesaparecimento, A.Nome, A.Genero, A.Cor , A.Porte, A.Idade, A.Caracteristicas, A.QRCode, A.Desaparecido, A.idUsuario, A.idRaca FROM Desaparecimento as D INNER JOIN Animal as A on D.idAnimal = A.idAnimal WHERE D.idAnimal = " .$id) or die(mysqli_error($conexao));
	
		//faz um looping e cria um array com os campos da consulta
		while($dados = mysqli_fetch_array($query))
		{
			$resposta[] = array('idDesaparecimento' => $dados['idDesaparecimento'],
								'dataDesaparecimento' => $dados['dataDesaparecimento'],
								'Nome' => $dados['Nome'],
								'Genero' => $dados['Genero'],
								'Cor' => $dados['Cor'],
								'Porte' => $dados['Porte'],
								'Idade' => $dados['Idade'],
								'Caracteristicas' => $dados['Caracteristicas'],
								'QRCode' => $dados['QRCode'],
								'Desaparecido' => $dados['Desaparecido'],
								'idUsuario' => $dados['idUsuario'],
								'idRaca' => $dados['idRaca']);
		}
	}
	return $resposta;
}

function InsereDesaparecimento(){
	
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
		if(!isset($dados["dataDesaparecimento"]) || !isset($dados["idAnimal"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$dataDesaparecimento = mysqli_real_escape_string($conexao,$dados["dataDesaparecimento"]);
			$idAnimal = mysqli_real_escape_string($conexao,$dados["idAnimal"]);
			

			//Recupera o próximo ID de Desaparecimento
			$idDesaparecimento = 1;
			$query = mysqli_query($conexao, "SELECT idDesaparecimento FROM Desaparecimento ORDER BY idDesaparecimento DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idDesaparecimento = $dados["idDesaparecimento"];
			}
			$idDesaparecimento++;
			
			//Insere desaparecimento
			$query = mysqli_query($conexao,"INSERT INTO Desaparecimento VALUES(" .$idDesaparecimento .",'" .$dataDesaparecimento ."','" .$idAnimal ."')") or die(mysqli_error($conexao));
			$resposta = mensagens(7);

		}
	}

	return $resposta;
}
?>