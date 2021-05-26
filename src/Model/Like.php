<?php

namespace App\Model;
use App\App;
use App\Database;

class Like extends Model {

    public $id;
    public $user_id;
    public $post_id;
    public $likes;
    
    /**
     * updateLike
     *
     * @param  array $data
     * @param  int $user_id
     * @param  int $post_id
     * @return void
     */
    public static function updateLike(array $data, int $user_id) : void
    {
        $model = self::getModel();
        $query = self::generateData($data);
        $req = Database::getPdo()->prepare("UPDATE $model SET $query WHERE user_id = :user_id ");
        $req->execute(array_merge($data, ['user_id' => $user_id]));
    }
    
    /**
     * likeForOnePost
     *
     * @param  int $post_id the id of the post liked
     * @return int the number of the like for this post
     */
    public static function likeForOnePost(int $post_id) : int 
    {
        return count(App::getDb()->prepare(
            "SELECT *
            FROM " . static::getModel() . "
            WHERE post_id = ?
            ",
            [$post_id], get_called_class()
        ));
    }
    
        
    /**
     * userAlreadyLiked
     *
     * @param  int $user_id
     * @param  int $post_id
     * @return boolean
     */
    public static function userAlreadyLiked(int $user_id, int $post_id) 
    {
       $userAlreadyLiked = count(App::getDb()->prepare(
            "SELECT *
            FROM " . static::getModel() . "
            WHERE user_id = :user_id AND post_id = :post_id
            ",
            [
              'user_id' =>  $user_id,
              'post_id' => $post_id
            ], get_called_class()
        ));
        
        if(empty($userAlreadyLiked)){
            return false;
        }
        return true;
    }


    public static function userLikePost(int $post_id)
    {
        $userAlreadyLiked = count(App::getDb()->prepare(
            "SELECT *
            FROM " . static::getModel() . "
            WHERE user_id = :user_id
            ",
            [
              'user_id' =>  $post_id
            ], get_called_class()
        ));
        
        if(empty($userAlreadyLiked)){
            return false;
        }
        return true;
    }
    
    /**
     * delete
     *
     * @param  int $user_id
     * @return void
     */
    public static function deleteLike(int $user_id, int $post_id) : void
    {
        $pdo = Database::getPdo();
        $query =  $pdo->prepare(
            "DELETE  
            FROM " . static::getModel() . "
            WHERE user_id = :user_id AND post_id = :post_id "
        );
        $query->execute([
            'user_id' =>  $user_id,
            'post_id' => $post_id
        ]);
    }
    
}