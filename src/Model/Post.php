<?php 

namespace App\Model;

use App\Database;

class Post extends Model {

    protected static $model="posts";

    public $id;
    public $title;
    public $content;
    public $image;
    public $user_id;

    public function   getAllPostWithYourLike()
    {
        $pdo = Database::getPdo();
    }
}