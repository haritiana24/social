<?php

use App\Session;
use App\User;

$username =  $_GET['username'] ?? '';
$user = User::findWithUserName($username);
$userAuth =  User::getUserAuth();
Session::forcedToConnect();

?>

<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="d-flex justify-content-between align-items-center title">
            <h3>Profil de <?= $user->username ?></h3>
            <?php if($user->username !== $userAuth->username): ?>
            <a href="/chat?username=<?= $user->username ?>">Message</a>
            <?php endif ?>
        </div>
        <div class="profil">
            <?php if(!is_null($user->image)): ?>
            <img src="/images/<?=$user->image?>" alt="<?= $user->image ?>">
            <p class="pt-3"> Adresse email : <em class="text-muted"><?= $user->email ?></em></p>
            <?php else : ?>
            <img src="/images/image.jpg" alt="<?= $user->image ?>">
            <p class="pt-3">
                Adresse email : <em class="text-muted"><?= $user->email ?></em>
            </p>
            <?php endif ?>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>