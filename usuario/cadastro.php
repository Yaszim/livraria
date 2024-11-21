<?php  
session_start();
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Cadastro de Usuários</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">CRUD de Usuários</h1>
        
        <form action="usuario.php" method="post" class="bg-white p-6 rounded-lg shadow-lg">
            <fieldset>
                <legend class="font-semibold mb-2">Cadastro de Usuário</legend>    
                <a href="../index.php" class="text-blue-600 hover:underline">Menu</a>    
                <fieldset class="mt-4">
                    <legend class="font-semibold mb-2">Dados do Usuário</legend>        
                    <label for="id" class="block">Id:</label>
                    <input type="text" name="id" id="id" value="<?= isset($usuarios) ? $usuarios->getId() : 0 ?>" readonly 
                           class="border rounded p-2 w-full mb-2">
                    
                    <label for="nome" class="block">Nome:</label>
                    <input type="text" name="nome" id="nome" value="<?= isset($usuarios) ? $usuarios->getNome() : "" ?>" 
                           class="border rounded p-2 w-full mb-2" required>
                    
                    <label for="usuario" class="block">Usuário:</label>
                    <input type="text" name="usuario" id="usuario" value="<?= isset($usuarios) ? $usuarios->getUsuario() : "" ?>" 
                           class="border rounded p-2 w-full mb-2" required>
                    
                    <label for="senha" class="block">Senha:</label>
                    <input type="password" name="senha" id="senha" 
                           class="border rounded p-2 w-full mb-2" <?= isset($usuarios) ? "" : "required" ?>>
                    
                    <label for="email" class="block">Email:</label>
                    <input type="email" name="email" id="email" value="<?= isset($usuarios) ? $usuarios->getEmail() : "" ?>" 
                           class="border rounded p-2 w-full mb-2" required>
                    
                    <label for="nivel" class="block">Nível de Acesso:</label>
                    <select name="nivel" id="nivel" required class="border rounded p-2 w-full mb-2">
                        <option value="">Selecione</option>
                        <option value="1" <?= (isset($usuarios) && $usuarios->getNivel() == 1) ? "selected" : "" ?>>Administrador</option>
                        <option value="2" <?= (isset($usuarios) && $usuarios->getNivel() == 2) ? "selected" : "" ?>>Usuário</option>
                        <option value="3" <?= (isset($usuarios) && $usuarios->getNivel() == 3) ? "selected" : "" ?>>Visitante</option>
                    </select>
                    
                    <div class="flex justify-between mt-4">
                        <button type='submit' name='acao' value='salvar' 
                                class="bg-blue-500 text-white rounded p-2 hover:bg-blue-600">Salvar</button>
                        <button type='submit' name='acao' value='excluir' 
                                class="bg-red-500 text-white rounded p-2 hover:bg-red-600">Excluir</button>
                        <button type='reset' 
                                class="bg-gray-300 text-black rounded p-2 hover:bg-gray-400">Cancelar</button>
                    </div>
                </fieldset>
            </fieldset>
        </form>
        <hr class="my-4">
    </div>
</body>
</html>
