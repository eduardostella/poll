# Documentação Sistema de votação
# Autoria
Eduardo Stella - 14/05/2018

# Sistema e tecnologias
Sistema para votação e gerenciamento de enquetes. Totalmente feito em Web API.

No servidor: Linux, Apache2, PHP 7, MaridDb
No cliente: Javascript, HTML e JQuery 1.8.2

As partes das views não foram solicitadas porém julguei melhor colocá-las para facilitar os testes


# Instalação
- Instalar no servidor Debian Stretch os seguintes pacotes: 
		apache2 libapache2-mod-php7.0 php7.0 mariadb-client mariadb-server phpmyadmin
- Habilite o módulo rewrite (como root)
		#a2enmod rewrite
- Edite o arquivo /etc/apache2/apache2.conf e procure a entrada <Directory /var/www/>, alterando dentro dela a linha
		"AllowOverride None" para "AllowOverride All"
- Reinicie o apache: 
		#/etc/init.d/apache2 restart
- Crie sua pasta no /var/www/poll e coloque os arquivos do projeto dentro
- Configurar uma instância separada para o MariaDB
	Copiar o arquivo /etc/mysql/mariadb.conf.d/50-server.cnf para /etc/mysql/mariadb.conf.d/50-server-poll.cnf e editá-lo.
	Procurar as seguintes linhas e fazer a alteração proposta:
		port = 3307
- Reiniciar o MariaDb
		#/etc/init.d/mysql restart

# Banco de dados
No console do MySQL, criar o usuário, banco e lhe conceder as permissões genéricas
> CREATE USER 'poll'@'localhost' IDENTIFIED BY 'poll123';
> CREATE DATABASE IF NOT EXISTS Poll_test CHARACTER SET utf8;
> GRANT ALL PRIVILEGES ON Poll_test.* TO 'poll'@'localhost';
> FLUSH PRIVILEGES;
> exit
Para criar as tableas e dados de exemplo, pode aproveitar a estrutura descrita no arquivo /util/Db.sql


# Descrição da navegação
	(GET)		/query								-> /includes/jquery<versão>.js	-> Arquivo jquery local
	(GET)		/listpolls						-> /view/polls.html							-> View de teste que lista todas as enquetes (get)
	(GET)		/testpoll/:Id 				-> /view/poll.php								-> View que tem o formulário que testa o consumo de uma enquete (get) e também sua votação (post)
	(GET)		/newpoll							-> /view/newpoll.html						-> View com formulário que cria nova enquete (post)
	(GET)		/pollstats/:Id				-> /view/pollstats.php					-> View que consome informações de estatísticas de enquete (get)
	(GET)		/polls 								-> /json/polls.php							-> JSON das enquetes cadastradas (get)
	(POST)	/poll 								-> /json/newpoll.php						-> Recebe JSON ('vote') e grava nova enquete
	(POST)  /poll/:Id/vote 				-> /json/vote.php								-> Recebe JSON ('vote') referente a uma votação
	(GET)		/poll/:Id 						-> /json/poll.php								-> Envia JSON da enquete pedida
	(GET)		/poll/:Id/stats				-> /json/pollstats.php					-> Envia JSON de estatísticas da enquete

# Descrição dos arquivos
	/.htaccess						-> Modifica a forma de acesso do apache2 para /aplic/Id/param
	/index.php						-> Início (carrega config.php)
	/config.php						-> Informações de configurações (carrega loader.php) - Configurações do banco de dados estão aqui
	/loader.php						-> Responsável pelo gerenciamento das URLs MVC (roteador de requisições)
	/includes/404.php			-> Retorna erro 404 para o navegador
	/includes/Db.php			-> Rotinas de acesso ao banco de dados
	/includes/jquery<v>.js-> Arquivo JQuery
	/json/newpoll.php			-> Responsável por receber uma enquete via JSON e gravar no banco, retornando nova Id
	/json/poll.php				-> Devolve especificações de determinada enquete
	/json/polls.php				-> Devolve JSON com as enquetes disponíveis
	/json/pollstats.php		-> Devolve estatísticas de uma determinada enquete
	/json/vote.php				-> Recebe determinada votação de uma enquete
	/util/Db.sql					-> Script para criação de banco de dados MySQL
	/view/newpoll.html		-> Formulário para criação de nova enquete
	/view/poll.php				-> Formulário para votação e exibição de enquete
	/view/polls.php				-> Listagem das enquetes disponíveis
	/view/pollstats.php		-> Exibição de estatísticas de uma enquete

# Versão em produção
http://www.eduardostella.com.br/poll

# Git hub
https://github.com/eduardostella/poll