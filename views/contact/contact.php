<?php

use App\HTML;
use App\Session;

$title = 'Nous contacter';
Session::forcedToConnect();
require_once '../data/config.php';
date_default_timezone_set('Europe/Paris');
$heure = (int)( $_GET['heure'] ?? date('G'));
$jour = (int)($_GET['jour'] ?? date('N') - 1);
$creneaux = CRENEAUX[$jour];
$ouvert = HTML::in_creneaux($heure, $creneaux);
$color = $ouvert ? 'green' : 'red';

$pdo = App\Database::getPdo();
$errors = null;
$success = false;
$guestbook = new App\GuestBook($pdo);
if (isset($_POST['username'], $_POST['message']))
{
    $message = new App\Message($_POST['username'], $_POST['message']);
    if ($message->isValid())
    {
        $guestbook->addMessage($message);
        $success = true;
        $_POST = [];
    }else{
        $errors = $message->getErrors();
    }
}
$messages = $guestbook->getMessage();
?>
<div class="row">
    <div class="col-md-8">
        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            Formulaire invalid
        </div>
        <?php endif; ?>

        <?php if ($success): ?>
        <div class="alert alert-success">
            Merci pour votre message
        </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <input value="<?= htmlentities($_POST['username'] ?? '') ?>" type="text" name="username"
                    placeholder="Votre pseudo"
                    class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>">
                <?php if (isset($errors['username'])):?>
                <div class="invalid-feedback"><?= $errors['username'] ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <textarea name="message" placeholder="Votre message"
                    class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"><?= htmlentities($_POST['message'] ?? '') ?></textarea>
                <?php if (isset($errors['message'])): ?>
                <div class="invalid-feedback"> <?= $errors['message'] ?></div>
                <?php endif; ?>
            </div>
            <button class="btn btn-primary">Envoyer</button>
        </form>
        <?php if (!empty($messages)): ?>
        <h1 class="mt-4">Vos message</h1>
        <?php foreach ($messages as $message):?>
        <?php
        $date = explode(' ', $message['created_at']);
        $dates = $date[0] . " à ".$date[1];
    ?>
        <p>
            <strong><a href="/edit?id=<?=$message['id'] ?>"><?=
                    $message['username']
                    ?></a></strong> <em>
                le
                <?= $dates?></em><br>
            <?=$message['message'] ?>
        </p>
        <?php endforeach; ?>
        <?php endif; ?>

    </div>
    <div class="col-md-4">
        <h2>Horaire d'ouverture</h2>
        <?php if ($ouvert) :?>
        <div class="alert alert-success">
            Le magasin sera ouvert
        </div>
        <?php else:?>
        <div class="alert alert-danger">
            Le magasin sera fermé
        </div>
        <?php endif; ?>
        <form action="" method="get">
            <div class="form-group">
                <?= HTML::select('jour', $jour, JOURS) ?>
            </div>
            <div class="form-group">
                <input class="form-control" type="number" name="heure" value="<?= $heure ?>">
            </div>
            <button type="submit" class="btn btn-primary">Voir si le magasin est ouvert</button>
        </form>
        <ul>
            <?php foreach (JOURS as $k => $jour ):?>
            <li <?php if($k + 1 === (int)date('N')):?> style="color:<?= $color ?>" <?php endif;?>>
                <strong><?= $jour ?> : </strong>
                <?= HTML::creneaux_html(CRENEAUX[$k]) ?>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>