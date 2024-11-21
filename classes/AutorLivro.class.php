<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

class AutorLivro extends Persistencia{
    private $livro; 
    private $autor; 

    public function __construct(Livro $livro = null, Autor $autor = null){
        $this->setLivro($livro);
        $this->setAutor($autor);
    }

    public function setLivro(Livro $livro = null){
        if ($livro)
            $this->livro = $livro;
        else
            throw new Exception("Erro: Deve ser informado um livro!");
    }

    public function setAutor(Autor $autor = null){
        if ($autor)
            $this->autor = $autor;
        else
            throw new Exception("Erro: Deve ser informado um autor!");
    }

    public function getLivro() { return $this->livro;}
    public function getAutor() { return $this->autor;}

    public function incluir(){
        $sql = 'INSERT INTO autor_livro (livro, autor)   
                     VALUES (:livro, :autor)';
        $parametros = array(':livro'=>$this->getLivro()->getId(),
                            ':autor'=>$this->getAutor()->getId());

        return Database::executar($sql, $parametros);      
    }

    public function excluir(){
        $sql = 'DELETE 
                  FROM autor_livro
                 WHERE id = :id';
        $parametros = array(':id'=> $this->getId());
        return Database::executar($sql, $parametros);
    }  

    public function alterar(){
        $sql = 'UPDATE autor_livro 
                   SET livro = :livro, autor = :autor
                 WHERE id = :id';
        $parametros = array(':id'=>$this->getId(),
                            ':livro'=>$this->getLivro()->getId(),
                            ':autor'=>$this->getAutor()->getId());
        Database::executar($sql, $parametros);
        return true;
    }    

    public static function listar($tipo = 0, $busca = "" ):array{
        $sql = "SELECT * FROM autor_livro";  

        if ($tipo > 0 )
            switch($tipo){
                case 1: $sql .= " WHERE id = :busca"; break;
                case 2: $sql .= " WHERE titulo like :busca"; $busca = "%{$busca}%"; break;
                case 3: $sql .= " WHERE ano = :busca"; break;
                case 4: $sql .= " , categoria WHERE descricao like :busca and livro.categoria = categoria.id" ;  $busca = "%{$busca}%";  break;
            }
              
        $parametros = array();

        if ($tipo > 0 )
            $parametros = array(':busca'=>$busca); 

        $comando = Database::executar($sql, $parametros); 

        $livros = array();            
        while($registro = $comando->fetch(PDO::FETCH_ASSOC)){    
            $categoria = Categoria::listar(1,$registro['categoria'])[0]; 
            $livro = new Livro($registro['id'],$registro['titulo'],$registro['ano'],$registro['capa'],$categoria);
            array_push($livros,$livro); 
        }

        return $livros; 
    }    
}