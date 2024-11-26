<?php

require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

    // Pegar o formulário e preencher, após apresentar para o usuário
    $formulario = file_get_contents('templates/form.html');

    $categorias = Categoria::listar();
    $categoriaOptions = '';
    $categoriaSelected = 0;

    if ($id > 0) {
        $livro = Livro::listar(1, $id)[0];

        $categoriaSelected = $livro->getCategoria()->getId();

        $formulario = str_replace('{id}', $livro->getId(), $formulario); 
        $formulario = str_replace('{titulo}', $livro->getTitulo(), $formulario); 
        $formulario = str_replace('{ano}', $livro->getAno(), $formulario); 
        $formulario = str_replace('{categoria}', $livro->getCategoria(), $formulario); 
        $formulario = str_replace('{preco}', $livro->getPreco(), $formulario);
    } else {
        $formulario = str_replace('{id}', '0', $formulario); 
        $formulario = str_replace('{titulo}', '', $formulario); 
        $formulario = str_replace('{ano}', '', $formulario);
       

    }

    foreach ($categorias as $categoria) {
        $selected = ($categoriaSelected == $categoria->getId()) ? 'selected' : '';
        $categoriaOptions .= '<option value="' . $categoria->getId() . '" ' . $selected . '>'
            . $categoria->getDescricao() . '</option>';
    }
    $formulario = str_replace('{categoria}', $categoriaOptions, $formulario); 

    print($formulario);   
    include "lista.php"; // Inclui a lista de livros
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0; 
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : ""; 
    $ano = isset($_POST['ano']) ? $_POST['ano'] : 0; 
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : 0; 
    $preco = isset($_POST['preco']) ? $_POST['preco'] : 0;
    $acao = isset($_POST['acao']) ? $_POST['acao'] : ""; 
    $cate = Categoria::listar(1,$categoria)[0];

    try {
        $livro = new Livro($id, $titulo, $ano, $cate, $preco);
        if ($acao == 'salvar') {
            if ($id > 0) {
                $livro->alterar();
            } else {                     
                $livro->incluir();
            }
        } elseif ($acao == 'excluir') {
            $livro->excluir();
        }
        $_SESSION['MSG'] = "Dados inseridos/alterados com sucesso!";
    } catch (Exception $e) { 
        $_SESSION['MSG'] = 'ERRO: ' . $e->getMessage();
    } finally {
        header('location: index.php?tela=listagem'); 
        exit; // Certifique-se de sair após o redirecionamento
    }
}
?>