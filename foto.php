<?php
function ListaFotosPorAnimal($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta foto no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT F.idFoto, F.Caminho, F.idAnimal, A.Nome , A.Genero, A.Cor, A.Porte, A.Idade, A.Caracteristicas, A.QRCode, A.Desaparecido, A.idUsuario, A.idRaca FROM Foto as F INNER JOIN Animal as A on F.idAnimal = A.idAnimal") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT F.idFoto, F.Caminho, F.idAnimal, A.Nome , A.Genero, A.Cor, A.Porte, A.Idade, A.Caracteristicas, A.QRCode, A.Desaparecido, A.idUsuario, A.idRaca FROM Foto as F INNER JOIN Animal as A on F.idAnimal = A.idAnimal WHERE F.idAnimal = " .$id) or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idFoto' => $dados['idFoto'],
							'Caminho' => utf8_encode($dados['Caminho']),
							'idAnimal' => $dados['idAnimal'],
							'Nome' => utf8_encode($dados['Nome']),
							'Genero' => utf8_encode($dados['Genero']),
							'Cor' => utf8_encode($dados['Cor']),
							'Porte' => utf8_encode($dados['Porte']),
							'Idade' => $dados['Idade'],
							'Caracteristicas' => utf8_encode($dados['Caracteristicas']),
							'QRCode' => utf8_encode($dados['QRCode']),
							'Desaparecido' => $dados['Desaparecido'],
							'idUsuario' => $dados['idUsuario'],
							'idRaca' => $dados['idRaca']);
	}
	
	return $resposta;
}

function InsereFoto(){
	
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
		if(!isset($dados["Caminho"]) || !isset($dados["idAnimal"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$Caminho = utf8_decode(mysqli_real_escape_string($conexao,$dados["Caminho"]));
			$idAnimal = mysqli_real_escape_string($conexao,$dados["idAnimal"]);
			

			//Recupera o próximo ID de Foto
			$idFoto = 1;
			$query = mysqli_query($conexao, "SELECT idFoto FROM Foto ORDER BY idFoto DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idFoto = $dados["idFoto"];
			}
			$idFoto++;
			
			//Insere Foto
			$query = mysqli_query($conexao,"INSERT INTO Foto VALUES(" .$idFoto .",'" .$Caminho ."','" .$idAnimal ."')") or die(mysqli_error($conexao));
			$resposta = mensagens(7);

		}
	}

	return $resposta;
}

function ExcluiFoto($id){
	
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
		
		//Consulta foto no banco
		$query = mysqli_query($conexao, "DELETE FROM Foto WHERE idFoto=" .$id) or die(mysqli_error($conexao));
		$resposta = mensagens(11);
	}

	return $resposta;

}
?>