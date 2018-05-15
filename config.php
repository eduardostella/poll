<?php
/**
 * Configuração geral
 */

// Caminho para a raiz
define( 'ABSPATH', dirname( __FILE__ ) );

// URL da home (trocar pelo seu diretório) -> Não usado nessa aplicação
define( 'HOME_URI', 'http://localhost/poll' );

// Dados de conexão do banco de dados
define('DB_HOSTNAME', 'localhost');
define('DB_PORT', 3306);
define('DB_USERNAME', 'poll');
define('DB_PASSWORD', 'poll123');
define('DB_DATABASE', 'Poll_test');
define('DB_CHARSET', 'utf8');
define('DB_PREFIX', '');
?>