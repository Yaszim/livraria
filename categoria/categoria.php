<?php

require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : "";
    $acao =  isset($_POST['acao'])?$_POST['acao']:0; 

    try {
        $categoria = new Categoria($id, $descricao);

        $resultado = "";
        if ($acao == 'salvar') {
            if ($id > 0) {
                $resultado = $categoria->alterar();
            } else {
                $resultado = $categoria->incluir();
            }
        } elseif ($acao == 'excluir') {
            $resultado = $categoria->excluir();
        }
        
        $_SESSION['MSG'] = "Dados inseridos/alterados com sucesso!";
    } catch (Exception $e) {
        $_SESSION['MSG'] = $e->getMessage();
    } finally {
        header('location: ./index.php');
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = (isset($_SESSION['MSG']) ? $_SESSION['MSG'] : "");
    if ($msg != "") {
        echo "<h2>{$msg}</h2>";
        unset($_SESSION['MSG']);
    }

    if ($id > 0) {
        $categoria = Categoria::listar(1, $id)[0];
    }
    $busca =  isset($_GET['busca'])?$_GET['busca']:0;
    $tipo =  isset($_GET['tipo'])?$_GET['tipo']:0;   
    $lista = Categoria::listar($tipo,$busca); 
}
?>