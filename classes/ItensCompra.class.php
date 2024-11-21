<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

class ItensCompra extends Persistencia{
    private $quantidade; 
    private $livro;
    private $compra;

    public function __construct($quantidade = "null", Livro $livro = null, Compra $compra = null){
        $this->setQuantidade($quantidade);
        $this->setLivro($livro);
        $this->setCompra($compra);
    }

    public function setQuantidade($quantidade){
        if ($quantidade)
            $this->quantidade = $quantidade;
        else
            throw new Exception("Erro: quantidade inválida!");
    }

    public function setLivro(Livro $livro = null){
        if ($livro)
            $this->livro = $livro;
        else
            throw new Exception("Erro: Deve ser informado um livro!");
    }
    
    public function setCompra(Compra $compra = null){
        if ($compra)
            $this->compra = $compra;
        else
            throw new Exception("Erro: Deve ser informado um compra!");
    }

    public function getQuantidade():string { return $this->quantidade;}
    public function getLivro() { return $this->livro;}
    public function getCompra() { return $this->compra;}

    public function incluir(){
        $sql = 'INSERT INTO itens_compra (quantidade, livro, compra)   
                     VALUES (:quantidade, :livro, :compra)';
        $parametros = array(':quantidade'=>$this->getQuantidade(),
                            ':livro'=>$this->getLivro(),
                            ':compra'=>$this->getCompra());

        return Database::executar($sql, $parametros);      
    }

    public function excluir(){
        $sql = 'DELETE 
                  FROM itens_compra
                 WHERE id = :id';
        $parametros = array(':id'=> $this->getId());
        return Database::executar($sql, $parametros);
    }  

    public function alterar(){
        $sql = 'UPDATE itens_compra 
                   SET quantidade = :quantidade, livro = :livro, compra = :compra
                 WHERE id = :id';
        $parametros = array(':id'=>$this->getId(),
                            ':quantidade'=>$this->getQuantidade(),
                            ':livro'=>$this->getLivro(),
                            ':compra'=>$this->getCompra());
        Database::executar($sql, $parametros);
        return true;
    }    

    public static function listar($tipo = 0, $busca = "" ):array{
        $sql = "SELECT * FROM itens_compra";  

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