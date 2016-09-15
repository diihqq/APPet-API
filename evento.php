<?php
function ListaEventos($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, M.Inicio, M.Fim, M.FrequenciaDiaria, M.HorasDeEspera, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora FROM Evento as E LEFT JOIN Medicamento as M on E.idEvento = M.idEvento LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, M.Inicio, M.Fim, M.FrequenciaDiaria, M.HorasDeEspera, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora FROM Evento as E LEFT JOIN Medicamento as M on E.idEvento = M.idEvento LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.idEvento = " .$id) or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idEvento' => $dados['idEvento'],
							'Nome' => utf8_encode($dados['Nome']),
							'Observacoes' => utf8_encode($dados['Observacoes']),
							'FlagAlerta' => $dados['FlagAlerta'],
							'idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => utf8_encode($dados['NivelAlerta']),
							'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
							'idAnimal' => $dados['idAnimal'],
							'Tipo' => utf8_encode($dados['Tipo']),
							'Inicio' => $dados['Inicio'],
							'Fim' => $dados['Fim'],
							'FrequenciaDiaria' => $dados['FrequenciaDiaria'],
							'HorasDeEspera' => $dados['HorasDeEspera'],
							'Aplicada' => $dados['Aplicada'],
							'DataAplicacao' => $dados['DataAplicacao'],
							'DataValidade' => $dados['DataValidade'],
							'FrequenciaAnual' => $dados['FrequenciaAnual'],
							'QtdDoses' => $dados['QtdDoses'],
							'NomeLocal' => utf8_encode($dados['NomeLocal']),
							'Latitude' => utf8_encode($dados['Latitude']),
							'Longitude' => utf8_encode($dados['Longitude']),
							'DataHora' => $dados['DataHora']);
	}
	
	return $resposta;
}

function ListaEventosPorUsuario($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$resposta = mensagens(9);
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, AN.Nome as 'NomeAnimal', AN.Genero, AN.Cor, AN.Cor, AN.Porte, AN.Idade, AN.Caracteristicas, AN.QRCode, AN.Desaparecido, AN.idUsuario, AN.idRaca,  M.Inicio, M.Fim, M.FrequenciaDiaria, M.HorasDeEspera, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora FROM Evento as E LEFT JOIN Medicamento as M on E.idEvento = M.idEvento LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta LEFT JOIN Animal as AN on E.idAnimal = AN.idAnimal WHERE AN.idUsuario = ".$id ." ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idEvento' => $dados['idEvento'],
							'Nome' => utf8_encode($dados['Nome']),
							'Observacoes' => utf8_encode($dados['Observacoes']),
							'FlagAlerta' => $dados['FlagAlerta'],
							'idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => utf8_encode($dados['NivelAlerta']),
							'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
							'idAnimal' => $dados['idAnimal'],
							'Tipo' => utf8_encode($dados['Tipo']),
							'NomeAnimal' => utf8_encode($dados['NomeAnimal']),
							'Genero' => utf8_encode($dados['Genero']),
							'Cor' => utf8_encode($dados['Cor']),
							'Porte' => utf8_encode($dados['Porte']),
							'Idade' => $dados['Idade'],
							'Caracteristicas' => utf8_encode($dados['Caracteristicas']),
							'QRCode' => utf8_encode($dados['QRCode']),
							'Desaparecido' => $dados['Desaparecido'],
							'idUsuario' => $dados['idUsuario'],
							'idRaca' => $dados['idRaca'],
							'Inicio' => $dados['Inicio'],
							'Fim' => $dados['Fim'],
							'FrequenciaDiaria' => $dados['FrequenciaDiaria'],
							'HorasDeEspera' => $dados['HorasDeEspera'],
							'Aplicada' => $dados['Aplicada'],
							'DataAplicacao' => $dados['DataAplicacao'],
							'DataValidade' => $dados['DataValidade'],
							'FrequenciaAnual' => $dados['FrequenciaAnual'],
							'QtdDoses' => $dados['QtdDoses'],
							'NomeLocal' => utf8_encode($dados['NomeLocal']),
							'Latitude' => utf8_encode($dados['Latitude']),
							'Longitude' => utf8_encode($dados['Longitude']),
							'DataHora' => $dados['DataHora']);
	}
	
	return $resposta;
}

function ListaEventosPorAnimal($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$resposta = mensagens(9);
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, M.Inicio, M.Fim, M.FrequenciaDiaria, M.HorasDeEspera, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora FROM Evento as E LEFT JOIN Medicamento as M on E.idEvento = M.idEvento LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.idAnimal = ".$id ." ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idEvento' => $dados['idEvento'],
							'Nome' => utf8_encode($dados['Nome']),
							'Observacoes' => utf8_encode($dados['Observacoes']),
							'FlagAlerta' => $dados['FlagAlerta'],
							'idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => utf8_encode($dados['NivelAlerta']),
							'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
							'idAnimal' => $dados['idAnimal'],
							'Tipo' => utf8_encode($dados['Tipo']),
							'Inicio' => $dados['Inicio'],
							'Fim' => $dados['Fim'],
							'FrequenciaDiaria' => $dados['FrequenciaDiaria'],
							'HorasDeEspera' => $dados['HorasDeEspera'],
							'Aplicada' => $dados['Aplicada'],
							'DataAplicacao' => $dados['DataAplicacao'],
							'DataValidade' => $dados['DataValidade'],
							'FrequenciaAnual' => $dados['FrequenciaAnual'],
							'QtdDoses' => $dados['QtdDoses'],
							'NomeLocal' => utf8_encode($dados['NomeLocal']),
							'Latitude' => utf8_encode($dados['Latitude']),
							'Longitude' => utf8_encode($dados['Longitude']),
							'DataHora' => $dados['DataHora']);
	}
	
	return $resposta;
}

function ListaVacinas($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses FROM Evento as E LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Vacina' ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses FROM Evento as E LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Vacina' AND E.idEvento = " .$id) or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idEvento' => $dados['idEvento'],
							'Nome' => utf8_encode($dados['Nome']),
							'Observacoes' => utf8_encode($dados['Observacoes']),
							'FlagAlerta' => $dados['FlagAlerta'],
							'idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => utf8_encode($dados['NivelAlerta']),
							'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
							'idAnimal' => $dados['idAnimal'],
							'Tipo' => utf8_encode($dados['Tipo']),
							'Aplicada' => $dados['Aplicada'],
							'DataAplicacao' => $dados['DataAplicacao'],
							'DataValidade' => $dados['DataValidade'],
							'FrequenciaAnual' => $dados['FrequenciaAnual'],
							'QtdDoses' => $dados['QtdDoses']);
	}
	
	return $resposta;
}

function ListaMedicamentos($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, M.Inicio, M.Fim, M.FrequenciaDiaria, M.HorasDeEspera FROM Evento as E LEFT JOIN Medicamento as M on E.idEvento = M.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Medicamento' ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, M.Inicio, M.Fim, M.FrequenciaDiaria, M.HorasDeEspera FROM Evento as E LEFT JOIN Medicamento as M on E.idEvento = M.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Medicamento' AND E.idEvento = " .$id) or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idEvento' => $dados['idEvento'],
							'Nome' => utf8_encode($dados['Nome']),
							'Observacoes' => utf8_encode($dados['Observacoes']),
							'FlagAlerta' => $dados['FlagAlerta'],
							'idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => utf8_encode($dados['NivelAlerta']),
							'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
							'idAnimal' => $dados['idAnimal'],
							'Tipo' => utf8_encode($dados['Tipo']),
							'Inicio' => $dados['Inicio'],
							'Fim' => $dados['Fim'],
							'FrequenciaDiaria' => $dados['FrequenciaDiaria'],
							'HorasDeEspera' => $dados['HorasDeEspera']);
	}
	
	return $resposta;
}

function ListaCompromissos($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora FROM Evento as E LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Compromisso' ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora FROM Evento as E LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Compromisso' AND E.idEvento = " .$id) or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idEvento' => $dados['idEvento'],
							'Nome' => utf8_encode($dados['Nome']),
							'Observacoes' => utf8_encode($dados['Observacoes']),
							'FlagAlerta' => $dados['FlagAlerta'],
							'idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => utf8_encode($dados['NivelAlerta']),
							'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
							'idAnimal' => $dados['idAnimal'],
							'Tipo' => utf8_encode($dados['Tipo']),
							'NomeLocal' => utf8_encode($dados['NomeLocal']),
							'Latitude' => utf8_encode($dados['Latitude']),
							'Longitude' => utf8_encode($dados['Longitude']),
							'DataHora' => $dados['DataHora']);
	}
	
	return $resposta;
}

function QtdVacinasNaoAplicadas($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT Count(Aplicada) as 'QtdVacinasNaoAplicadas' FROM Vacina WHERE Aplicada = 0") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT Count(Aplicada) as 'QtdVacinasNaoAplicadas' FROM Vacina WHERE Aplicada = 0") or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('QtdVacinasNaoAplicadas' => $dados['QtdVacinasNaoAplicadas']);
	}
	
	return $resposta;
}

function ListaVacinasVencidas($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses, DATEDIFF(CURDATE(), V.DataValidade) as 'DiasVencidos' FROM Evento as E LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Vacina' AND V.DataValidade < CURDATE() ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses, DATEDIFF(CURDATE(), V.DataValidade) as 'DiasVencidos' FROM Evento as E LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Vacina' AND V.DataValidade < CURDATE() ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idEvento' => $dados['idEvento'],
							'Nome' => utf8_encode($dados['Nome']),
							'Observacoes' => utf8_encode($dados['Observacoes']),
							'FlagAlerta' => $dados['FlagAlerta'],
							'idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => utf8_encode($dados['NivelAlerta']),
							'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
							'idAnimal' => $dados['idAnimal'],
							'Tipo' => utf8_encode($dados['Tipo']),
							'Aplicada' => $dados['Aplicada'],
							'DataAplicacao' => $dados['DataAplicacao'],
							'DataValidade' => $dados['DataValidade'],
							'FrequenciaAnual' => $dados['FrequenciaAnual'],
							'QtdDoses' => $dados['QtdDoses'],
							'DiasVencidos' => $dados['DiasVencidos']);
	}
	
	return $resposta;
}

function ListaCompromissosPendentes($id){
	include("conectar.php");
	
	$resposta = array();

	$id = mysqli_real_escape_string($conexao,$id);
	
	//Consulta evento no banco
	if($id == 0){
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora, DATEDIFF(C.DataHora, NOW()) as 'DiasAteCompromisso' FROM Evento as E LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Compromisso' AND DataHora > NOW() ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora, DATEDIFF(C.DataHora, NOW()) as 'DiasAteCompromisso' FROM Evento as E LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.Tipo = 'Compromisso' AND DataHora > NOW() ORDER BY E.idEvento") or die(mysqli_error($conexao));
	}
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idEvento' => $dados['idEvento'],
							'Nome' => utf8_encode($dados['Nome']),
							'Observacoes' => utf8_encode($dados['Observacoes']),
							'FlagAlerta' => $dados['FlagAlerta'],
							'idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => utf8_encode($dados['NivelAlerta']),
							'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
							'idAnimal' => $dados['idAnimal'],
							'Tipo' => utf8_encode($dados['Tipo']),
							'NomeLocal' => utf8_encode($dados['NomeLocal']),
							'Latitude' => utf8_encode($dados['Latitude']),
							'Longitude' => utf8_encode($dados['Longitude']),
							'DataHora' => $dados['DataHora']);
	}
	
	return $resposta;
}

function InsereEvento(){
	
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
		if(!isset($dados["Nome"]) || !isset($dados["FlagAlerta"]) || 
			!isset($dados["idAlerta"]) || !isset($dados["idAnimal"]) || !isset($dados["Tipo"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			$eventoCadastrado = false;
			
			//Evita SQL injection
			$Nome = utf8_decode(mysqli_real_escape_string($conexao,$dados["Nome"]));
			$FlagAlerta = mysqli_real_escape_string($conexao,$dados["FlagAlerta"]);
			$idAlerta = mysqli_real_escape_string($conexao,$dados["idAlerta"]);
			$idAnimal = mysqli_real_escape_string($conexao,$dados["idAnimal"]);
			$Tipo = utf8_decode(mysqli_real_escape_string($conexao,$dados["Tipo"]));
			
			//Campos da Tabela Vacina
			if(!isset($dados["Observacoes"])){
				$Observacoes = 'NULL';
			}else{
				$Observacoes = utf8_decode(mysqli_real_escape_string($conexao,$dados["Observacoes"]));
			}
			
			if(!isset($dados["DataAplicacao"])){
				$DataAplicacao = 'NULL';
			}else{
				$DataAplicacao = mysqli_real_escape_string($conexao,$dados["DataAplicacao"]);
			}
			
			if(!isset($dados["DataValidade"])){
				$DataValidade = 'NULL';
			}else{
				$DataValidade = mysqli_real_escape_string($conexao,$dados["DataValidade"]);
			}
			
			if(!isset($dados["FrequenciaAnual"])){
				$FrequenciaAnual = 'NULL';
			}else{
				$FrequenciaAnual = mysqli_real_escape_string($conexao,$dados["FrequenciaAnual"]);
			}
			
			if(!isset($dados["QtdDoses"])){
				$QtdDoses = 'NULL';
			}else{
				$QtdDoses = mysqli_real_escape_string($conexao,$dados["QtdDoses"]);
			}
			
			if(!isset($dados["Aplicada"])){
				$Aplicada = 0; //Se o campo aplicada não for passado será pressuposto que a vacina ainda não foi aplicada
			}else{
				$Aplicada = mysqli_real_escape_string($conexao,$dados["Aplicada"]);
			}
			
			//Campos da Tabela Medicamento
			if(!isset($dados["Inicio"])){
				$Inicio = 'CURDATE()'; //Se o campo Inicio não for passado será pressuposto que o inicio é a data atual
			}else{
				$Inicio = mysqli_real_escape_string($conexao,$dados["Inicio"]);
			}
			
			if(!isset($dados["Fim"])){
				$Fim = 'CURDATE()'; //Se o campo Fim não for passado será pressuposto que o fim é a data atual
			}else{
				$Fim = mysqli_real_escape_string($conexao,$dados["Fim"]);
			}
			
			if(!isset($dados["FrequenciaDiaria"])){
				$FrequenciaDiaria = 1; //Se o campo FrequenciaDiaria não for passado será pressuposto que a FrequenciaDiaria é 1
			}else{
				$FrequenciaDiaria = mysqli_real_escape_string($conexao,$dados["FrequenciaDiaria"]);
			}
			
			if(!isset($dados["HorasDeEspera"])){
				$HorasDeEspera = 'NULL';
			}else{
				$HorasDeEspera = mysqli_real_escape_string($conexao,$dados["HorasDeEspera"]);
			}
			
			//Campos da Tabela Compromisso
			if(!isset($dados["NomeLocal"])){
				$NomeLocal = 'Local'; //Se o campo Local não for passado será pressuposto que o NomeLocal é Local
			}else{
				$NomeLocal = mysqli_real_escape_string($conexao,$dados["NomeLocal"]);
			}
			
			if(!isset($dados["Latitude"])){
				$Latitude = 'NULL'; 
			}else{
				$Latitude = mysqli_real_escape_string($conexao,$dados["Latitude"]);
			}
			
			if(!isset($dados["Longitude"])){
				$Longitude = 'NULL';
			}else{
				$Longitude = mysqli_real_escape_string($conexao,$dados["Longitude"]);
			}
			
			if(!isset($dados["DataHora"])){
				$DataHora = 'NOW()'; //Se o campo DataHora não for passado será pressuposto que o a data hora é o instante atual
			}else{
				$DataHora = mysqli_real_escape_string($conexao,$dados["DataHora"]);
			}
			
						
			//Consulta evento no banco
			$query = mysqli_query($conexao,"SELECT idEvento FROM Evento WHERE Nome='" .$Nome ."'") or die(mysqli_error($conexao));
			
			//Verifica se foi retornado algum registro
			while($dados = mysqli_fetch_array($query))
			{
			  $eventoCadastrado = true;
			  break;
			}
			
			if($eventoCadastrado){
				$resposta = mensagens(15);
			}else{
				//Recupera o próximo ID de usuário
				$idEvento = 1;
				$query = mysqli_query($conexao, "SELECT idEvento FROM Evento ORDER BY idEvento DESC LIMIT 1") or die(mysqli_error($conexao));
				while($dados = mysqli_fetch_array($query)){
					$idEvento = $dados["idEvento"];
				}
				$idEvento++;				
				
				//Insere evento
				if($Tipo == "Vacina"){
					$query = mysqli_query($conexao,"INSERT INTO Evento VALUES(" .$idEvento.",'" .$Nome ."','" .$Observacoes ."'," .$FlagAlerta ."," .$idAlerta ."," .$idAnimal .",'" .$Tipo ."')") or die(mysqli_error($conexao));
					$query2 = mysqli_query($conexao,"INSERT INTO ". $Tipo ." VALUES(" .$idEvento ."," .$Aplicada ."," .$DataAplicacao ."," .$DataValidade ."," .$FrequenciaAnual ."," .$QtdDoses .")") or die(mysqli_error($conexao));
				}elseif($Tipo == "Medicamento"){
					$query = mysqli_query($conexao,"INSERT INTO Evento VALUES(" .$idEvento.",'" .$Nome ."','" .$Observacoes ."'," .$FlagAlerta ."," .$idAlerta ."," .$idAnimal .",'" .$Tipo ."')") or die(mysqli_error($conexao));
					$query2 = mysqli_query($conexao,"INSERT INTO ". $Tipo ." VALUES(" .$idEvento ."," .$Inicio ."," .$Fim ."," .$FrequenciaDiaria ."," .$HorasDeEspera .")") or die(mysqli_error($conexao));
				}elseif($Tipo == "Compromisso"){
					$query = mysqli_query($conexao,"INSERT INTO Evento VALUES(" .$idEvento.",'" .$Nome ."','" .$Observacoes ."'," .$FlagAlerta ."," .$idAlerta ."," .$idAnimal .",'" .$Tipo ."')") or die(mysqli_error($conexao));
					$query2 = mysqli_query($conexao,"INSERT INTO ". $Tipo ." VALUES(" .$idEvento .",'" .$NomeLocal ."'," .$Latitude ."," .$Longitude ."," .$DataHora .")") or die(mysqli_error($conexao));
				}else{
					$resposta = mensagens(16);
				}
				
				$resposta = mensagens(7);
				
			}
		}
	}

	return $resposta;
}

?>