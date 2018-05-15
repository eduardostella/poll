<?php
// Não foi enviado parâmetro do Id, retorna 404
if ($numparam!=2)	require_once ABSPATH.'/includes/404.php';
// Pega o parâmetro definido no "/loader.php"
$idquestion = $param[1];
?>
<html>
	<head>
		<title>Teste de votação de uma enquete</title>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	</head>
	<body>
		<form method="post" action="" id="ajax_form">
			<h1>Enquete:</h1>
			<h2><span id="spnDescription" /></h2>
			<hr />
			<ul id="ulOpcoes"></ul>
			<hr />
			<input type="submit" value="Votar" />
		</form>
		<script type="text/javascript">
			window.onload = function() {
				jQuery('#ajax_form').submit(function(){
					// var frm = $(this).serialize();
					var opcoes = document.getElementsByName("options");
					var opcao=0;
					for (x=0;x<opcoes.length;x++)
						if (opcoes[x].checked) opcao=opcoes[x].value;
					dados = JSON.stringify({'option_id':opcao});
					jQuery.ajax({
						type: "POST",
						url: "../poll/<?php echo $idquestion ?>/vote",
						data: {'vote':dados},
						success: function( data ) {
							alert( data );
						},
						error: function( data ) {
							alert( "erro: " + data );
						}
					});
				
					return false;
				});


				$.ajax( {
					url: "../poll/<?php echo $idquestion ?>",
					dataType: 'json'
				}).done(function(data) {
					// Descrição da enquete
					var spn_description = document.getElementById("spnDescription");
					spn_description.innerText = data.poll_description;
					// Pega a lista
					var ul = document.getElementById("ulOpcoes");
					// Varre as opções disponíveis
					for (i=0;i<data.options.length;i++)
					{
						var li = document.createElement("li");
						var opt = document.createElement("input");
						opt.setAttribute("id","options");
						opt.setAttribute("type","radio");
						opt.setAttribute("value",data.options[i].option_id);
						opt.setAttribute("name","options");
						var spn = document.createElement("span");
						spn.innerText = data.options[i].option_description;
						li.appendChild(opt);
						li.appendChild(spn);
						ul.appendChild(li);
					}
				});
			}
		</script>
	</body>
</html>