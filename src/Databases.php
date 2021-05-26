<?php 

namespace App;
use \PDO;

class Databases {

    private $db_name;

    private $db_user;

    private $db_pass;
    
    private $db_host;
    
    private $pdo;

    public function __construct(string $db_name, string $db_user = 'root', string $db_pass = '', string $db_host = 'localhost')
    {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }
      
    /**
     * getPDO call the instance of the pdo
     *
     * @return PDO
     */
    public function getPDO() : PDO
    {
        if(is_null($this->pdo)){
            $this->pdo = new PDO(
                "mysql:host={$this->db_host};dbname={$this->db_name}",
                 $this->db_user, $this->db_pass,[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        }

        return $this->pdo;
        
    }
    
    /**
     * query
     *
     * @param  string $statement
     * @param  string  $className
     * @return instance of the $className whitout param
     */
    public function query(string $statement , string $className) 
    {
        return  $this->getPDO()->query($statement)->fetchAll(PDO::FETCH_CLASS, $className);
    }
    
    /**
     * prepare the reques sql in the database
     *
     * @param  string $statement
     * @param  string $params
     * @param  string $className
     * @param  bool $only
     * @return instance of the $className whit param
     */
    public function prepare(string $statement , array $params , string $className, bool $only = false )
    {
        $req = $this->getPDO()->prepare($statement);
        $req->execute($params);
        $req->setFetchMode(PDO::FETCH_CLASS, $className);
        if($only) {
            $data = $req->fetch();
        }else {
            $data = $req->fetchAll();
        }
        
        return $data;
    }
}