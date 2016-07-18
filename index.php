<?php 
    //Recupera os valores da URL
    $metodo = "";
    if(isset($_GET["metodo"])){
        $metodo = $_GET["metodo"];
    }
    
    $parametro = "";
    if(isset($_GET["parametro"])){
        $parametro = $_GET["parametro"]; 
    }
    
    $resposta = array();

    //Verifica qual metodo foi chamado
    switch($metodo){
        case "autenticacao":
            $resposta = autenticacao();
            break;
        default:
            echo "mensagens";
            $resposta = mensagens(1);
            break;
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
    
    function mensagens($codigo){
        $mensagens = array(
                        array(
                            "Codigo"=>1
                            ,"Mensagem"=>"Caminho especificado nao encontrado"
                        )
                        ,array(
                            "Codigo"=>2
                            ,"Mensagem"=>"Nenhum dado recebido"
                        )
                        ,array(
                            "Codigo"=>3
                            ,"Mensagem"=>"Estrutura de dados diferente do esperado"
                        )
                        ,array(
                            "Codigo"=>4
                            ,"Mensagem"=>"Usuario autenticado com sucesso"
                        )
                        ,array(
                            "Codigo"=>5
                            ,"Mensagem"=>"Usuario ou senha incorretos"
                        )
                     );

        $retorno = array();
        //Busca pelo erro com o codigo informado de parтmetro
        foreach($mensagens as $item){
            if($item["Codigo"] == $codigo){
                $retorno = $item;
                break;
            }
        }
        return $retorno;
    }
    /*$Usuario = array("idUsuario"=>"1", "Email"=>"felipe_d_o@hotmail.com", "Nome"=>"Felipe", "Telefone"=>"39076099");
    $teste = array();
    array_push($teste,$Usuario);
    array_push($teste,$Usuario);
    array_push($teste,$Usuario);*/
    //echo json_encode($teste);
    //echo $metodo;
?>