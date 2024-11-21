<?php  
session_start();
require_once("./classes/autoload.php");
require_once './config/config.inc.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Livros</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="flex justify-between mb-4">
            <div>
                <a href="./categoria/cadastro.php" class="text-blue-600 hover:underline">Nova Categoria</a>
                <a href="./livro/cadastro.php" class="text-blue-600 hover:underline">Novo Livro</a>
                <a href="./menu.php" class="text-blue-600 hover:underline">Menu</a>
            </div>
        </div>

        <!-- Formulário de Pesquisa -->
        <form action="" method="get" class="mb-4">
            <fieldset class="border p-4 rounded bg-white">
                <legend class="font-semibold">Pesquisa</legend>
                <label for="busca" class="block">Busca:</label>
                <input type="text" name="busca" id="busca" value="" class="border rounded p-2 w-full mb-2">
                
                <label for="tipo" class="block">Tipo:</label>
                <select name="tipo" id="tipo" class="border rounded p-2 w-full mb-2">
                    <option value="0">Escolha</option>
                    <option value="1">ID</option>
                    <option value="2">Título</option>
                    <option value="3">Publicação</option>
                    <option value="4">Categoria</option>
                </select>
                
                <button type='submit' class="bg-blue-500 text-white rounded p-2 hover:bg-blue-600">Buscar</button>
            </fieldset>
        </form>

        <hr class="my-4">
        
        <h1 class="text-2xl font-bold mb-4">Lista de Livros</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded">
                <thead>
                    <tr>
                        <th class="border-b p-4">ID</th>
                        <th class="border-b p-4">Título</th>
                        <th class="border-b p-4">Publicação</th>
                        <th class="border-b p-4">Categoria</th>
                        <th class="border-b p-4">Visualizar</th>
                        <th class="border-b p-4">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
                    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
                    $lista = Livro::listar($tipo, $busca);

                    foreach ($lista as $livro) {
                        echo "<tr>
                                <td class='border-b p-4'>{$livro->getId()}</td>
                                <td class='border-b p-4'>{$livro->getTitulo()}</td>
                                <td class='border-b p-4'>{$livro->getPublicacao()}</td>
                                <td class='border-b p-4'>{$livro->getCategoriaId()}</td>
                                <td class='border-b p-4'><a href='livro.php?id={$livro->getId()}' class='text-blue-600 hover:underline'>Visualizar</a></td>
                                <td class='border-b p-4'><a href='livro.php?id={$livro->getId()}' class='text-blue-600 hover:underline'>Editar</a></td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>