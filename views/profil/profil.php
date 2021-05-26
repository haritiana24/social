<?php

use App\Controller\UserController;
use App\Session;
use App\User;
Session::forcedToConnect();
$title = "Votre profil ";

?>

<div class="row">
    <div class="col-md-2">
        <ul>
            <li><a href="/">Fil d'actualité</a></li>
            <li><a href="/message">Message</a></li>
            <li><a href="/groupe">Groupe</a></li>
            <li><a href="/publication">Publication</a></li>
        </ul>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <card class="titles">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="/profil">
                            <?php if(User::getUserAuth()->image): ?>
                            <img src="/images/<?=User::getUserAuth()->image?>" alt="<?= User::getUserAuth()->image ?>">
                            <?= User::getUserAuth()->username ?>
                            <?php else : ?>
                            <img src="/images/image.jpg" alt="defalut">
                            <?= User::getUserAuth()->username ?>
                            <?php endif ?>
                        </a>
                        <a href="/logout">déconnexion</a>
                    </div>

                </card>
            </div>
            <div class="card-body">
                <p>Votre adresse email : <em class="text-muted"><?= User::getUserAuth()->email ?></em></p>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="/profil/post" class="btn btn-primary"> <i class="fa fa-plus-circle"></i> Ajouter une
                        post</a>
                    <a href="profil/update?id=<?= User::getUserAuth()->id ?>" class="btn btn-success"> <i
                            class="fa fa-pencil-square-o"></i> Modifier votre
                        profil</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h6>Discussion instatannée</h6>
                </div>
            </div>
            <div class="card-body">
                <ul class="list">
                    <?php if(is_array(UserController::getAllUser())): ?>
                    <?php foreach(UserController::getAllUser() as $connecte): ?>
                    <li>
                        <a href="/chat?username=<?= $connecte->username ?>"><?= $connecte->username ?></a>
                    </li>
                    <?php endforeach ?>
                    <?php else: ?>
                    <li>
                        <a href="#"><?= UserController::getAllUser()->username ?></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>