<?php

require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $msg =  isset($_GET['MSG'])?$_GET['MSG']:"";
    $busca =  isset($_GET['busca'])?$_GET['busca']:0; 
    $tipo =  isset($_GET['tipo'])?$_GET['tipo']:0; 
    $lista = Categoria::listar($tipo, $busca); 
    // Geração dos itens da lista
    $itens = "";
    foreach ($lista as $categoria) {
        $item = file_get_contents('templates/categoria_item.html');
        $item = str_replace('{id}', $categoria->getId(), $item);
        $item = str_replace('{descricao}', $categoria->getDescricao(), $item);
        $itens .= $item; 
    }   
    // Geração do template da lista
    $templateLista = file_get_contents('templates/listagem_categoria.html');
    $templateLista = str_replace('{itens}', $itens, $templateLista);
    print($templateLista);
}
?>