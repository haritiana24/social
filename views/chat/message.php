<?php

use App\Model\Message;
use App\Session;
use App\User;
Session::forcedToConnect();
$user = User::getUserAuth();
$messages = Message::getAllMessage($user->id);

?>

<div class="lis-group">
    <?php foreach($messages as $message): ?>
    <a href="/chat?username=<?= $message->username ?>" class="list-group-item">
        <em class="text-muted"><?= $message->username ?></em>
        <?= $message->content ?>
    </a>
    <?php endforeach ?>
</div>