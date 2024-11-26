<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';


if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

    // pegar o formulário e preencher, após apresentar para o usuário
    $formulario = file_get_contents('templates/form.html');

    if ($id > 0) {
        $categoria = Categoria::listar(1, $id)[0];
        $formulario = str_replace('{id}', $categoria->getId(), $formulario); 
        $formulario = str_replace('{descricao}', $categoria->getDescricao(), $formulario); 
    } else {
        $formulario = str_replace('{id}', '0', $formulario); 
        $formulario = str_replace('{descricao}', '', $formulario); 
    }


    print($formulario);   
    include "lista.php"; // Inclui a lista de categorias

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0; 
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : ""; 
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0; 

    try {
        $categoria = new Categoria($id, $descricao);
        if ($acao == 'salvar') {
            if ($id > 0) {
                $categoria->alterar();
            } else {                     
                $categoria->incluir();
            }
        } elseif ($acao == 'excluir') {
            $categoria->excluir();
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