<?php

require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_SESSION['MSG']) ? $_SESSION['MSG'] : "";

    // Pegar o formulário e preencher com dados do usuário, se necessário
    $formulario = file_get_contents('templates/form.html');

    if ($id > 0) {
        $user = Usuario::listar(1, $id)[0];
        $formulario = str_replace('{id}', $user->getId(), $formulario); 
        $formulario = str_replace('{nome}', $user->getNome(), $formulario);
        $formulario = str_replace('{usuario}', $user->getUsuario(), $formulario);
        $formulario = str_replace('{email}', $user->getEmail(), $formulario);
        $formulario = str_replace('{nivel}', $user->getNivel(), $formulario);
    } else {
        $formulario = str_replace('{id}', '0', $formulario); 
        $formulario = str_replace('{nome}', '', $formulario); 
        $formulario = str_replace('{usuario}', '', $formulario); 
        $formulario = str_replace('{email}', '', $formulario); 
        $formulario = str_replace('{nivel}', '0', $formulario); 
    }

    print($formulario);   
    include "lista.php"; // Inclui a lista de usuários

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0; 
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
    $senha = isset($_POST['senha']) ? $_POST['senha'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $nivel = isset($_POST['nivel']) ? $_POST['nivel'] : 0; 
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";

    try {
        $user = new Usuario($id, $nome, $usuario, $senha, $email, $nivel);
        if ($acao == 'salvar') {
            if ($id > 0) {
                $user->alterar();
            } else {                     
                $user->incluir();
            }
        } elseif ($acao == 'excluir') {
            $user->excluir();
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