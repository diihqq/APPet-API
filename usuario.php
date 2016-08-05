<?php
function ListaUsuarios($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conect,$id);
	
	//Consulta usuário no banco
	if($id == 0){
		$query = mysqli_query($conect,"SELECT * FROM usuario") or die(mysqli_error($conect));
	}else{
		$query = mysqli_query($conect,"SELECT * FROM usuario WHERE idUsuario = " .$id) or die(mysqli_error($conect));
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

function InsereUsuario($id){
	
	$conteudo = file_get_contents('php://input');
	$resposta = array();

	//Verifica se o conteudo foi recebido
	if(empty($conteudo)){
		$resposta = mensagens(2);
	}
	else{
		$dados = json_decode($conteudo,true);
		
		//Verifica se as infromações esperadas foram recebidas
		if(!isset($dados["idUsuario"]) || !isset($dados["Nome"]) || !isset($dados["Email"]) || 
		   !isset($dados["Telefone"]) || !isset($dados["Cidade"]) || !isset($dados["Bairro"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			$emailCadastrado = false;
			
			//Evita SQL injection
			$idUsuario = mysqli_real_escape_string($conect,$dados["idUsuario"]);
			$Nome = mysqli_real_escape_string($conect,$dados["Nome"]);
			$Email = mysqli_real_escape_string($conect,$dados["Email"]);
			$Telefone = mysqli_real_escape_string($conect,$dados["Telefone"]);
			$Cidade = mysqli_real_escape_string($conect,$dados["Cidade"]);
			$Bairro = mysqli_real_escape_string($conect,$dados["Bairro"]);
			
			//Consulta usuário no banco
			$query = mysqli_query($conect,"SELECT * FROM usuario WHERE email='" .$Email ."'") or die(mysqli_error($conect));
			
			//Verifica se foi retornado algum registro
			while($dados = mysqli_fetch_array($query))
			{
			  $emailCadastrado = true;
			  break;
			}
			
			if($emailCadastrado){
				$resposta = mensagens(6);
			}else{
				//Insere usuário
				$query = mysqli_query($conect,"INSERT INTO usuario VALUES(" .$idUsuario ."," .$Nome ."," .$Email ."," .$Telefone ."," .$Cidade ."," .$Bairro .")") or die(mysqli_error($conect));
				$resposta = mensagens(7);
			}
		}
	}

	return $resposta;
	
}

/*
$retorno = array();
	
	
	
	
	//Verifica se os dados foram recebidos
	if(empty($conteudo)){
		$resposta = mensagens(2);
	}
	else{
		$credenciais = json_decode(file_get_contents('php://input'),true);
		
		//Verifica se as infromações esperadas foram recebidas
		if(!isset($credenciais["usuario"]) || !isset($credenciais["senha"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			$autenticado = false;
			
			//Evita SQL injection
			$email = mysqli_real_escape_string($conect,$credenciais["usuario"]);
			$senha = mysqli_real_escape_string($conect,$credenciais["senha"]);
			//Consulta usuário no banco
			$query = mysqli_query($conect,"SELECT Email FROM usuario WHERE email='" .$email ."' AND senha='" .$senha ."'") or die(mysqli_error($conect));
			//faz um looping e cria um array com os campos da consulta
			while($dados = mysqli_fetch_array($query))
			{
			  $autenticado = true;
			}
			
			if($autenticado){
				$resposta = mensagens(4);
			}else{
				$resposta = mensagens(5);
			}
		}
	}
*/
?>

