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
    <title>Cadastro de Livros</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">CRUD de Livros</h1>
        <h3 class="text-center text-red-500"><?= $msg ?></h3>
        
        <form action="livro.php" method="post" class="bg-white p-6 rounded-lg shadow-lg">
            <fieldset>
                <legend class="font-semibold mb-2">Cadastro de Livro</legend>    
                <a href="../index.php" class="text-blue-600 hover:underline">Menu</a>    
                <fieldset class="mt-4">
                    <legend class="font-semibold mb-2">Dados do Livro</legend>        
                    <label for="id" class="block">Id:</label>
                    <input type="text" name="id" id="id" value="<?= isset($livro) ? $livro->getId() : 0 ?>" readonly class="border rounded p-2 w-full mb-2">
                    
                    <label for="titulo" class="block">Título:</label>
                    <input type="text" name="titulo" id="titulo" value="<?= isset($livro) ? $livro->getTitulo() : "" ?>" class="border rounded p-2 w-full mb-2" required>
                    
                    <label for="publicacao" class="block">Ano de Publicação:</label>
                    <input type="number" name="publicacao" id="publicacao" value="<?= isset($livro) ? $livro->getPublicacao() : "" ?>" class="border rounded p-2 w-full mb-2" required>
                    
                    <label for="categoriaId" class="block">Categoria:</label>
                    <select name="categoriaId" id="categoriaId" required class="border rounded p-2 w-full mb-2">
                        <option value="">Selecione</option>
                        <?php  
                            $categorias = Categoria::listar(); // Supondo que você tenha uma classe Categoria
                            foreach ($categorias as $categoria) { 
                                $str = "<option value='{$categoria->getId()}' ";
                                if (isset($livro) && $livro->getCategoriaId() == $categoria->getId()) 
                                    $str .= " selected ";
                                $str .= ">{$categoria->getDescricao()}</option>";
                                echo $str;
                            }     
                        ?>
                    </select>
                    
                    <div class="flex justify-between mt-4">
                        <button type='submit' name='acao' value='salvar' class="bg-blue-500 text-white rounded p-2 hover:bg-blue-600">Salvar</button>
                        <button type='submit' name='acao' value='excluir' class="bg-red-500 text-white rounded p-2 hover:bg-red-600">Excluir</button>
                        <button type='reset' class="bg-gray-300 text-black rounded p-2 hover:bg-gray-400">Cancelar</button>
                    </div>
                </fieldset>
            </fieldset>
        </form>
        <hr class="my-4">
    </div>
</body>
</html>