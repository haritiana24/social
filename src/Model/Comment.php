<?php

/**
 * @author Haritiana24
 */

namespace App\Model;

use App\Database;
use PDO;

class Comment extends Model {
    
    public int  $id;
    public $content;
    public int  $user_id;
    public $commetable_id;
    public $commtable_type;
    public $created_at;
    protected static $model = 'comments';
    
    /**
     * getCommentWhitYourUser
     *
     * @param  int $idComment
     * @return Comment
     */
    public static function getCommentWhitYourUser(int $idComment)
    {
        $pdo = Database::getPdo();
        $query = $pdo->prepare("SELECT comments.*, users.*, posts.id FROM comments INNER JOIN users INNER JOIN posts ON comments.user_id = users.id AND comments.commentable_id = posts.id WHERE comments.commentable_id = :id ORDER BY comments.created_at DESC");
        $query->execute(['id' =>  $idComment]);
        return  $query->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }
    
    /**
     * countCommentForOneUser the number comment  of the one user
     *
     * @param  int $idComment
     * @return int
     */
    public static  function countCommentForOneUser(int $idComment): int
    {
        return count(self::getCommentWhitYourUser($idComment));
    }
    
    /**
     * render the view to for the HTML 
     *
     * @param  int $idComment
     * @return void
     */
    public static function render(int $idComment) : void 
    {
        //  show 2 comments only 
        $theComments = self::getCommentWhitYourUser($idComment);
         foreach($theComments as $key => $comment){
            if($key <= 1){
                echo   "<div class=\"card mb-2 ml-5\">
                <div class=\"card-body comment\">
                    $comment->content
                    <div class=\"d-flex justify-content-between align-items-center \">
                        <small>Posté le  $comment->created_at</small>
                        <span class=\"badge badge-primary\">$comment->username</span>
                    </div>
                </div>
            </div>";
            }else{
                echo "<div class=\"mb-2 ml-5\">
                        <a href=\"/showcomment?id=$idComment\"> voir tous les commentaires </a>
                     </div>";
                return;
            }
         }

    }
}