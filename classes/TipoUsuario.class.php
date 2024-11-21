<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

class TipoUsuario extends Persistencia{
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
        $sql = 'INSERT INTO tipo_usuario (descricao)   
                     VALUES (:descricao)';
        $parametros = array(':descricao'=>$this->getDescricao());

        return Database::executar($sql, $parametros);      
    }    

    public function excluir(){
        $sql = 'DELETE 
                  FROM tipo_usuario
                 WHERE id = :id';
        $parametros = array(':id'=> $this->getId());
        return Database::executar($sql, $parametros);
    }  

    public function alterar(){
        $sql = 'UPDATE tipo_usuario 
                   SET descricao = :descricao
                 WHERE id = :id';
        $parametros = array(':id'=>$this->getId(),
                        ':descricao'=>$this->getDescricao());
        Database::executar($sql, $parametros);
        return true;
    }    

    public static function listar($tipo = 0, $busca = "" ):array{
        $sql = "SELECT * FROM tipo_usuario";  

        if ($tipo > 0 )
            switch($tipo){
                case 1: $sql .= " WHERE id = :busca"; break;
                case 2: $sql .= " WHERE descricao like :busca"; $busca = "%{$busca}%"; break;
            }
              
        $parametros = array();

        if ($tipo > 0 )
            $parametros = array(':busca'=>$busca); 

        $comando = Database::executar($sql, $parametros); 

        $tipo_usuarios = array();            
        while($registro = $comando->fetch(PDO::FETCH_ASSOC)){    
            $tipo_usuario = new TipoUsuario($registro['id'],$registro['descricao']);
            array_push($tipo_usuarios,$tipo_usuario); 
        }

        return $tipo_usuarios; 
    }    
}