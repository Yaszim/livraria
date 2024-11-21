<?php

require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
    $senha = isset($_POST['senha']) ? $_POST['senha'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $nivel = isset($_POST['nivel']) ? $_POST['nivel'] : 0;
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";

    try {
        $user = new Usuario($id, $nome, $usuario, $senha, $email, $nivel);

        $resultado = "";
        if ($acao == 'salvar') {
            if ($id > 0)
                $resultado = $user->alterar();
            else
                $resultado = $user->incluir();
        } elseif ($acao == 'excluir') {
            $resultado = $user->excluir();
        }
        $_SESSION['MSG'] = "Dados inseridos/Alterados com sucesso!";
    } catch (Exception $e) {
        $_SESSION['MSG'] = $e->getMessage();
    } finally {
        header('location: ../menu.php');
     
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = (isset($_SESSION['MSG']) ? $_SESSION['MSG'] : "");
    if ($msg != "") {
        echo "<h2>{$msg}</h2>";
        unset($_SESSION['MSG']);
    }

    if ($id > 0) {
        $user = Usuario::listar(1, $id)[0];
    }
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Usuario::listar($tipo, $busca);
}
