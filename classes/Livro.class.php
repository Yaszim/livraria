<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

class Livro extends Persistencia{
    private $titulo; 
    private $ano;  
    private $categoria; 
    private $preco; 

    public function __construct($id = 0, $titulo = "null", $ano = "null", Categoria $categoria = null, $preco = 0){
        parent::__construct($id);
        $this->setTitulo($titulo);
        $this->setAno($ano);
        $this->setCategoria($categoria);
        $this->setPreco($preco);
    }

    public function setTitulo($novotitulo){
        if ($novotitulo)
            $this->titulo = $novotitulo;
        else
            throw new Exception("Erro: título inválido!");
    }

    public function setAno($novoano){
        if ($novoano)
            $this->ano = $novoano;
        else
            throw new Exception("Erro: ano inválida!");
    }

    public function setCategoria(Categoria $novocategoria = null){
        if ($novocategoria)
            $this->categoria = $novocategoria;
        else
            throw new Exception("Erro: Deve ser informada uma categoria!");
    }

    public function setPreco($novopreco){
        if ($novopreco < 0)
        throw new Exception("Erro: preço inválido!");     
        else
        $this->preco = $novopreco;  
    }

    public function getTitulo():string { return $this->titulo;}
    public function getAno():string { return $this->ano;}
    public function getCategoria() { return $this->categoria;}
    public function getPreco() { return $this->preco;}

    public function incluir(){
        $sql = 'INSERT INTO livro (titulo, ano, categoria, preco)   
                     VALUES (:titulo, :ano, :categoria, :preco)';
        $parametros = array(':titulo'=>$this->getTitulo(),
                            ':ano'=>$this->getAno(),
                            ':categoria'=>$this->getCategoria()->getId(),
                            ':preco'=>$this->getPreco());

        return Database::executar($sql, $parametros);      
    }

    public function excluir(){
        $sql = 'DELETE 
                  FROM livro
                 WHERE id = :id';
        $parametros = array(':id'=> $this->getId());
        return Database::executar($sql, $parametros);
    }  

    public function alterar(){
        $sql = 'UPDATE livro 
                   SET titulo = :titulo, ano = :ano, categoria = :categoria, preco = :preco
                 WHERE id = :id';
        $parametros = array(':id'=>$this->getId(),
                            ':titulo'=>$this->getTitulo(),
                            ':ano'=>$this->getAno(),
                            ':categoria'=>$this->getCategoria()->getId(),
                            ':preco'=>$this->getPreco());
        Database::executar($sql, $parametros);
        return true;
    }    

    public static function listar($tipo = 0, $busca = "" ):array{
        $sql = "SELECT * FROM livro";  

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
            $livro = new Livro($registro['id'],$registro['titulo'],$registro['ano'],$categoria,$registro['preco']);
            array_push($livros,$livro); 
        }

        return $livros; 
    }    
}