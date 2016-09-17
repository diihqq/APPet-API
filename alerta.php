<?php
function ListaAlertas($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta alerta no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT idAlerta, NivelAlerta, Frequencia FROM Alerta") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT idAlerta, NivelAlerta, Frequencia FROM Alerta WHERE idAlerta = " .$id) or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => $dados['NivelAlerta'],
							'Frequencia' => $dados['Frequencia']);
	}
	
	return $resposta;
}

function AtualizaAlerta($id){
	
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
			if(!isset($dados["Frequencia"])){
				$resposta = mensagens(3);
			}
			else{
				include("conectar.php");
				
				//Evita SQL injection
				$id = mysqli_real_escape_string($conexao,$id);
				$Frequencia = mysqli_real_escape_string($conexao,$dados["Frequencia"]);
				
				//Consulta alerta no banco
				$query = mysqli_query($conexao, "UPDATE Alerta SET Frequencia = '" .$Frequencia ."' WHERE idAlerta=" .$id) or die(mysqli_error($conexao));
				$resposta = mensagens(10);
			}
		}
	}

	return $resposta;

}

function ExcluiAlerta($id){
	
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
		
		//Consulta alerta no banco
		$query = mysqli_query($conexao, "DELETE FROM Alerta WHERE idAlerta=" .$id) or die(mysqli_error($conexao));
		$resposta = mensagens(11);
	}

	return $resposta;

}
?>