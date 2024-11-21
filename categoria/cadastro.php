<!DOCTYPE html>
<?php  
session_start();
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Cadastro de Categorias</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">Cadastro de Categorias</h1>
        <h3 class="text-center text-red-500"></h3>
        
        <form action="categoria.php" method="get" class="bg-white p-6 rounded-lg shadow-lg">
            <fieldset>
                <legend class="font-semibold mb-2">Dados da Categoria</legend>
                <a href="index.php" class="text-blue-600 hover:underline">Menu</a>    
                <label for="id" class="block">ID:</label>
                <input type="text" name="id" id="id" value="<?= isset($categoria) ? $categoria->getId() : 0 ?>" readonly class="border rounded p-2 w-full mb-2">
                
                <label for="descricao" class="block">Descrição:</label>
                <input type="text" name="descricao" id="descricao" value="<?= isset($categoria) ? $categoria->getDescricao() : "" ?>" class="border rounded p-2 w-full mb-2" required>
                
                <div class="flex justify-between mt-4">
                    <button type='submit' name='acao' value='salvar' class="bg-blue-500 text-white rounded p-2 hover:bg-blue-600">Salvar</button>
                        <button type='submit' name='acao' value='excluir' class="bg-red-500 text-white rounded p-2 hover:bg-red-600">Excluir</button>
                    <button type='reset' class="bg-gray-300 text-black rounded p-2 hover:bg-gray-400">Cancelar</button>
                </div>
            </fieldset>
        </form>
        <hr class="my-4">
    </div>
</body>
</html>