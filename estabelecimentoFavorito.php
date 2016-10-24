<?php
function ListaEstFavoritosPorUsuario($id){
	include("conectar.php");
	
	//Recupera conteudo recebido na request
	$conteudo = file_get_contents("php://input");
	$resposta = array();
	
	$id = mysqli_real_escape_string($conexao,$id);
	
	//Verifica se o conteudo foi recebido
	if(empty($conteudo)){
		$resposta = mensagens(2);
	}else{
		
		//Converte o json recebido pra array
		$dados = json_decode($conteudo,true);
		
		//Verifica se as informações esperadas foram recebidas
		if(!isset($dados["Email"])){
			$resposta = mensagens(3);
		}
		else{
			
			//Evita SQL injection
			$email = mysqli_real_escape_string($conexao,$dados["Email"]);
			
			$query = mysqli_query($conexao,"SELECT F.idEstabelecimentoFavorito, F.Nome as 'NomeEstFavorito', F.Latitude, F.Longitude, F.idUsuario, U.Nome as 'NomeUsuario', U.Email, U.Telefone, U.Cidade, U.Bairro, F.Tipo, F.Endereco FROM EstabelecimentoFavorito as F INNER JOIN Usuario as U on F.idUsuario = U.idUsuario WHERE U.Email = '" .$email ."'") or die(mysqli_error($conexao));
	
			//faz um looping e cria um array com os campos da consulta
			while($dados = mysqli_fetch_array($query))
			{
				$resposta[] = array('idEstabelecimentoFavorito' => $dados['idEstabelecimentoFavorito'],
									'NomeEstFavorito' => $dados['NomeEstFavorito'],
									'Latitude' => $dados['Latitude'],
									'Longitude' => $dados['Longitude'],
									'idUsuario' => $dados['idUsuario'],
									'NomeUsuario' => $dados['NomeUsuario'],
									'Email' => $dados['Email'],
									'Telefone' => $dados['Telefone'],
									'Cidade' => $dados['Cidade'],
									'Bairro' => $dados['Bairro'],
									'Tipo' => $dados['Tipo'],
									'Endereco' => $dados['Endereco']);
			}
		}
	}
	
	return $resposta;
}

function InsereEstabelecimentoFavorito(){
	
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
		if(!isset($dados["Nome"]) || !isset($dados["Latitude"]) || 
		   !isset($dados["Longitude"]) || !isset($dados["idUsuario"]) ||
		   !isset($dados["Tipo"]) || !isset($dados["Endereco"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			$EstabelecimentoCadastrado = false;
			
			//Evita SQL injection
			$Nome = mysqli_real_escape_string($conexao,$dados["Nome"]);
			$Latitude = mysqli_real_escape_string($conexao,$dados["Latitude"]);
			$Longitude = mysqli_real_escape_string($conexao,$dados["Longitude"]);
			$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
			$Tipo = mysqli_real_escape_string($conexao,$dados["Tipo"]);
			$Endereco = mysqli_real_escape_string($conexao,$dados["Endereco"]);
			
			//Consulta estabelecimento favorito no banco
			$query = mysqli_query($conexao,"SELECT idEstabelecimentoFavorito, Nome, Latitude, Longitude, idUsuario FROM EstabelecimentoFavorito WHERE Nome='" .$Nome ."'") or die(mysqli_error($conexao));
			
			//Verifica se foi retornado algum registro
			while($dados = mysqli_fetch_array($query))
			{
			  $EstabelecimentoCadastrado = true;
			  break;
			}
			
			if($EstabelecimentoCadastrado){
				$resposta = mensagens(20);
			}else{
				//Recupera o próximo ID de Estabelecimentos Favoritos
				$idEstabelecimentoFavorito = 0;
				$query = mysqli_query($conexao, "SELECT idEstabelecimentoFavorito FROM EstabelecimentoFavorito ORDER BY idEstabelecimentoFavorito DESC LIMIT 1") or die(mysqli_error($conexao));
				while($dados = mysqli_fetch_array($query)){
					$idEstabelecimentoFavorito= $dados["idEstabelecimentoFavorito"];
				}
				$idEstabelecimentoFavorito++;
				
				//Insere estabelecimento
				$query = mysqli_query($conexao,"INSERT INTO EstabelecimentoFavorito VALUES(" .$idEstabelecimentoFavorito .",'" .$Nome ."','" .$Latitude ."','" .$Longitude ."'," .$idUsuario .",'" .$Tipo ."','" .$Endereco ."')") or die(mysqli_error($conexao));
				$resposta = mensagens(7);
			}
		}
	}

	return $resposta;
}

function ExcluiEstFavorito($id){
	
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

		//Consulta dispositivo no banco e o deleta
		$query = mysqli_query($conexao, "DELETE FROM EstabelecimentoFavorito WHERE idEstabelecimentoFavorito=" .$id) or die(mysqli_error($conexao));
		$resposta = mensagens(11);
	}

	return $resposta;

}


?>