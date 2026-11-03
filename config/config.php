<?php
//* palavra-chave define() é usada para criar constantes.
define('URL_BASE', 'http://localhost/aurea/public/');

// ! Config do Banco de Dados LOCAL
define('DB_HOST', 'localhost:3307');
define('DB_NAME', 'db_aurea');
define('DB_USER', 'root');
define('DB_PASS', '');

// Config do Email
// define('EMAIL_HOST', '');
// define('EMAIL_PORT', '465');
// define('EMAIL_USER', '');
// define('EMAIL_PASS', '');

spl_autoload_register(function ($class) {
    $caminhos = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php',
        __DIR__ . '/../rotas/' . $class . '.php'
    ];

    foreach ($caminhos as $caminho) {
        if (file_exists($caminho)) {
            require_once $caminho;
            return;
        }
    }
});

require_once __DIR__ . '/csrf.php';
