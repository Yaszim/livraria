<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';
class Compra extends Persistencia{
    private $data; 
    private $valor_total; 

    public function __construct($id = 0, $data = "null", $valor_total = "null"){
        parent::__construct($id);
        $this->setData($data);
        $this->setValorTotal($valor_total);
    }

    public function setData($data){
        if ($data)
            $this->data = $data;
        else
            throw new Exception("Erro: data inválida!");
    }

    public function setValorTotal($valor_total){
        if ($valor_total)
            $this->valor_total = $valor_total;
        else
            throw new Exception("Erro: valor total inválido!");
    }

    public function getData():string { return $this->data;}
    public function getValorTotal():string { return $this->valor_total;}

    public function incluir(){
        $sql = 'INSERT INTO compra (data, valor_total)   
                     VALUES (:data, :valor_total)';
        $parametros = array(':data'=>$this->getData(),
                            ':valor_total'=>$this->getValorTotal());

        return Database::executar($sql, $parametros);      
    }

    public function excluir(){
        $sql = 'DELETE 
                  FROM compra
                 WHERE id = :id';
        $parametros = array(':id'=> $this->getId());
        return Database::executar($sql, $parametros);
    }  

    public function alterar(){
        $sql = 'UPDATE compra 
                   SET data = :data, valor_total = :valor_total
                 WHERE id = :id';
        $parametros = array(':id'=>$this->getId(),
                            ':data'=>$this->getData(),
                            ':valotTotal'=>$this->getValorTotal());
        Database::executar($sql, $parametros);
        return true;
    }    

    public static function listar($tipo = 0, $busca = "" ):array{
        $sql = "SELECT * FROM compra";  

        if ($tipo > 0 )
            switch($tipo){
                case 1: $sql .= " WHERE id = :busca"; break;
                case 2: $sql .= " WHERE data like :busca"; $busca = "%{$busca}%"; break;
            }
              
        $parametros = array();

        if ($tipo > 0 )
            $parametros = array(':busca'=>$busca); 

        $comando = Database::executar($sql, $parametros); 

        $compras = array();        
        while($registro = $comando->fetch(PDO::FETCH_ASSOC)){
            $compra = new Compra($registro['id'],$registro['data'],$registro['valor_total']);
            array_push($compras,$compra); 
        }

        return $compras; 
    }    
}