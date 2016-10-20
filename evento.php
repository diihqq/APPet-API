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
							'Nome' => $dados['Nome'],
							'Observacoes' => $dados['Observacoes'],
							'FlagAlerta' => $dados['FlagAlerta'],
							'idAlerta' => $dados['idAlerta'],
							'NivelAlerta' => $dados['NivelAlerta'],
							'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
							'idAnimal' => $dados['idAnimal'],
							'Tipo' => $dados['Tipo'],
							'Inicio' => $dados['Inicio'],
							'Fim' => $dados['Fim'],
							'FrequenciaDiaria' => $dados['FrequenciaDiaria'],
							'HorasDeEspera' => $dados['HorasDeEspera'],
							'Aplicada' => $dados['Aplicada'],
							'DataAplicacao' => $dados['DataAplicacao'],
							'DataValidade' => $dados['DataValidade'],
							'FrequenciaAnual' => $dados['FrequenciaAnual'],
							'QtdDoses' => $dados['QtdDoses'],
							'NomeLocal' => $dados['NomeLocal'],
							'Latitude' => $dados['Latitude'],
							'Longitude' => $dados['Longitude'],
							'DataHora' => $dados['DataHora']);
	}
	
	return $resposta;
}

function ListaEventosPorUsuario($id){
	
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
	
			$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, AN.Nome as 'NomeAnimal', AN.Genero, AN.Cor, AN.Porte, AN.Idade, AN.Caracteristicas, AN.QRCode, AN.Foto, AN.Desaparecido, AN.FotoCarteira, AN.DataFotoCarteira, AN.idUsuario, AN.idRaca,  M.Inicio, M.Fim, M.FrequenciaDiaria, M.HorasDeEspera, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora FROM Evento as E LEFT JOIN Medicamento as M on E.idEvento = M.idEvento LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta LEFT JOIN Animal as AN on E.idAnimal = AN.idAnimal INNER JOIN Usuario as U on AN.idUsuario = U.idUsuario WHERE U.Email='" .$email ."' ORDER BY AN.Nome, E.Tipo") or die(mysqli_error($conexao));
		
			//faz um looping e cria um array com os campos da consulta
			while($dados = mysqli_fetch_array($query))
			{
				$resposta[] = array('idEvento' => $dados['idEvento'],
									'Nome' => $dados['Nome'],
									'Observacoes' => $dados['Observacoes'],
									'FlagAlerta' => $dados['FlagAlerta'],
									'idAlerta' => $dados['idAlerta'],
									'NivelAlerta' => $dados['NivelAlerta'],
									'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
									'idAnimal' => $dados['idAnimal'],
									'Tipo' => $dados['Tipo'],
									'NomeAnimal' => $dados['NomeAnimal'],
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
									'Inicio' => $dados['Inicio'],
									'Fim' => $dados['Fim'],
									'FrequenciaDiaria' => $dados['FrequenciaDiaria'],
									'HorasDeEspera' => $dados['HorasDeEspera'],
									'Aplicada' => $dados['Aplicada'],
									'DataAplicacao' => $dados['DataAplicacao'],
									'DataValidade' => $dados['DataValidade'],
									'FrequenciaAnual' => $dados['FrequenciaAnual'],
									'QtdDoses' => $dados['QtdDoses'],
									'NomeLocal' => $dados['NomeLocal'],
									'Latitude' => $dados['Latitude'],
									'Longitude' => $dados['Longitude'],
									'DataHora' => $dados['DataHora']);
			}
		}
	}
	
	return $resposta;
}

function ListaEventosPorAnimal($id){
	
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
		if(!isset($dados["idAnimal"])){
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$idAnimal = mysqli_real_escape_string($conexao,$dados["idAnimal"]);
	
			$query = mysqli_query($conexao,"SELECT E.idEvento, E.Nome, E.Observacoes, E.FlagAlerta, E.idAlerta, A.NivelAlerta, A.Frequencia as 'FrequenciaAlerta', E.idAnimal, E.Tipo, M.Inicio, M.Fim, M.FrequenciaDiaria, M.HorasDeEspera, V.Aplicada, V.DataAplicacao, V.DataValidade, V.FrequenciaAnual, V.QtdDoses, C.NomeLocal, C.Latitude, C.Longitude, C.DataHora FROM Evento as E LEFT JOIN Medicamento as M on E.idEvento = M.idEvento LEFT JOIN Vacina as V on E.idEvento = V.idEvento LEFT JOIN Compromisso as C on E.idEvento = C.idEvento LEFT JOIN Alerta as A on E.idAlerta = A.idAlerta WHERE E.idAnimal = ".$idAnimal ." ORDER BY E.Tipo, E.Nome") or die(mysqli_error($conexao));
	
			//faz um looping e cria um array com os campos da consulta
			while($dados = mysqli_fetch_array($query))
			{
				$resposta[] = array('idEvento' => $dados['idEvento'],
									'Nome' => $dados['Nome'],
									'Observacoes' => $dados['Observacoes'],
									'FlagAlerta' => $dados['FlagAlerta'],
									'idAlerta' => $dados['idAlerta'],
									'NivelAlerta' => $dados['NivelAlerta'],
									'FrequenciaAlerta' => $dados['FrequenciaAlerta'],
									'idAnimal' => $dados['idAnimal'],
									'Tipo' => $dados['Tipo'],
									'Inicio' => $dados['Inicio'],
									'Fim' => $dados['Fim'],
									'FrequenciaDiaria' => $dados['FrequenciaDiaria'],
									'HorasDeEspera' => $dados['HorasDeEspera'],
									'Aplicada' => $dados['Aplicada'],
									'DataAplicacao' => $dados['DataAplicacao'],
									'DataValidade' => $dados['DataValidade'],
									'FrequenciaAnual' => $dados['FrequenciaAnual'],
									'QtdDoses' => $dados['QtdDoses'],
									'NomeLocal' => $dados['NomeLocal'],
									'Latitude' => $dados['Latitude'],
									'Longitude' => $dados['Longitude'],
									'DataHora' => $dados['DataHora']);
			}
		}
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
			$Nome = mysqli_real_escape_string($conexao,$dados["Nome"]);
			$FlagAlerta = mysqli_real_escape_string($conexao,$dados["FlagAlerta"]);
			$idAlerta = mysqli_real_escape_string($conexao,$dados["idAlerta"]);
			$idAnimal = mysqli_real_escape_string($conexao,$dados["idAnimal"]);
			$Tipo = mysqli_real_escape_string($conexao,$dados["Tipo"]);
			
			//Campos da Tabela Vacina
			if(!isset($dados["Observacoes"])){
				$Observacoes = 'NULL';
			}else{
				$Observacoes = mysqli_real_escape_string($conexao,$dados["Observacoes"]);
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
			
			//Diogo - 20/10/2016			
			//Consulta evento no banco
			/*$query = mysqli_query($conexao,"SELECT idEvento FROM Evento WHERE Nome='" .$Nome ."'") or die(mysqli_error($conexao));
			
			//Verifica se foi retornado algum registro
			while($dados = mysqli_fetch_array($query))
			{
			  $eventoCadastrado = true;
			  break;
			}*/
			
			$eventoCadastrado = false;
			
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
					$query2 = mysqli_query($conexao,"INSERT INTO ". $Tipo ." VALUES(" .$idEvento ."," .$Aplicada .",'" .$DataAplicacao ."','" .$DataValidade ."'," .$FrequenciaAnual ."," .$QtdDoses .")") or die(mysqli_error($conexao));
				}elseif($Tipo == "Medicamento"){
					$query = mysqli_query($conexao,"INSERT INTO Evento VALUES(" .$idEvento.",'" .$Nome ."','" .$Observacoes ."'," .$FlagAlerta ."," .$idAlerta ."," .$idAnimal .",'" .$Tipo ."')") or die(mysqli_error($conexao));
					$query2 = mysqli_query($conexao,"INSERT INTO ". $Tipo ." VALUES(" .$idEvento .",'" .$Inicio ."','" .$Fim ."'," .$FrequenciaDiaria ."," .$HorasDeEspera .")") or die(mysqli_error($conexao));
				}elseif($Tipo == "Compromisso"){
					$query = mysqli_query($conexao,"INSERT INTO Evento VALUES(" .$idEvento.",'" .$Nome ."','" .$Observacoes ."'," .$FlagAlerta ."," .$idAlerta ."," .$idAnimal .",'" .$Tipo ."')") or die(mysqli_error($conexao));
					$query2 = mysqli_query($conexao,"INSERT INTO ". $Tipo ." VALUES(" .$idEvento .",'" .$NomeLocal ."','" .$Latitude ."','" .$Longitude ."','" .$DataHora ."')") or die(mysqli_error($conexao));
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