<?php 

namespace App;

use App\Auth;
use App\Database;
use App\Model\Model;
use PDO;

class User extends Model {

    protected static $model = "users";
    
    public $id;

    public $username;

    public $password;

    public $email;

    public $role;

    public $image;

        
    /**
     * getUserAuth the user authaticate 
     *
     * @return User autheticate ro null
     */
    public  static function getUserAuth(): ?User
    {
        $auth = new Auth(Database::getPdo(), '/');
        return $auth->user() ?: null;
    }
    
    
    /**
     * getUserLikeThepost
     *
     * @param  int  $post_id
     * @return array the items of the user like one post 
     */
    public static function getUserLikeThepost(int $post_id)
    {
        $pdo = Database::getPdo();
        $req = $pdo->prepare("SELECT users.username, users.id, likes.post_id, likes.user_id  FROM users INNER JOIN likes ON likes.user_id = users.id WHERE likes.post_id = :post_id ");
        $req->execute([
            'post_id' => $post_id
        ]);
        $req->setFetchMode(PDO::FETCH_CLASS, App::class);
        return $req->fetchAll();
    }
    
        
    /**
     * getUserLikePost
     *
     * @param  int  $post_id
     * @return int the number of the user like the post
     */
    public static  function theUserLikePost(int $post_id)
    {
        return count(self::getUserLikeThepost($post_id));
    }
    
    
}