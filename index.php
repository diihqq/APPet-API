<?php 
	//Inclui arquivos com as funчѕes da API.
	include('mensagem.php');
	echo "aooo";
    //Recupera os valores da URL
	$metodo = $_SERVER['REQUEST_METHOD'];
	//$funcao = $_SERVER['PATH_INFO'];
	//echo $funcao;

	$resposta = array();
	
	//Verifica se o mщtodo utilizado na request щ POST
	if($metodo == "POST"){	
		//Verifica qual metodo foi chamado
		switch($funcao){
			case "autenticacao":
				$resposta = autenticacao();
				break;
			default:
				echo "mensagens";
				$resposta = mensagens(1);
				break;
		}
	}
	else
	{
		$resposta = mensagens(1);
	}
    
    //Retorna a resposta
    resposta($resposta);
        
    /*============================================FUNЧеES DA API===================================================*/
    
    //Autentica usuсrio na aplicaчуo
    function autenticacao(){
        $conteudo = file_get_contents('php://input');
        $resposta = array();
        
        //Verifica se os dados foram recebidos
        if(empty($conteudo)){
            $resposta = mensagens(2);
        }
        else{
            $credenciais = json_decode(file_get_contents('php://input'),true);
            
            //Verifica se as infromaчѕes esperadas foram recebidas
            if(!isset($credenciais["usuario"]) || !isset($credenciais["senha"])){
                $resposta = mensagens(3);
            }
            else{
                include("conectar.php");

                $autenticado = false;
                
                //Evita SQL injection
                $email = mysqli_real_escape_string($conect,$credenciais["usuario"]);
                $senha = mysqli_real_escape_string($conect,$credenciais["senha"]);

                //Consulta usuсrio no banco
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
        
        return $resposta;
    }
    
    //Funчуo para retornar a resposta ao cliente
    function resposta($conteudo){
        header('Content-Type: application/json');
        echo json_encode($conteudo);
    }
?>