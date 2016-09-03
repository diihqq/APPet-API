<?php 
	//Inclui arquivos com as funчѕes da API.
	include('mensagem.php');
	include('usuario.php');
	include('raca.php');
	include('especie.php');
	include('dispositivo.php');
	include('animal.php');
	include('estabelecimentoFavorito.php');
	include('foto.php');
	include('notificacao.php');
	include('desaparecimento.php');
	include('localizacao.php');

    //Recupera os valores da URL
	$metodo = $_SERVER['REQUEST_METHOD'];
	$caminho = $_SERVER['PATH_INFO'];
	$array = explode("/",$caminho);
	$funcao = $array[1];
	$id = 0;
	if(isset($array[2])){
		$id = $array[2];
	}

	$resposta = array();

	//Verifica se o mщtodo utilizado na request щ POST
	if($metodo == "POST"){	
		//Verifica se a funчуo informada existe.
		if(function_exists($funcao)){
			//Chama funчуo.
			$resposta = $funcao($id);
		}
		else{
			//Caso a funчуo nao exista retorna erro.
			$resposta = mensagens(1);
		}
	}
	else
	{
		$resposta = mensagens(1);
	}
    
    //Retorna a resposta
	header('Content-Type: application/json');
    echo json_encode($resposta);
?>