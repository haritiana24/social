<?php 
namespace App\Model;

use App\Database;
use PDO;

class Message extends Model {
    
    protected static  $model = "messagesch";
    
    public $id;
    public $content;
    public $created_at;
    public $updated_at;
    
    /**
     * messageUserAuth
     *
     * @param  int $id indetifiant of the user connected
     * @param  int $idDest indetifiant of the user to send the message
     * @return array  Message[]
     */
    public static function messageUserAuth(int $id, int $idDest) : array 
    {
        $pdo = Database::getPdo();
        $query = $pdo->prepare("SELECT messagesch.*, users.*, user_message.* FROM user_message INNER JOIN users INNER JOIN messagesch ON user_message.user_id = users.id AND user_message.messagech_id = messagesch.id WHERE users.id = :id AND user_message.destination_id = :idDest");
        $query->execute([
            'id' => $id,
            'idDest' =>$idDest
          ]);
        return  $query->fetchAll(PDO::FETCH_CLASS, Message::class);
    }
    
        
    /**
     * getAllMessage
     *
     * @param  int $user_id
     * @return array Message[]
     */
    public static function getAllMessage(int $user_id) : array 
    {
        $pdo = Database::getPdo();
        $query = $pdo->prepare("SELECT messagesch.*, users.*, user_message.* FROM user_message INNER JOIN users INNER JOIN messagesch ON user_message.user_id = users.id AND user_message.messagech_id = messagesch.id WHERE user_message.user_id != :user_id AND user_message.destination_id = :destination_id ");
        $query->execute([
            'user_id' => $user_id,
            'destination_id' => $user_id
        ]);
        return $query->fetchAll(PDO::FETCH_CLASS, Message::class);
    }
} 