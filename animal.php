<?php
function ListaAnimais($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta animal no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT * FROM Animal") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT * FROM Animal WHERE idAnimal = " .$id) or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idAnimal' => $dados['idAnimal'],
							'Nome' => $dados['Nome'],
							'Genero' => utf8_decode($dados['Genero']),
							'Cor' => $dados['Cor'],
							'Porte' => utf8_decode($dados['Porte']),
							'Idade' => $dados['Idade'],
							'Caracteristicas' => utf8_decode($dados['Caracteristicas']),
							'QRCode' => $dados['QRCode'],
							'Desaparecido' => $dados['Desaparecido'],
							'idUsuario' => $dados['idUsuario'],
							'idRaca' => $dados['idRaca']);
	}
	return $resposta;
}

function ListaAnimaisDesaparecidos($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta animal no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT * FROM Animal WHERE Desaparecido = 1") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT * FROM Animal WHERE idAnimal = " .$id . " and Desaparecido = 1") or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idAnimal' => $dados['idAnimal'],
							'Nome' => replaceAccents($dados['Nome']),
							'Genero' => utf8_decode($dados['Genero']),
							'Cor' => $dados['Cor'],
							'Porte' => utf8_decode($dados['Porte']),
							'Idade' => $dados['Idade'],
							'Caracteristicas' => utf8_decode($dados['Caracteristicas']),
							'QRCode' => $dados['QRCode'],
							'Desaparecido' => $dados['Desaparecido'],
							'idUsuario' => $dados['idUsuario'],
							'idRaca' => $dados['idRaca']);
	}
	return $resposta;
}

function InsereAnimal($id){
	
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
		if(!isset($dados["Nome"]) || !isset($dados["Genero"]) || 
		   !isset($dados["Cor"]) || !isset($dados["Porte"]) || !isset($dados["Idade"]) ||
		   !isset($dados["Caracteristicas"]) || !isset($dados["QRCode"]) || !isset($dados["Desaparecido"]) ||
		   !isset($dados["idUsuario"]) || !isset($dados["idRaca"]))
		{
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			//$emailCadastrado = false;
			
			//Evita SQL injection
			$Nome = mysqli_real_escape_string($conexao,$dados["Nome"]);
			$Genero = mysqli_real_escape_string($conexao,$dados["Genero"]);
			$Cor = mysqli_real_escape_string($conexao,$dados["Cor"]);
			$Porte = mysqli_real_escape_string($conexao,$dados["Porte"]);
			$Idade = mysqli_real_escape_string($conexao,$dados["Idade"]);
			$Caracteristicas = mysqli_real_escape_string($conexao,$dados["Caracteristicas"]);
			$QRCode = mysqli_real_escape_string($conexao,$dados["QRCode"]);
			$Desaparecido = mysqli_real_escape_string($conexao,$dados["Desaparecido"]);
			$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
			$idRaca = mysqli_real_escape_string($conexao,$dados["idRaca"]);
			
			//Recupera idAnimal para incrementar 1
			$idAnimal = 1;
			$query = mysqli_query($conexao, "SELECT idAnimal FROM Animal ORDER BY idAnimal DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idAnimal = $dados["idAnimal"];
			}
			$idAnimal++;
			
			//Insere animal
			$query = mysqli_query($conexao,"INSERT INTO Animal VALUES(" .$idAnimal .",'" .$Nome ."','" .$Genero ."','" .$Cor ."',
			'" .$Porte ."'," .$Idade .",'" .$Caracteristicas ."','" .$QRCode ."'," .$Desaparecido ."," .$idUsuario ."," .$idRaca .")") 
			or die(mysqli_error($conexao));
			
			$resposta = mensagens(7);
		}
	}

	return $resposta;
}

function RecuperaAnimal($id){
	
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
		
		//Verifica se as informações esperadas foram recebidas
		if(!isset($dados["Nome"]) || !isset($dados["idUsuario"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			$animalCadastrado = false;
			
			//Evita SQL injection
			$Nome = mysqli_real_escape_string($conexao,$dados["Nome"]);
			$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
			
			//Consulta animal + dono no banco
			$query = mysqli_query($conexao,"SELECT * FROM Animal WHERE Nome='" .$Nome ."' and idUsuario=" .$idUsuario ."") or die(mysqli_error($conexao));
			
			
			//Verifica se foi retornado algum registro
			while($dados = mysqli_fetch_array($query))
			{
				$resposta = array('idAnimal' => $dados['idAnimal'],
					'Nome' => $dados['Nome'],
					'Genero' => $dados['Genero'],
					'Cor' => $dados['Cor'],
					'Porte' => replaceAccents($dados['Porte']),
					'Idade' => $dados['Idade'],
					'Caracteristicas' => replaceAccents($dados['Caracteristicas']),
					'QRCode' => $dados['QRCode'],
					'Desaparecido' => $dados['Desaparecido'],
					'idUsuario' => $dados['idUsuario'],
					'idRaca' => $dados['idRaca']);
							
			  $animalCadastrado = true;
			  break;
			}
			
			//Verifica se o animal foi encontrado
			if(!$animalCadastrado){
				$resposta = mensagens(8);
			}
		}
	}
	
	return $resposta;
}

function AtualizaAnimal($id){
	
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
			if(!isset($dados["Nome"]) || !isset($dados["Genero"]) || 
		   !isset($dados["Cor"]) || !isset($dados["Porte"]) || !isset($dados["Idade"]) ||
		   !isset($dados["Caracteristicas"]) || !isset($dados["QRCode"]) || !isset($dados["Desaparecido"]) ||
		   !isset($dados["idUsuario"]) || !isset($dados["idRaca"]))
			{
				$resposta = mensagens(3);
			}
			else
			{
				include("conectar.php");
				
				//Evita SQL injection
				$Nome = mysqli_real_escape_string($conexao,$dados["Nome"]);
				$Genero = mysqli_real_escape_string($conexao,$dados["Genero"]);
				$Cor = mysqli_real_escape_string($conexao,$dados["Cor"]);
				$Porte = mysqli_real_escape_string($conexao,$dados["Porte"]);
				$Idade = mysqli_real_escape_string($conexao,$dados["Idade"]);
				$Caracteristicas = mysqli_real_escape_string($conexao,$dados["Caracteristicas"]);
				$QRCode = mysqli_real_escape_string($conexao,$dados["QRCode"]);
				$Desaparecido = mysqli_real_escape_string($conexao,$dados["Desaparecido"]);
				$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
				$idRaca = mysqli_real_escape_string($conexao,$dados["idRaca"]);
				
				//Atualiza animal no banco
				$query = mysqli_query($conexao, "UPDATE Animal SET Nome = '" .$Nome ."', Genero = '" .$Genero ."', Cor = '" .$Cor ."',
				Porte = '" .$Porte ."', Idade = " .$Idade .", Caracteristicas = '" .$Caracteristicas ."', QRCode = '" .$QRCode ."', 
				Desaparecido = " .$Desaparecido .", idUsuario = " .$idUsuario .", idRaca = " .$idRaca ."  
				WHERE idAnimal=" .$id) or die(mysqli_error($conexao));
				$resposta = mensagens(10);
			}
		}
	}

	return $resposta;

}

function ExcluiAnimal($id){
	
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
		
		//Consulta usuário no banco
		$query = mysqli_query($conexao, "DELETE FROM A WHERE idAnimal=" .$id) or die(mysqli_error($conexao));
		$resposta = mensagens(11);
	}

	return $resposta;
}

function replaceAccents($str) 
{
  $search =    explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
  $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");
  return str_replace($search, $replace, $str);
}

?>