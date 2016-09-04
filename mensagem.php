<?php
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
					,array(
						"Codigo"=>6
						,"Mensagem"=>"Email ja cadastrado!"
					)
					,array(
						"Codigo"=>7
						,"Mensagem"=>"Cadastrado com sucesso!"
					)
					,array(
						"Codigo"=>8
						,"Mensagem"=>"Registro nao encontrado!"
					)
					,array(
						"Codigo"=>9
						,"Mensagem"=>"Codigo invalido!"
					)
					,array(
						"Codigo"=>10
						,"Mensagem"=>"Atualizado com sucesso!"
					)
					,array(
						"Codigo"=>11
						,"Mensagem"=>"Excluido com sucesso!"
					)
					,array(
						"Codigo"=>12
						,"Mensagem"=>"Dispositivo ja cadastrado!"
					)
					,array(
						"Codigo"=>13
						,"Mensagem"=>"Dispositivo é principal!"
					)
					,array(
						"Codigo"=>14
						,"Mensagem"=>"Um ID deve ser passado como parâmetro!"
					)
					,array(
						"Codigo"=>15
						,"Mensagem"=>"Evento ja cadastrado!"
					)
					,array(
						"Codigo"=>16
						,"Mensagem"=>"O campo Tipo deve ser passado!"
					)
				 );

	$retorno = array();
	//Busca pelo erro com o codigo informado de parâmetro
	foreach($mensagens as $item){
		if($item["Codigo"] == $codigo){
			$retorno = $item;
			break;
		}
	}
	return $retorno;
}
?>