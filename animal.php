<?php
function ListaAnimais($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta animal no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT A.idAnimal, A.Nome , A.Genero, A.Cor, A.Porte, A.Idade, A.Caracteristicas, A.QRCode, A.Foto, A.Desaparecido, A.FotoCarteira, A.DataFotoCarteira, A.idUsuario, A.idRaca, R.Nome as 'NomeRaca', R.Descricao as 'DescricaoRaca', U.Nome as 'NomeUsuario', U.Email, U.Telefone, U.Cidade, U.Bairro, E.idEspecie, E.Nome as 'NomeEspecie' FROM Animal as A INNER JOIN Usuario as U on A.idUsuario = U.idUsuario INNER JOIN Raca as R on A.idRaca = R.idRaca INNER JOIN Especie as E on E.idEspecie = R.idEspecie") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT A.idAnimal, A.Nome , A.Genero, A.Cor, A.Porte, A.Idade, A.Caracteristicas, A.QRCode, A.Foto, A.Desaparecido, A.FotoCarteira, A.DataFotoCarteira, A.idUsuario, A.idRaca, R.Nome as 'NomeRaca', R.Descricao as 'DescricaoRaca', U.Nome as 'NomeUsuario', U.Email, U.Telefone, U.Cidade, U.Bairro, E.idEspecie, E.Nome as 'NomeEspecie' FROM Animal as A INNER JOIN Usuario as U on A.idUsuario = U.idUsuario INNER JOIN Raca as R on A.idRaca = R.idRaca INNER JOIN Especie as E on E.idEspecie = R.idEspecie WHERE idAnimal = " .$id) or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idAnimal' => $dados['idAnimal'],
							'Nome' => $dados['Nome'],
							'Genero' => $dados['Genero'],
							'Cor' => $dados['Cor'],
							'Porte' => $dados['Porte'],
							'Idade' => $dados['Idade'],
							'Caracteristicas' => $dados['Caracteristicas'],
							'QRCode' => $dados['QRCode'],
							'Foto' => $dados['Foto'],
							'Desaparecido' => $dados['Desaparecido'],
							'FotoCarteira' => $dados['FotoCarteira'],
							'DataFotoCarteira' => $dados['DataFotoCarteira'],
							'idUsuario' => $dados['idUsuario'],
							'idRaca' => $dados['idRaca'],
							'NomeRaca' => $dados['NomeRaca'],
							'DescricaoRaca' => $dados['DescricaoRaca'],
							'NomeUsuario' => $dados['NomeUsuario'],
							'Email' => $dados['Email'],
							'Telefone' => $dados['Telefone'],
							'Cidade' => $dados['Cidade'],
							'Bairro' => $dados['Bairro'],
							'idEspecie' => $dados['idEspecie'],
							'NomeEspecie' => $dados['NomeEspecie']);
	}
	return $resposta;
}

function ListaAnimaisDesaparecidos($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta animal no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT A.idAnimal, A.Nome , A.Genero, A.Cor, A.Porte, A.Idade, A.Caracteristicas, A.QRCode, A.Foto, A.Desaparecido, A.FotoCarteira, A.DataFotoCarteira, A.idUsuario, A.idRaca, R.Nome as 'NomeRaca', R.Descricao as 'DescricaoRaca', U.Nome as 'NomeUsuario', U.Email, U.Telefone, U.Cidade, U.Bairro, E.idEspecie, E.Nome as 'NomeEspecie' FROM Animal as A INNER JOIN Usuario as U on A.idUsuario = U.idUsuario INNER JOIN Raca as R on A.idRaca = R.idRaca INNER JOIN Especie as E on E.idEspecie = R.idEspecie WHERE A.Desaparecido = 1") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT A.idAnimal, A.Nome , A.Genero, A.Cor, A.Porte, A.Idade, A.Caracteristicas, A.QRCode, A.Foto, A.Desaparecido, A.FotoCarteira, A.DataFotoCarteira, A.idUsuario, A.idRaca, R.Nome as 'NomeRaca', R.Descricao as 'DescricaoRaca', U.Nome as 'NomeUsuario', U.Email, U.Telefone, U.Cidade, U.Bairro, E.idEspecie, E.Nome as 'NomeEspecie' FROM Animal as A INNER JOIN Usuario as U on A.idUsuario = U.idUsuario INNER JOIN Raca as R on A.idRaca = R.idRaca INNER JOIN Especie as E on E.idEspecie = R.idEspecie WHERE A.idAnimal = " .$id . " and A.Desaparecido = 1") or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idAnimal' => $dados['idAnimal'],
							'Nome' => $dados['Nome'],
							'Genero' => $dados['Genero'],
							'Cor' => $dados['Cor'],
							'Porte' => $dados['Porte'],
							'Idade' => $dados['Idade'],
							'Caracteristicas' => $dados['Caracteristicas'],
							'QRCode' => $dados['QRCode'],
							'Foto' => $dados['Foto'],
							'Desaparecido' => $dados['Desaparecido'],
							'FotoCarteira' => $dados['FotoCarteira'],
							'DataFotoCarteira' => $dados['DataFotoCarteira'],
							'idUsuario' => $dados['idUsuario'],
							'idRaca' => $dados['idRaca'],
							'NomeRaca' => $dados['NomeRaca'],
							'DescricaoRaca' => $dados['DescricaoRaca'],
							'NomeUsuario' => $dados['NomeUsuario'],
							'Email' => $dados['Email'],
							'Telefone' => $dados['Telefone'],
							'Cidade' => $dados['Cidade'],
							'Bairro' => $dados['Bairro'],
							'idEspecie' => $dados['idEspecie'],
							'NomeEspecie' => $dados['NomeEspecie']);
	}
	return $resposta;
}

function InsereAnimal(){
	
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
		   !isset($dados["Caracteristicas"]) || !isset($dados["QRCode"]) || !isset($dados["Foto"]) || !isset($dados["Desaparecido"]) ||
		   !isset($dados["FotoCarteira"]) || !isset($dados["DataFotoCarteira"]) ||
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
			$Foto = mysqli_real_escape_string($conexao,$dados["Foto"]);
			$Desaparecido = mysqli_real_escape_string($conexao,$dados["Desaparecido"]);
			$FotoCarteira = mysqli_real_escape_string($conexao,$dados["FotoCarteira"]);
			$DataFotoCarteira = mysqli_real_escape_string($conexao,$dados["DataFotoCarteira"]);
			$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
			$idRaca = mysqli_real_escape_string($conexao,$dados["idRaca"]);
			
			//Faz upload da imagem
			include("uploadDeFotos.php");
			$caminhoFoto = uploadDeFotos($Foto);
					
			//Recupera idAnimal para incrementar 1
			$idAnimal = 1;
			$query = mysqli_query($conexao, "SELECT idAnimal FROM Animal ORDER BY idAnimal DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idAnimal = $dados["idAnimal"];
			}
			$idAnimal++;
			
			//Insere animal
			$query = mysqli_query($conexao,"INSERT INTO Animal VALUES(" .$idAnimal .",'" .$Nome ."','" .$Genero ."','" .$Cor ."',
			'" .$Porte ."'," .$Idade .",'" .$Caracteristicas ."','" .$QRCode ."','" .$caminhoFoto ."'," .$Desaparecido .",'" .$caminhoFotoCarteira ."','" .$DataFotoCarteira ."'," .$idUsuario ."," .$idRaca .")") 
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
			$query = mysqli_query($conexao,"SELECT A.idAnimal, A.Nome, A.Genero, A.Cor, A.Porte, A.Idade, A.Caracteristicas, A.QRCode, A.Foto, A.Desaparecido, A.FotoCarteira, A.DataFotoCarteira, A.idUsuario, A.idRaca, R.Nome as 'NomeRaca', R.Descricao as 'DescricaoRaca', U.Nome as 'NomeUsuario', U.Email, U.Telefone, U.Cidade, U.Bairro, E.idEspecie, E.Nome as 'NomeEspecie' FROM Animal as A INNER JOIN Usuario as U on A.idUsuario = U.idUsuario INNER JOIN Raca as R on A.idRaca = R.idRaca INNER JOIN Especie as E on E.idEspecie = R.idEspecie WHERE A.Nome='" .$Nome ."' and A.idUsuario=" .$idUsuario ."") or die(mysqli_error($conexao));
			
			
			//Verifica se foi retornado algum registro
			while($dados = mysqli_fetch_array($query))
			{
				$resposta[] = array('idAnimal' => $dados['idAnimal'],
							'Nome' => $dados['Nome'],
							'Genero' => $dados['Genero'],
							'Cor' => $dados['Cor'],
							'Porte' => $dados['Porte'],
							'Idade' => $dados['Idade'],
							'Caracteristicas' => $dados['Caracteristicas'],
							'QRCode' => $dados['QRCode'],
							'Foto' => $dados['Foto'],
							'Desaparecido' => $dados['Desaparecido'],
							'FotoCarteira' => $dados['FotoCarteira'],
							'DataFotoCarteira' => $dados['DataFotoCarteira'],
							'idUsuario' => $dados['idUsuario'],
							'idRaca' => $dados['idRaca'],
							'NomeRaca' => $dados['NomeRaca'],
							'DescricaoRaca' => $dados['DescricaoRaca'],
							'NomeUsuario' => $dados['NomeUsuario'],
							'Email' => $dados['Email'],
							'Telefone' => $dados['Telefone'],
							'Cidade' => $dados['Cidade'],
							'Bairro' => $dados['Bairro'],
							'idEspecie' => $dados['idEspecie'],
							'NomeEspecie' => $dados['NomeEspecie']);
							
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

function ListaAnimaisDoUsuario($id){
	
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
		if(!isset($dados["Email"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$email = mysqli_real_escape_string($conexao,$dados["Email"]);
			
			//Consulta animal + dono no banco
			$query = mysqli_query($conexao,"SELECT A.idAnimal, A.Nome, A.Genero, A.Cor, A.Porte, A.Idade, A.Caracteristicas, A.QRCode, A.Foto, A.Desaparecido, A.FotoCarteira, A.DataFotoCarteira, A.idUsuario, A.idRaca, R.Nome as 'NomeRaca', R.Descricao as 'DescricaoRaca', U.Nome as 'NomeUsuario', U.Email, U.Telefone, U.Cidade, U.Bairro, E.idEspecie, E.Nome as 'NomeEspecie' FROM Animal as A INNER JOIN Usuario as U on A.idUsuario = U.idUsuario INNER JOIN Raca as R on A.idRaca = R.idRaca INNER JOIN Especie as E on E.idEspecie = R.idEspecie WHERE U.Email='" .$email ."'") or die(mysqli_error($conexao));
			
			
			//Verifica se foi retornado algum registro
			while($dados = mysqli_fetch_array($query))
			{
				$resposta[] = array('idAnimal' => $dados['idAnimal'],
							'Nome' => $dados['Nome'],
							'Genero' => $dados['Genero'],
							'Cor' => $dados['Cor'],
							'Porte' => $dados['Porte'],
							'Idade' => $dados['Idade'],
							'Caracteristicas' => $dados['Caracteristicas'],
							'QRCode' => $dados['QRCode'],
							'Foto' => $dados['Foto'],
							'Desaparecido' => $dados['Desaparecido'],
							'FotoCarteira' => $dados['FotoCarteira'],
							'DataFotoCarteira' => $dados['DataFotoCarteira'],
							'idUsuario' => $dados['idUsuario'],
							'idRaca' => $dados['idRaca'],
							'NomeRaca' => $dados['NomeRaca'],
							'DescricaoRaca' => $dados['DescricaoRaca'],
							'NomeUsuario' => $dados['NomeUsuario'],
							'Email' => $dados['Email'],
							'Telefone' => $dados['Telefone'],
							'Cidade' => $dados['Cidade'],
							'Bairro' => $dados['Bairro'],
							'idEspecie' => $dados['idEspecie'],
							'NomeEspecie' => $dados['NomeEspecie']);
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
		   !isset($dados["Caracteristicas"]) || !isset($dados["Foto"]) || !isset($dados["Desaparecido"]) ||
		   !isset($dados["FotoCarteira"]) || !isset($dados["DataFotoCarteira"]) ||
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
				$Foto = mysqli_real_escape_string($conexao,$dados["Foto"]);
				$Desaparecido = mysqli_real_escape_string($conexao,$dados["Desaparecido"]);
				$FotoCarteira = mysqli_real_escape_string($conexao,$dados["FotoCarteira"]);
				$DataFotoCarteira = mysqli_real_escape_string($conexao,$dados["DataFotoCarteira"]);
				$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
				$idRaca = mysqli_real_escape_string($conexao,$dados["idRaca"]);
				
				$update = "UPDATE Animal SET Nome = '" .$Nome ."', Genero = '" .$Genero ."', Cor = '" .$Cor ."',
				Porte = '" .$Porte ."', Idade = " .$Idade .", Caracteristicas = '" .$Caracteristicas ."', Desaparecido = " 
				.$Desaparecido .", idUsuario = " .$idUsuario .", idRaca = " .$idRaca;
				
				if($Foto != ""){
					//Faz upload da imagem
					include("uploadDeFotos.php");
					$caminhoFoto = uploadDeFotos($Foto);
					
					$update .= ", Foto = '" .$caminhoFoto ."'";
				}
				
				$update .= " WHERE idAnimal=" .$id;

				//Atualiza animal no banco
				$query = mysqli_query($conexao, $update) or die(mysqli_error($conexao));
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
		
		//Exclui fotos do animal
		$query = mysqli_query($conexao, "DELETE FROM Foto WHERE idAnimal=" .$id) or die(mysqli_error($conexao));
		
		//Exclui localizações
		$query = mysqli_query($conexao,"SELECT idDesaparecimento FROM Desaparecimento WHERE idAnimal = " .$id) or die(mysqli_error($conexao));
		while($dados = mysqli_fetch_array($query))
		{
			$idDesaparecimento = $dados['idDesaparecimento'];
			$query2 = mysqli_query($conexao, "DELETE FROM Localizacao WHERE idDesaparecimento=" .$idDesaparecimento) or die(mysqli_error($conexao));
		}
		
		//Exclui desaparecimentos do animal
		$query = mysqli_query($conexao, "DELETE FROM Desaparecimento WHERE idAnimal=" .$id) or die(mysqli_error($conexao));
		
		//Exclui eventos do animal
		$query = mysqli_query($conexao,"SELECT idEvento FROM Evento WHERE idAnimal = " .$id) or die(mysqli_error($conexao));
		while($dados = mysqli_fetch_array($query))
		{
			$idEvento = $dados['idEvento'];
			$query2 = mysqli_query($conexao, "DELETE FROM Medicamento WHERE idEvento=" .$idEvento) or die(mysqli_error($conexao));
			$query2 = mysqli_query($conexao, "DELETE FROM Vacina WHERE idEvento=" .$idEvento) or die(mysqli_error($conexao));
			$query2 = mysqli_query($conexao, "DELETE FROM Compromisso WHERE idEvento=" .$idEvento) or die(mysqli_error($conexao));
		}
		
		//Exclui eventos do animal
		$query = mysqli_query($conexao, "DELETE FROM Evento WHERE idAnimal=" .$id) or die(mysqli_error($conexao));
		
		//Exclui animal
		$query = mysqli_query($conexao, "DELETE FROM Animal WHERE idAnimal=" .$id) or die(mysqli_error($conexao));		
		
		$resposta = mensagens(11);
	}

	return $resposta;
}

function EncontrarAnimal($id){
	
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
		if(!isset($dados["Latitude"]) || !isset($dados["Longitude"]) || 
		   !isset($dados["Local"]) || $id == 0)
		{
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$Latitude = mysqli_real_escape_string($conexao,$dados["Latitude"]);
			$Longitude = mysqli_real_escape_string($conexao,$dados["Longitude"]);
			$Local = mysqli_real_escape_string($conexao,$dados["Local"]);
			
			//Recupera idUsuario e nome do animal
			$idUsuario = 0;
			$nome = "";
			$query = mysqli_query($conexao, "SELECT idUsuario, Nome, Desaparecido FROM Animal WHERE idAnimal = "  .$id) or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idUsuario = $dados["idUsuario"];
				$nome = $dados["Nome"];
				$desaparecido = $dados["Desaparecido"];
			}
			
			//Recupera último desaparecimento gerado
			$idDesaparecimento = 0;
			$query = mysqli_query($conexao, "SELECT idDesaparecimento FROM Desaparecimento WHERE idAnimal = " .$id ." ORDER BY idDesaparecimento DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idDesaparecimento = $dados["idDesaparecimento"];
			}
			
			//Recupera último idLocalizacao gerado
			$idLocalizacao = 0;
			$query = mysqli_query($conexao, "SELECT idLocalizacao FROM Localizacao ORDER BY idLocalizacao DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idLocalizacao = $dados["idLocalizacao"];
			}
			$idLocalizacao++;
			
			//Recupera último idNotificacao gerado
			$idNotificacao = 0;
			$query = mysqli_query($conexao, "SELECT idNotificacao FROM Notificacao ORDER BY idNotificacao DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idNotificacao = $dados["idNotificacao"];
			}
			$idNotificacao++;
			
			if($nome == ""){
				$resposta = mensagens(19);
			}else{
				if($idDesaparecimento == 0 || $desaparecido == 0){
					$resposta = mensagens(17);
				}else{
					//Insere localização
					$query = mysqli_query($conexao,"INSERT INTO Localizacao VALUES(" .$idLocalizacao .",'" .$Latitude ."','" .$Longitude ."'," .$idDesaparecimento .")") 
					or die(mysqli_error($conexao));
					
					//Carrega data/hora atual
					date_default_timezone_set('America/Brasilia');
					$startDate = time();
					$DataNotificacao = date('Y/m/d H:i:s', strtotime('-2 hour', $startDate));
					$DataNotificacaoTexto = date('d/m/Y H:i:s', strtotime('-2 hour', $startDate));
					
					$Mensagem = "Seu pet " .$nome ." foi visto na data " . $DataNotificacaoTexto . " em " .$Local .". As coordenadas são latitude = " .$Latitude ." e longitude = " .$Longitude .".";
					
					//Insere notificação
					$query = mysqli_query($conexao,"INSERT INTO Notificacao VALUES(" .$idNotificacao .",'" .$Mensagem ."','" .$DataNotificacao ."'," .$idUsuario .",0,0)") 
					or die(mysqli_error($conexao));
					
					$resposta = mensagens(18);
				}
			}
		}
	}

	return $resposta;
}

function AtualizaQRCode($id){
	
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
			if(!isset($dados["QRCode"]))
			{
				$resposta = mensagens(3);
			}
			else
			{
				include("conectar.php");
				include("uploadDeFotos.php");
				
				//Evita SQL injection
				$QRCode = mysqli_real_escape_string($conexao,$dados["QRCode"]);
				
				$caminho = uploadDeQRCode($QRCode);
				
				//Atualiza animal no banco
				$query = mysqli_query($conexao, "UPDATE Animal SET QRCode = '" .$caminho ."' WHERE idAnimal=" .$id) or die(mysqli_error($conexao));
				$resposta = array("QRCode" => $caminho);
			}
		}
	}

	return $resposta;

}

function AtualizaFotoCarteirinha($id){
	
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
			if(!isset($dados["FotoCarteira"]))
			{
				$resposta = mensagens(3);
			}
			else
			{
				include("conectar.php");
				include("uploadDeFotos.php");
				
				//Evita SQL injection
				$FotoCarteira = mysqli_real_escape_string($conexao,$dados["FotoCarteira"]);
				$DataFotoCarteira = mysqli_real_escape_string($conexao,$dados["DataFotoCarteira"]);
				
				$caminhoFotoCarteira = uploadDeFotos($FotoCarteira);
				
				//Atualiza animal no banco
				$query = mysqli_query($conexao, "UPDATE Animal SET FotoCarteira = '" .$caminhoFotoCarteira ."', DataFotoCarteira = '" .$DataFotoCarteira . "' WHERE idAnimal=" .$id) or die(mysqli_error($conexao));
				$resposta = array("FotoCarteira" => $caminhoFotoCarteira);
			}
		}
	}

	return $resposta;

}
?>