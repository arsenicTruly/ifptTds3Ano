<?php

//Configuração do ambiente
define('DEV_ENVIRONMENT', true);

if (DEV_ENVIRONMENT == true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

//Configuração do Sistema
define('APP_NAME', 'Projeto Integrador');
define('URL_BASE', 'http://localhost:8080');

//Configurações do Banco de dados
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'db_projeto_integrador_pt');

define('DB_USER', 'root');
define('DB_PASS', '');

