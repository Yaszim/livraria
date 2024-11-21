<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

class Categoria extends Persistencia{
    private $descricao; 

    public function __construct($id = 0, $descricao = "null"){
        parent::__construct($id);
        $this->setDescricao($descricao);
    }

    public function setDescricao($descricao){
        if ($descricao)
            $this->descricao = $descricao;
        else
            throw new Exception("Erro: descrição inválida!");
    }

    public function getDescricao():string { return $this->descricao;}

    public function incluir(){
        $sql = 'INSERT INTO categoria (descricao)   
                     VALUES (:descricao)';
        $parametros = array(':descricao'=>$this->getDescricao());

        return Database::executar($sql, $parametros);      
    }    

    public function excluir(){
        $sql = 'DELETE 
                  FROM categoria
                 WHERE id = :id';
        $parametros = array(':id'=> $this->getId());
        return Database::executar($sql, $parametros);
    }  

    public function alterar(){
        $sql = 'UPDATE categoria 
                   SET descricao = :descricao
                 WHERE id = :id';
        $parametros = array(':id'=>$this->getId(),
                        ':descricao'=>$this->getDescricao());
        Database::executar($sql, $parametros);
        return true;
    }    

    public static function listar($tipo = 0, $busca = "" ):array{
        $sql = "SELECT * FROM categoria";  

        if ($tipo > 0 )
            switch($tipo){
                case 1: $sql .= " WHERE id = :busca"; break;
                case 2: $sql .= " WHERE descricao like :busca"; $busca = "%{$busca}%"; break;
            }
              
        $parametros = array();

        if ($tipo > 0 )
            $parametros = array(':busca'=>$busca); 

        $comando = Database::executar($sql, $parametros); 

        $categorias = array();            
        while($registro = $comando->fetch(PDO::FETCH_ASSOC)){    
            $categoria = new Categoria($registro['id'],$registro['descricao']);
            array_push($categorias,$categoria); 
        }

        return $categorias; 
    }    
}