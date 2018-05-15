<?php
	http_response_code(404); 
	header('HTTP/1.1 404 Not found');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Erro 404 - Não encontrado</title>
</head>
<body>
	<h1>404 - Não encontrado</h1>
	<p>Página não encontrada</p>
</body>
</html>
<?php die(); // Mata a aplicação ?>