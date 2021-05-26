<?php 

namespace App\Model;
use App\App;
use App\Database;
use App\User;

class Model   {

    protected static $model;
    
    /**
     * getModel
     *
     * @return className used for the request
     */
    protected static function getModel()
    {
        if(is_null(static::$model))
        {
            $className = explode("\\", get_called_class());
            static::$model = strtolower(end($className)) . 's';
        }

        return static::$model;
    }
    
    /**
     * all get all result in database
     *
     * @return object 
     */
    public static function all()
    {
        return App::getDB()->query("SELECT * FROM " . self::getModel() ."", get_called_class());
    }
    
    public function __get($key)
    {
        $method = "get". ucfirst($key);
        $this->$key =  $this->$method();
        return $this->$key;
    }
    
    /**
     * find one  corresopandant in the id 
     *
     * @param  int $id
     * @return object 
     */
    public static function find(int $id)
    {
        return App::getDb()->prepare(
            "SELECT *
            FROM " . static::getModel() . "
            WHERE id = ?
            ",
            [$id], get_called_class(), 
            true
        );
    }
    
    
    /**
     * findWithUserName
     *
     * @param  string $username
     * @return array Usert[]
     */
    public static function findWithUserName(string $username): ?User
    {
        return App::getDb()->prepare(
            "SELECT *
            FROM " . static::getModel() . "
            WHERE username = ?
            ",
            [$username], get_called_class(),
            true
        );
    }
    
    /**
     * delete the data corresondant of the id 
     *
     * @param  int $id
     * @return void
     */
    public static function delete(int $id) : void
    {
        $pdo = Database::getPdo();
        $query =  $pdo->prepare(
            "DELETE  
            FROM " . static::getModel() . "
            WHERE id = :id "
        );
        $query->execute(['id' => $id]);
    }
    
        
        
    /**
     * getRelationResults
     *
     * @return array Posts[]
     */
    public static  function getRelationResults() : ?array
    {
       $posts =  App::getDb()->query("SELECT  posts.*,  users.username, users.image as imageUser   FROM posts INNER JOIN users   ON posts.user_id = users.id ORDER BY created_at DESC", 'App\Model\Post');
       return $posts;
    }
    
    /**
     * getOneRelationResults
     *
     * @param  int  $idPost
     * @return void
     */
    public static function getOneRelationResults(int $idPost) 
    {
       return  App::getDb()->prepare("SELECT  posts.*,  users.username, users.image as imageUser   FROM posts INNER JOIN users   ON posts.user_id = users.id WHERE posts.id = :id ORDER BY created_at DESC",
       [
           "id" => $idPost
       ], 
       'App\Model\Post', 
       true
    );
    }
    
        
        
    /**
     * getUserPosts
     *
     * @param  int $id
     * @return array Post[]
     */
    public static function getUserPosts(int $id) : ?array
    {
       
        return  App::getDb()->prepare('SELECT posts.*, users.id as idUser FROM posts INNER JOIN users ON users.id = posts.user_id WHERE posts.user_id = :id ', ['id' => $id], Post::class);

    }
    
    /**
     * generateData
     *
     * @param  array $datas
     * @return string
     */
    protected static  function generateData(array $datas) : string 
    {
        $query = "";
        $data = array_keys($datas);
        foreach($data as $d){
            $query .= $d . "= :$d ,";
        }
        $query = substr($query , 0, strlen($query) - 1); 
        return $query;
    }

    
    /**
     * create the new data for the Model correspandate
     *
     * @param  array $datas
     * @return void
     */
    public static function create(array $datas) : void 
    { 
        $model = self::getModel();
        $query = self::generateData($datas);
        $req = Database::getPdo()->prepare("INSERT INTO $model SET $query");
        $req->execute($datas);
    }
    
    /**
     * update the Model with your id
     *
     * @param  array $datas
     * @param  int $id
     * @return void
     */
    public static function update(array $datas , int $id) : void
    {
        $model = self::getModel();
        $query = self::generateData($datas);
        $req = Database::getPdo()->prepare("UPDATE $model SET $query WHERE id = :id");
        $req->execute(array_merge($datas, ['id' => $id]));
    }
}