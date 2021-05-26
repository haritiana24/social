<?php 

/**
 * @author Haritiana24
 */

namespace App\Controller;

use App\Database;
use App\User;
use App\Date\GenerateDate;
use App\Model\Comment;

class CommentController{
    
    protected $comment;

    protected $user;

    protected $date;
    
    public function __construct(string $comment, User $user)
    {
        $this->user = $user->getUserAuth();
        $this->comment = trim($comment, " \t\n\r\0\x0B");
         $jour = date('d');
        $mois = date('m');
        $annee = date('Y');
        $heure = date('H');
        $minute = date('i');
        $seconde = date('s');
        $this->date = $annee . '-' . $mois . '-' . $jour .' '.$heure . ':'. $minute .':'.$seconde;
    }
        
    /**
     * isCommentValid for the all comment valid
     *
     * @return bool
     */
    public function isCommentValid() : bool
    {
        if(empty($this->comment)){
            return false;
        } 
        return true;
    }
    
    /**
     * addComment add  the new comment in the database
     *
     * @param  int $idOfComment
     * @param  string $typeOfComment
     * @return void
     */
    public function addComment(int $idOfComment, string  $typeOfComment)
    {
        if($this->isCommentValid()){
            Comment::create([
                'content' => $this->comment,
                'user_id' => $this->user->id,
                'commentable_id' => $idOfComment,
                'commentable_type' => $typeOfComment,
                'created_at' => $this->date,
                'updated_at' => GenerateDate::now()
            ]);
        }
    }
}