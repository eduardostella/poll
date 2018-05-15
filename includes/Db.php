<?php
// Protege contra SQL injection
function DBEscape($link,$dados)
{
	if(!is_array($dados)) {
		$dados = mysqli_real_escape_string($link,$dados);
	}
	else 	{
		$arr = $dados;
		foreach ($arr as $key => $value) {
			$key = mysqli_real_escape_string($link,$key);
			$value = mysqli_real_escape_string($link,$value);

			$dados[$key] = $value;
		}
	}
	return $dados;
}


// Fecha a conexão
function DBClose($link)
{
	mysqli_close($link) or die(mysqli_error($link));
}

// Faz a conexão com o banco de dados
function DBConnect()
{
	$link = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE,DB_PORT) or die(mysqli_connect_error());
	mysqli_set_charset($link, DB_CHARSET) or die(mysqli_error($link));

	return $link;
}

// Executa consultas
function DBExecute($link,$query,$autoincrement=false)
{
	$result = @mysqli_query($link,$query) or die(mysqli_error($link));
	if ($autoincrement) 
		$result=mysqli_insert_id($link);
	return $result;
}

// Executa consultas sem ter uma conexão previamente aberta
function DBFastExecute($query,$autoincrement=false)
{
	$link = DBConnect();
	$result = @mysqli_query($link,$query) or die(mysqli_error($link));
	if ($autoincrement) 
		$result=mysqli_insert_id($link);
	DBClose($link);
	return $result;
}

// Grava registros
function DBCreate($link, $tabela, array $valores, $autoincrement=false)
{
	// $tabela = DB_PREFIX.'_'.$tabela;
	$valores = DBEscape($link,$valores);
	$fld = implode(', ',array_keys($valores));
  $vlr = "'".implode("','",$valores)."'";
	$qry = "INSERT INTO {$tabela} (${fld}) VALUES (${vlr});";
	return DBExecute($link,$qry,$autoincrement);
}

// Grava registros sem a nessidade de ter uma conexão previamente aberta
function DBFastCreate($tabela, array $valores, $autoincrement=false)
{
	$link = DBConnect();
	$ret = DBCreate($link,$tabela,$valores,$autoincrement);
	DBClose($link);
	return $ret;
}

// Ler registros de uma query
function DBRead($link,$tabela,$params=null,$campos='*')
{
	// $tabela = DB_PREFIX.'_'.$tabela;
	$qry = "SELECT ${campos} FROM ${tabela} ${params};";
	$rst = DBExecute($link,$qry);
	if(!mysqli_num_rows($rst))
		return false;
	else
	{
		while ($r = mysqli_fetch_assoc($rst)) 
			$data[] = $r;
		return $data;
	}
}

// Ler regisrtos rapidamente de uma query
function DBFastRead($tabela,$params=null,$campos='*')
{
	$link=DBConnect();
	$rst=DBRead($link,$tabela,$params,$campos);
	DBClose($link);
	return $rst;
}

// Altera registros
function DBUpdate($link,$tabela,array $dados,$regras='',$autoincrement=false)
{
	// $tabela = DB_PREFIX.'_'.$tabela;
	$regras = DBEscape($link,$regras);
	$dados = DBEscape($link,$dados);
	if (strlen($regras)==0)
		trigger_error('Não se pode executar atualizações sem restrições.',256);
	// Formata os campos
	foreach ($dados as $key => $value) {
		$cps[] = "{$key}='{$value}'";
	}
	$cps = implode(',', $cps);
	// 256 = User error, 512 = User warning e 1024 = User notice 
	$qry="UPDATE ${tabela} SET ${cps} WHERE {$regras};";
	return DBExecute($link,$qry,$autoincrement);
}
// Altera registros sem precisar de conexão previamente aberta.
function DBFastUpdate($tabela,array $dados,$regras='',$autoincrement=false)
{
	$lnk=DBConnect();
	$ret=DBUpdate($lnk,$tabela,$dados,$regras,$autoincrement);
	DBClose($lnk);
	return $ret;
}

// Apaga registros
function DBDelete($link,$tabela,$regras='')
{
	// $tabela=DB_PREFIX.'_'.$tabela;
	$regras=DBEscape($link,$regras);

	if (strlen($regras)==0)
		trigger_error('Não se pode executar deletações sem restrições.',256);
	$qry="DELETE FROM ${tabela} WHERE ${regras};";
	return DBExecute($link,$qry);
}
// Apaga registros sem necessidade de haver uma conexão prévia
function DBFastDelete($tabela,$regras='')
{
	$lnk=DBConnect();
	$ret=DBDelete($lnk,$tabela,$regras);
	DBClose($lnk);
	return $ret;
}
?>