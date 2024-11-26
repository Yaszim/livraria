<?php

require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $busca = isset($_GET['busca']) ? $_GET['busca'] : ""; 
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0; 
    $lista = Livro::listar($tipo, $busca); 

    // Geração dos itens da lista
    $itens = "";
    foreach ($lista as $livro) {
        $item = file_get_contents('templates/item_livro.html');
        $item = str_replace('{id}', $livro->getId(), $item);
        $item = str_replace('{titulo}', $livro->getTitulo(), $item);
        $item = str_replace('{ano}', $livro->getAno(), $item);
        $item = str_replace('{categoria}', $livro->getCategoria()->getDescricao(), $item);
        $item = str_replace('{preco}', $livro->getPreco(), $item); // Ou você pode pegar a descrição da categoria
        $itens .= $item; 
    }   

    // Geração do template da lista
    $templateLista = file_get_contents('templates/listagem_livro.html');
    $templateLista = str_replace('{itens}', $itens, $templateLista);
    
    // Exibir mensagem, se houver
    if ($msg != "") {
        $templateLista = str_replace('{msg}', $msg, $templateLista);
    }

    print($templateLista);
}
?>