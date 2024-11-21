
<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : "";
    $publicacao = isset($_POST['publicacao']) ? $_POST['publicacao'] : 0;
    $categoriaId = isset($_POST['categoriaId']) ? $_POST['categoriaId'] : 0;
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";

    try {
        $livro = new Livro($id, $titulo, $publicacao, $categoriaId);

        $resultado = "";
        if ($acao == 'salvar') {
            if ($id > 0)
                $resultado = $livro->alterar();
            else
                $resultado = $livro->incluir();
        } elseif ($acao == 'excluir') {
            $resultado = $livro->excluir();
        }
        $_SESSION['MSG'] = "Dados inseridos/Alterados com sucesso!";
    } catch (Exception $e) {
        $_SESSION['MSG'] = $e->getMessage();
    } finally {
        header('location: index.php');
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = (isset($_SESSION['MSG']) ? $_SESSION['MSG'] : "");
    if ($msg != "") {
        echo "<h2>{$msg}</h2>";
        unset($_SESSION['MSG']);
    }

    if ($id > 0) {
        $livro = Livro::listar(1, $id)[0];
    }
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Livro::listar($tipo, $busca);
}