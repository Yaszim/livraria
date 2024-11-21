<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

class Autor extends Persistencia{
    private $nome; 
    private $sobrenome; 

    public function __construct($id = 0, $nome = "null", $sobrenome = "null"){
        parent::__construct($id);
        $this->setNome($nome);
        $this->setSobrenome($sobrenome);
    }

    public function setNome($nome){
        if ($nome)
            $this->nome = $nome;
        else
            throw new Exception("Erro: nome inválido!");
    }

    public function setSobrenome($sobrenome){
        if ($sobrenome)
            $this->sobrenome = $sobrenome;
        else
            throw new Exception("Erro: sobrenome inválido!"); 
    }

    public function getNome():string { return $this->nome;}
    public function getSobrenome():string { return $this->sobrenome;}

    public function incluir(){
        $sql = 'INSERT INTO autor (nome, sobrenome)   
                     VALUES (:nome, :sobrenome)';
        $parametros = array(':nome'=>$this->getNome(),
                            ':sobrenome'=>$this->getSobrenome());

        return Database::executar($sql, $parametros);      
    }    

    public function excluir(){
        $sql = 'DELETE 
                  FROM autor
                 WHERE id = :id';
        $parametros = array(':id'=> $this->getId());
        return Database::executar($sql, $parametros);
    }  

    public function alterar(){
        $sql = 'UPDATE autor 
                   SET nome = :nome, sobrenome = :sobrenome
                 WHERE id = :id';
        $parametros = array(':id'=>$this->getId(),
                        ':nome'=>$this->getNome(),
                        ':sobrenome'=>$this->getSobrenome());
        Database::executar($sql, $parametros);
        return true;
    }    

    public static function listar($tipo = 0, $busca = "" ):array{
        $sql = "SELECT * FROM autor";

        if ($tipo > 0 )
            switch($tipo){
                case 1: $sql .= " WHERE id = :busca"; break;
                case 2: $sql .= " WHERE nome like :busca"; $busca = "%{$busca}%"; break;
                case 3: $sql .= " WHERE sobrenome like :busca";  $busca = "%{$busca}%";  break;
            }  
            
        $parametros = array();

        if ($tipo > 0 )
            $parametros = array(':busca'=>$busca); 

        $comando = Database::executar($sql, $parametros); 

        $autores = array();            
        while($registro = $comando->fetch(PDO::FETCH_ASSOC)){    
            $autor = new Autor($registro['id'],$registro['nome'],$registro['sobrenome']);
            array_push($autores,$autor); 
        }

        return $autores; 
    }    
}