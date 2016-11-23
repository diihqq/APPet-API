<?php
function ListaUsuarios($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta usuário no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT idUsuario, Nome, Email, Telefone, Cidade, Bairro FROM Usuario") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT idUsuario, Nome, Email, Telefone, Cidade, Bairro FROM Usuario WHERE idUsuario = " .$id) or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idUsuario' => $dados['idUsuario'],
							'Nome' => $dados['Nome'],
							'Email' => $dados['Email'],
							'Telefone' => $dados['Telefone'],
							'Cidade' => $dados['Cidade'],
							'Bairro' => $dados['Bairro']);
	}
	
	return $resposta;
}

function InsereUsuario(){
	
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
		if(!isset($dados["Nome"]) || !isset($dados["Email"]) || 
		   !isset($dados["Telefone"]) || !isset($dados["Cidade"]) || !isset($dados["Bairro"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			$emailCadastrado = false;
			
			//Evita SQL injection
			$Nome = mysqli_real_escape_string($conexao,$dados["Nome"]);
			$Email = mysqli_real_escape_string($conexao,$dados["Email"]);
			$Telefone = mysqli_real_escape_string($conexao,$dados["Telefone"]);
			$Cidade = mysqli_real_escape_string($conexao,$dados["Cidade"]);
			$Bairro = mysqli_real_escape_string($conexao,$dados["Bairro"]);
			
			//Consulta usuário no banco
			$query = mysqli_query($conexao,"SELECT idUsuario, Nome, Email, Telefone, Cidade, Bairro FROM Usuario WHERE Email='" .$Email ."'") or die(mysqli_error($conexao));
			
			//Verifica se foi retornado algum registro
			while($dados = mysqli_fetch_array($query))
			{
			  $emailCadastrado = true;
			  break;
			}
			
			if($emailCadastrado){
				$resposta = mensagens(6);
			}else{
				//Recupera o próximo ID de usuário
				$idUsuario = 1;
				$query = mysqli_query($conexao, "SELECT idUsuario FROM Usuario ORDER BY idUsuario DESC LIMIT 1") or die(mysqli_error($conexao));
				while($dados = mysqli_fetch_array($query)){
					$idUsuario = $dados["idUsuario"];
				}
				$idUsuario++;
				
				//Insere usuário
				$query = mysqli_query($conexao,"INSERT INTO Usuario VALUES(" .$idUsuario .",'" .$Nome ."','" .$Email ."','" .$Telefone ."','" .$Cidade ."','" .$Bairro ."')") or die(mysqli_error($conexao));
				$resposta = mensagens(7);
			}
		}
	}

	return $resposta;
}

function RecuperaUsuario(){
	
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
		if(!isset($dados["Email"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			$emailCadastrado = false;
			
			//Evita SQL injection
			$Email = mysqli_real_escape_string($conexao,$dados["Email"]);
			
			//Consulta usuário no banco
			$query = mysqli_query($conexao,"SELECT idUsuario, Nome, Email, Telefone, Cidade, Bairro FROM Usuario WHERE Email='" .$Email ."'") or die(mysqli_error($conexao));
			
			//Verifica se foi retornado algum registro
			while($dados = mysqli_fetch_array($query))
			{
				$resposta = array('idUsuario' => $dados['idUsuario'],
					'Nome' => $dados['Nome'],
					'Email' => $dados['Email'],
					'Telefone' => $dados['Telefone'],
					'Cidade' => $dados['Cidade'],
					'Bairro' => $dados['Bairro']);		
			  $emailCadastrado = true;
			  break;
			}
			
			//Verifica se o usuário foi encontrado
			if(!$emailCadastrado){
				$resposta = mensagens(8);
			}
		}
	}

	return $resposta;
}

function AtualizaUsuario($id){
	
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
			if(!isset($dados["Nome"]) || !isset($dados["Email"]) || 
			   !isset($dados["Telefone"]) || !isset($dados["Cidade"]) || !isset($dados["Bairro"])){
				$resposta = mensagens(3);
			}
			else{
				include("conectar.php");
				
				//Evita SQL injection
				$id = mysqli_real_escape_string($conexao,$id);
				$Nome = mysqli_real_escape_string($conexao,$dados["Nome"]);
				$Email = mysqli_real_escape_string($conexao,$dados["Email"]);
				$Telefone = mysqli_real_escape_string($conexao,$dados["Telefone"]);
				$Cidade = mysqli_real_escape_string($conexao,$dados["Cidade"]);
				$Bairro = mysqli_real_escape_string($conexao,$dados["Bairro"]);
				
				//Consulta usuário no banco
				$query = mysqli_query($conexao, "UPDATE Usuario SET Nome = '" .$Nome ."', Email = '" .$Email ."', Telefone = '" .$Telefone ."', Cidade = '" .$Cidade ."', Bairro = '" .$Bairro ."' WHERE idUsuario=" .$id) or die(mysqli_error($conexao));
				$resposta = mensagens(10);
			}
		}
	}

	return $resposta;

}

function ExcluiUsuario($id){
	
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
		
		//Exclui usuário no banco
		$query1 = mysqli_query($conexao, "DELETE FROM Animal WHERE idUsuario=" .$id) or die(mysqli_error($conexao));
		$query2 = mysqli_query($conexao, "DELETE FROM Usuario WHERE idUsuario=" .$id) or die(mysqli_error($conexao));
		$resposta = mensagens(11);
	}

	return $resposta;

}
?>