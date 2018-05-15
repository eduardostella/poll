<?php
// Não foi enviado parâmetro do Id, retorna 404
if ($numparam!=2)	require_once ABSPATH.'/includes/404.php';
// Pega o parâmetro definido no "/loader.php"
$idquestion = $param[1];
?>
<html>
	<head>
		<title>Situação de uma enquete</title>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	</head>
	<body>
		<h1>Status de enquete</h1>
		<h2><span id="spnDescription" /></h2>
		<hr />
		<ul id="ulOpcoes"></ul>
		<script type="text/javascript">
			window.onload = function() {
				$.ajax( {
					url: "../poll/<?php echo $idquestion ?>/stats",
					dataType: 'json'
				}).done(function(data) {
					// Descrição da enquete
					var spn_description = document.getElementById("spnDescription");
					spn_description.innerText = 'Id: <?php echo $idquestion ?> (' + data.views + ' visualizações).';
					// Pega a lista
					var ul = document.getElementById("ulOpcoes");
					// Varre as opções disponíveis
					for (i=0;i<data.votes.length;i++)
					{
						var li = document.createElement("li");
						var spn = document.createElement("span");
						spn.innerText = data.votes[i].option_id + ': ' + data.votes[i].qty + ' votos';
						li.appendChild(spn);
						ul.appendChild(li);
					}
				});
			}
		</script>
	</body>
</html>