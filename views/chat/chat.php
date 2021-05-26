<?php

use App\Date\GenerateDate;
use App\Model\Message;
use App\Model\UserMessage;
use App\User;

$title = "Votre message";
$username = $_GET['username'] ?? "";
if(!empty($username)){
    $user =  User::findWithUserName($username);
}else{
    throw new Exception("The user not exists in the paramas");
}


$userAuth = User::getUserAuth();

$errors = false;

// to valid the message send for one user
if(!empty($_POST)){
    if(empty($_POST['content'])){
        $errors = true;
    }
    if(!$errors){
        Message::create([
            "content" => $_POST["content"],
            "created_at" => GenerateDate::now(),
            "updated_at" => GenerateDate::now()
        ]);
        $messageID =(int)count(Message::all());
        UserMessage::create([
            'user_id' => $userAuth->id,
            'messagech_id' => $messageID,
            'destination_id' => $user->id,
            'created_at' => GenerateDate::now(),
            'updated_at' => GenerateDate::now()
        ]);
    }
}
// get message to the user auth
$messageAuths = Message::messageUserAuth($userAuth->id, $user->id);
// get the to the user destination
$messageDests = Message::messageUserAuth($user->id, $userAuth->id);

?>

<div class="row">
    <div class="col-md-3"></div>
    <?php if(isset($user) && isset($userAuth)): ?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h5> Votre conversation avec <?= $user->username ?></h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row bodyMessage">
                    <?php if(!empty($messageDests) || !empty($messageAuths)): ?>
                    <div class="col-md-6">
                        <?php foreach($messageAuths as $message): ?>
                        <em class="text-muted"> Vous:</em>
                        <div class="m-4 bg-primary user">
                            <?= $message->content ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-md-6">
                        <?php foreach($messageDests as $message): ?>
                        <em class="text-muted"><?= $user->username ?>:</em>
                        <div class="m-4 mt-3 ml-4 other">
                            <?= $message->content ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <em class="text-muted m-5">commencer le conversation avec <?= $user->username ?></em>
                    <?php endif ?>
                </div>
                <form action="" method="POST" class="form-inline">
                    <div class="form-group">
                        <textarea name="content" class="form-control"  cols="20" rows="1"></textarea>
                        <button class="btn btn-primary bntMsg">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="col-md-3"></div>
</div>