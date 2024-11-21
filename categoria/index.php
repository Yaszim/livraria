<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Gerenciar Categorias</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="flex justify-between mb-4">
            <div>
                <a href="cadastro.php" class="text-blue-600 hover:underline">Nova Categoria</a>
                <a href="../index.php" class="text-blue-600 hover:underline">Menu</a>
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
                    <option value="2">Descrição</option>
                </select>
                
                <button type='submit' class="bg-blue-500 text-white rounded p-2 hover:bg-blue-600">Buscar</button>
            </fieldset>
        </form>

        <hr class="my-4">
        
        <h1 class="text-2xl font-bold mb-4">Lista de Categorias</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded">
                <thead>
                    <tr>
                        <th class="border-b p-4">ID</th>
                        <th class="border-b p-4">Descrição</th>
                        <th class="border-b p-4">Editar</th>
                        <th class="border-b p-4">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($lista as $categoria) {
                        echo "<tr>
                                <td class='border-b p-4'>{$categoria->getId()}</td>
                                <td class='border-b p-4'>{$categoria->getDescricao()}</td>
                                <td class='border-b p-4'><a href='categoria.php?id={$categoria->getId()}' class='text-blue-600 hover:underline'>Editar</a></td>
                                <td class='border-b p-4'><form action='categoria.php' method='post' style='display:inline;'>
                                    <input type='hidden' name='id' value='{$categoria->getId()}'>
                                    <button type='submit' name='acao' value='excluir' class='text-red-600 hover:underline'>Excluir</button>
                                </form></td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>