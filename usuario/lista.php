<?php

require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $busca = isset($_GET['busca']) ? $_GET['busca'] : ""; 
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0; 
    $lista = Usuario::listar($tipo, $busca); 

    // Geração dos itens da lista
    $itens = "";
    foreach ($lista as $usuario) {
        $item = file_get_contents('templates/item_usuario.html');
        $item = str_replace('{id}', $usuario->getId(), $item);
        $item = str_replace('{nome}', $usuario->getNome(), $item);
        $item = str_replace('{usuario}', $usuario->getUsuario(), $item);
        $item = str_replace('{email}', $usuario->getEmail(), $item);
        $itens .= $item; 
    }   

    // Geração do template da lista
    $templateLista = file_get_contents('templates/lista_usuario.html');
    $templateLista = str_replace('{itens}', $itens, $templateLista);

    print($templateLista);
}
?>