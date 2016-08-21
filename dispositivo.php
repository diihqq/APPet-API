<?php
function ListaDispositivosPorUsuario($id){
	include("conectar.php");
	
	$resposta = array();
	
	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta dispositivo no banco
	if($id == 0){
		$resposta = mensagens(9);
	}else{
		$query = mysqli_query($conexao,"SELECT idDispositivo, ChaveAPI, IMEI, Principal FROM Dispositivo WHERE idUsuario = " .$id) or die(mysqli_error($conexao));
	}
	
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idDispositivo' => $dados['idDispositivo'],
							'ChaveAPI' => utf8_encode($dados['ChaveAPI']),
							'IMEI' => utf8_encode($dados['IMEI']),
							'Principal' => $dados['Principal']);
	}
	
	return $resposta;
}

function InsereDispositivo($id){
	
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
		if(!isset($dados["ChaveAPI"]) || !isset($dados["IMEI"]) || 
		   !isset($dados["Principal"]) || !isset($dados["idUsuario"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			$IMEICadastrado = false;
			
			//Evita SQL injection
			$ChaveAPI = mysqli_real_escape_string($conexao,$dados["ChaveAPI"]);
			$IMEI = mysqli_real_escape_string($conexao,$dados["IMEI"]);
			$Principal = mysqli_real_escape_string($conexao,$dados["Principal"]);
			$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
			
			//Consulta usuário no banco
			$query = mysqli_query($conexao,"SELECT idDispositivo, ChaveAPI, IMEI, idUsuario FROM Dispositivo WHERE IMEI='" .$IMEI ."'") or die(mysqli_error($conexao));
			
			//Verifica se foi retornado algum registro
			while($dados = mysqli_fetch_array($query))
			{
			  $IMEICadastrado = true;
			  break;
			}
			
			if($IMEICadastrado){
				$resposta = mensagens(12);
			}else{
				//Recupera o próximo ID de Dispositivo
				$idDispositivo = 1;
				$query = mysqli_query($conexao, "SELECT idDispositivo FROM Dispositivo ORDER BY idDispositivo DESC LIMIT 1") or die(mysqli_error($conexao));
				while($dados = mysqli_fetch_array($query)){
					$idDispositivo = $dados["idDispositivo"];
				}
				$idDispositivo++;
				
				//Insere dispositivo
				$query = mysqli_query($conexao,"INSERT INTO Dispositivo VALUES(" .$idDispositivo .",'" .$ChaveAPI ."','" .$IMEI ."','" .$Principal ."','" .$idUsuario ."')") or die(mysqli_error($conexao));
				$resposta = mensagens(7);
			}
		}
	}

	return $resposta;
}

function AtualizaDispositivo($id){
	
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
			if(!isset($dados["ChaveAPI"]) || !isset($dados["IMEI"]) || 
			   !isset($dados["Principal"]) || !isset($dados["idUsuario"])){
				$resposta = mensagens(3);
			}
			else{
				include("conectar.php");
				
				//Evita SQL injection
				$id = mysqli_real_escape_string($conexao,$id);
				$ChaveAPI = mysqli_real_escape_string($conexao,$dados["ChaveAPI"]);
				$IMEI = mysqli_real_escape_string($conexao,$dados["IMEI"]);
				$Principal = mysqli_real_escape_string($conexao,$dados["Principal"]);
				$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
				
				//Consulta usuário no banco
				$query = mysqli_query($conexao, "UPDATE Dispositivo SET ChaveAPI = '" .$ChaveAPI ."', IMEI = '" .$IMEI ."', Principal = '" .$Principal ."', idUsuario = '" .$idUsuario ."' WHERE idDispositivo=" .$id) or die(mysqli_error($conexao));
				$resposta = mensagens(10);
			}
		}
	}

	return $resposta;

}

function ExcluiDispositivo($id){
	
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

		$Principal= false;
			
		//Consulta se o dispositivo é principal no banco
		$query = mysqli_query($conexao,"SELECT Principal FROM Dispositivo WHERE idDispositivo='" .$id ."'") or die(mysqli_error($conexao));
		
		//Verifica se foi retornado algum registro
		while($dados = mysqli_fetch_array($query))
		{
			if($dados["Principal"] == 1){
				$Principal = true;
				break;
			}
		}
		
		if($Principal){
			$resposta = mensagens(13);
		}else{
			//Consulta dispositivo no banco e o deleta
			$query = mysqli_query($conexao, "DELETE FROM Dispositivo WHERE idDispositivo=" .$id) or die(mysqli_error($conexao));
			$resposta = mensagens(11);
		}
	}

	return $resposta;

}

?>