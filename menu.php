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
    <title>Menu</title>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Livraria</h1>
        </div>
        <div class="menu">
            <ul class="list-none space-y-2">
                <li>
                    <a href="./livro/cadastro.php" class="block p-4 bg-green-300 text-black rounded hover:bg-green-600 transition">Cadastrar um livro</a>
                </li>
                <li>
                    <a href="./categoria/" class="block p-4 bg-green-300 text-black rounded hover:bg-green-600 transition">Categoria</a>
                </li>
                <li>
                    <a href="./usuario/cadastro.php" class="block p-4 bg-green-300 text-black rounded hover:bg-green-600 transition">Usuário</a>
                </li>
                <li>
                    <a href="./autor/" class="block p-4 bg-green-300 text-black rounded hover:bg-green-600 transition">Autor</a>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>