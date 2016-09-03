<?php
function ListaNotificacoesPorUsuario($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta foto no banco
	if($id == 0){
		$resposta = mensagens(14);
	}else{
		$query = mysqli_query($conexao,"SELECT N.idNotificacao, N.Mensagem, U.Nome, U.Email, U.Telefone, U.Cidade, U.Bairro FROM Notificacao as N INNER JOIN Usuario as U on N.idUsuario = U.idUsuario WHERE U.idUsuario = " .$id) or die(mysqli_error($conexao));
	
		//faz um looping e cria um array com os campos da consulta
		while($dados = mysqli_fetch_array($query))
		{
			$resposta[] = array('idNotificacao' => $dados['idNotificacao'],
								'Mensagem' => utf8_encode($dados['Mensagem']),
								'Nome' => utf8_encode($dados['Nome']),
								'Email' => utf8_encode($dados['Email']),
								'Telefone' => $dados['Telefone'],
								'Cidade' => utf8_encode($dados['Cidade']),
								'Bairro' => utf8_encode($dados['Bairro']));
		}
	}
	return $resposta;
}

function InsereNotificacao(){
	
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
		if(!isset($dados["Mensagem"]) || !isset($dados["idUsuario"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$Mensagem = mysqli_real_escape_string($conexao,$dados["Mensagem"]);
			$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
			

			//Recupera o próximo ID de Notificacao
			$idNotificacao = 1;
			$query = mysqli_query($conexao, "SELECT idNotificacao FROM Notificacao ORDER BY idNotificacao DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idNotificacao = $dados["idNotificacao"];
			}
			$idNotificacao++;
			
			//Insere usuário
			$query = mysqli_query($conexao,"INSERT INTO Notificacao VALUES(" .$idNotificacao .",'" .$Mensagem ."','" .$idUsuario ."')") or die(mysqli_error($conexao));
			$resposta = mensagens(7);

		}
	}

	return $resposta;
}

function ExcluiNotificacao($id){
	
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
		
		//Consulta Notificacao no banco
		$query = mysqli_query($conexao, "DELETE FROM Notificacao WHERE idNotificacao=" .$id) or die(mysqli_error($conexao));
		$resposta = mensagens(11);
	}

	return $resposta;

}
?>