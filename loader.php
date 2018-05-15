<?php
/* *****************************
*
* Esse arquivo é chave pois ele faz todos os redirecionamentos do padrão MVC para os respectivos arquivos e parametrizações
*
*/


// Evita que usuários acesse este arquivo diretamente
if ( ! defined('ABSPATH')) exit;
 

// Verifica o método de requisição (post ou get), os parâmetros passados por get e sua quantidade
$metodo = $_SERVER["REQUEST_METHOD"];
$param = explode('/', $_GET['path']);
$numparam = count($param);

// Verifica se foi enviado por GET e faz todo o tratamento 
// Desse tipo de envio
if ($metodo == "GET")
{
	switch (strtolower($param[0])) {
		// Utilitários
		case 'jquery':	// Caso precise usar local o jquery, dá uma resposta por aqui
			require_once ABSPATH.'/includes/jquery.1.8.2.min.js';
			break;

		// Views
		case 'listpolls':				// Mostra a view com a listagem das enquetes disponíveis
			require_once ABSPATH.'/view/polls.html';
			break;
		case 'testpoll':				// Mostra o testador de votos
			require_once ABSPATH.'/view/poll.php';
			break;
		case 'newpoll':					// Cria uma nova enquete, com o form e tudo
			require_once ABSPATH.'/view/newpoll.html';
			break;
		case 'pollstats':
			require_once ABSPATH.'/view/pollstats.php';
			break;

			// JSON
		case 'polls':						// Retorna listagem das enquetes disponíveis
			require_once ABSPATH.'/json/polls.php';
			break;								// Trata se é pra receber nova enquete, devolver uma enquete ou estatísticas
		case 'poll': 			// Trata o json de uma enquete
			// Se não houver terceiro parâmetro, só pra trazer a enquete
			if ($numparam<=2)
				require_once ABSPATH.'/json/poll.php';
			else // Se houver, traz a estatística da enquete
			{
				if (strtolower($param[2])=="stats")
					require_once ABSPATH.'/json/pollstats.php';
				//elseif (strtolower($param[2]=="vote"))
				//	require_once ABSPATH.'/json/vote.php';
			}
			break;

		// Qualquer outro caso, devolve um 404
		default:
			require_once ABSPATH.'/includes/404.php';
			break; 
	}
}
elseif ($metodo == "POST")  // Foi enviado um post ? 
{
	if ($numparam<=2)					// Não recebeu nada de extra, criar nova enquete (/poll)
		require_once ABSPATH.'/json/newpoll.php';
	else
		if (strtolower($param[2])=='vote')                      // Recebeu? Trata-se de voto (/poll/:Id/vote)
			require_once ABSPATH.'/json/vote.php';
}

?>