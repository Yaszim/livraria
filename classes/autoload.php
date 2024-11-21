<?php
spl_autoload_register(function ($class) {
    $classeArquivo = __DIR__ . "/{$class}.class.php";
    if (file_exists($classeArquivo)) {
        include $classeArquivo;
    } else {
        throw new Exception("Não foi possível encontrar a classe {$class}.");
    }
});
?>