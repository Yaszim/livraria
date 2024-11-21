<?php
require_once __DIR__ . '/../classes/autoload.php';
require_once __DIR__ . '/../config/config.inc.php';

class Usuario extends Persistencia{
    private $usuario; 
    private $email; 
    private $senha; 
    private $tipo;

    public function __construct($id = 0, $usuario = "null", $email = "null", $senha = "null", TipoUsuario $tipo = null){
        parent::__construct($id);
        $this->setUsuario($usuario);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setTipo($tipo);
    }

    public function setUsuario($usuario){
        if ($usuario)
            $this->usuario = $usuario;
        else
            throw new Exception("Erro: usuario inválido!");
    }

    public function setEmail($email){
        if ($email)
            $this->email = $email;
        else
            throw new Exception("Erro: email inválida!");
    }

    public function setSenha($senha){
        if ($senha)
            $this->senha = $senha;   
        else
            throw new Exception("Erro: senha inválida!");
    }

    public function setTipo(TipoUsuario $tipo = null){
        if ($tipo)
            $this->tipo = $tipo;
        else
            throw new Exception("Erro: Deve ser informada um tipo!");
    }

    public function getUsuario():string { return $this->usuario;}
    public function getEmail():string { return $this->email;}
    public function getSenha():string { return $this->senha;}
    public function getTipo() { return $this->tipo;}

    public function incluir(){
        $sql = 'INSERT INTO usuario (usuario, email, senha, tipo)   
                     VALUES (:usuario, :email, :senha, :tipo)';
        $parametros = array(':usuario'=>$this->getUsuario(),
                            ':email'=>$this->getEmail(),
                            ':senha'=>$this->getSenha(),
                            ':tipo'=>$this->getTipo()->getId());

        return Database::executar($sql, $parametros);      
    }

    public function excluir(){
        $sql = 'DELETE 
                  FROM usuario
                 WHERE id = :id';
        $parametros = array(':id'=> $this->getId());
        return Database::executar($sql, $parametros);
    }  

    public function alterar(){
        $sql = 'UPDATE usuario 
                   SET usuario = :usuario, email = :email, senha = :senha, tipo = :tipo
                 WHERE id = :id';
        $parametros = array(':id'=>$this->getId(),
                            ':usuario'=>$this->getUsuario(),
                            ':email'=>$this->getEmail(),
                            ':senha'=>$this->getSenha(),
                            ':tipo'=>$this->getTipo()->getId());
        Database::executar($sql, $parametros);
        return true;
    }    

    public static function listar($tipo = 0, $busca = "" ):array{
        $sql = "SELECT * FROM usuario";  

        if ($tipo > 0 )
            switch($tipo){
                case 1: $sql .= " WHERE id = :busca"; break;
                case 2: $sql .= " WHERE usuario like :busca"; $busca = "%{$busca}%"; break;
                case 3: $sql .= " WHERE email = :busca"; break;
                case 4: $sql .= " , tipo_usuario WHERE descricao like :busca and usuario.tipo = tipo_usuario.id" ;  $busca = "%{$busca}%";  break;
            }
              
        $parametros = array();

        if ($tipo > 0 )
            $parametros = array(':busca'=>$busca); 

        $comando = Database::executar($sql, $parametros); 

        $usuarios = array();            
        while($registro = $comando->fetch(PDO::FETCH_ASSOC)){    
            $tipo = TipoUsuario::listar(1,$registro['tipo'])[0]; 
            $usuario = new Usuario($registro['id'],$registro['usuario'],$registro['email'],$registro['senha'],$tipo);
            array_push($usuarios,$usuario); 
        }

        return $usuarios; 
    }    

    public static function efetuarLogin($usuario, $senha){
        $conexao = Database::getInstance();
        $sql = 'SELECT * FROM pessoa 
                 WHERE usuario = :usuario
                   AND senha = :senha';
        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':usuario',$usuario);
        $comando->bindValue(':senha',$senha);
        if ($comando->execute()){
            while($registro = $comando->fetch()){ 
                $tipo = TipoUsuario::listar(1,$registro['tipo'])[0]; 
                $usuario = new Usuario($registro['id'],$registro['usuario'],$registro['email'],$registro['senha'],$tipo);
                return $usuario;
            }
        }
        return false;
    }
}