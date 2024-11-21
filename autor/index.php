<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){ 
    $id =  isset($_GET['id'])?$_GET['id']:0;
    $msg =  isset($_GET['MSG'])?$_GET['MSG']:"";

    // pegar o formulário e preencher, após apresentar para o usuário
    $formulario = file_get_contents('templates/form.html');

    if ($id > 0){
        $autor = Autor::listar(1,$id)[0];
        $formulario = str_replace('{id}',$autor->getId(),$formulario); 
        $formulario = str_replace('{nome}',$autor->getNome(),$formulario); 
        $formulario = str_replace('{sobrenome}',$autor->getSobrenome(),$formulario); 
    }else{
        $formulario = str_replace('{id}','0',$formulario); 
        $formulario = str_replace('{nome}','',$formulario); 
        $formulario = str_replace('{sobrenome}','',$formulario);
    }
    
    print($formulario);   
    include "lista.php";

}elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id =  isset($_POST['id'])?$_POST['id']:0; 
    $nome =  isset($_POST['nome'])?$_POST['nome']:""; 
    $sobrenome =  isset($_POST['sobrenome'])?$_POST['sobrenome']:""; 
    $acao =  isset($_POST['acao'])?$_POST['acao']:0; 
    try{
        $autor = new Autor($id,$nome,$sobrenome);
        if($acao == 'salvar'){
            if($id > 0)
                $autor->alterar();
            else                     
                $autor->incluir();
        }elseif ($acao == 'excluir'){
           $autor->excluir();
        }
        $_SESSION['MSG'] = "Dados inseridos/Alterados com sucesso!";
    }catch(Exception $e){ 
        $_SESSION['MSG'] = 'ERRO: '.$e->getMessage();
    }finally{
        header('location: index.php?tela=listagem'); 
    }
}