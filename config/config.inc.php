<?php
require_once __DIR__ . '/../classes/autoload.php';
define('USUARIO', 'root'); /// root
define('SENHA', ''); // ''
define('HOST', 'localhost'); 
define('PORT', '3306'); 
define('DB', 'livros'); 
define('DSN', "mysql:host=".HOST.";port=".PORT.";dbname=".DB.";charset=UTF8");