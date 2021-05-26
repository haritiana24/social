<?php 

namespace App\Model;

class UserMessage extends Model {

    protected static $model = "user_message";
    public $user_id;
    public $message_id;
    public $destination_id;
}