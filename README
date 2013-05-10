===========================
JASmine WEB - CUPS - IP
===========================

Esse trabalho foi realizado com a intenção de adicionar uma funcionabilidade ao sistema já existente JASmine, que gera relatórios a partir das impressoras instaladas no CUPS.

O JASmine na versão anterior mostra as seguintes informações:
 * Usuários;
 * Impressoras;
 * Servidores.

Nessa versão o JASmine tem a opção de listar o ip dos usuários e mostrar qual foi o ip que mais imprimiu.

Versão atual:
 * Usuários;
 * Impressoras;
 * Servidores;
 * IP.

==========================
Instalação
==========================

1 - Executar os processos de instalação do JASmine como é demostrado no link http://jasmine.berlios.de/dokuwiki/doku.php?id=documentation:0.0.3:install

2 - Editar o arquivo jasmine.sql antes de rodar o script

CREATE TABLE `jobs_log` (
  `id` mediumint(9) NOT NULL auto_increment,
  `date` timestamp(14) NOT NULL,
  `job_id` tinytext NOT NULL,
  `printer` tinytext NOT NULL,
  `user` tinytext NOT NULL,
  `server` tinytext NOT NULL,
  `title` tinytext NOT NULL,
  `copies` smallint(6) NOT NULL default '0',
  `pages` smallint(6) NOT NULL default '0',
  `options` tinytext NOT NULL,
  `doc` tinytext NOT NULL,
  `host` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Lists all the jobs successfully sent for printing';

3 - Copiar os arquivos do jasmine-cups e colar no diretório onde estão os arquivos que são publicados pelo servidor web instalado no servidor;

4 - Copiar o arquivo jasmine que se encontra no diretório backend e colar na pasta lib do cups(/usr/lib/cups/backend);
