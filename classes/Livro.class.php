<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

class Livro extends Persistencia{
    private $titulo; 
    private $ano; 
    private $capa; 
    private $categoria; 
    private $preco; 

    public function __construct($id = 0, $titulo = "null", $ano = "null", $capa = "null", Categoria $categoria = null, $preco = "null"){
        parent::__construct($id);
        $this->setTitulo($titulo);
        $this->setAno($ano);
        $this->setCapa($capa);
        $this->setCategoria($categoria);
        $this->setPreco($preco);
    }

    public function setTitulo($titulo){
        if ($titulo)
            $this->titulo = $titulo;
        else
            throw new Exception("Erro: título inválido!");
    }

    public function setAno($ano){
        if ($ano)
            $this->ano = $ano;
        else
            throw new Exception("Erro: ano inválida!");
    }

    public function setCapa($capa){
        if ($capa)
            $this->capa = $capa;   
        else
            throw new Exception("Erro: capa inválida!");
    }

    public function setCategoria(Categoria $categoria = null){
        if ($categoria)
            $this->categoria = $categoria;
        else
            throw new Exception("Erro: Deve ser informada uma categoria!");
    }

    public function setPreco($preco){
        if ($preco)
            $this->preco = $preco;   
        else
            throw new Exception("Erro: preço inválido!");
    }

    public function getTitulo():string { return $this->titulo;}
    public function getAno():string { return $this->ano;}
    public function getCapa():string { return $this->capa;}
    public function getCategoria() { return $this->categoria;}
    public function getPreco() { return $this->preco;}

    public function incluir(){
        $sql = 'INSERT INTO livro (titulo, ano, capa, categoria, preco)   
                     VALUES (:titulo, :ano, :capa, :categoria, :preco)';
        $parametros = array(':titulo'=>$this->getTitulo(),
                            ':ano'=>$this->getAno(),
                            ':capa'=>$this->getCapa(),
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
                   SET titulo = :titulo, ano = :ano, capa = :capa, categoria = :categoria, preco = :preco
                 WHERE id = :id';
        $parametros = array(':id'=>$this->getId(),
                            ':titulo'=>$this->getTitulo(),
                            ':ano'=>$this->getAno(),
                            ':capa'=>$this->getCapa(),
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
            $livro = new Livro($registro['id'],$registro['titulo'],$registro['ano'],$registro['capa'],$categoria,$registro['preco']);
            array_push($livros,$livro); 
        }

        return $livros; 
    }    
}