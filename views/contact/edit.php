<?php

use App\Database;
use App\Session;

$title = "Modifier le message";
Session::forcedToConnect();
$errors = [];
$pdo = Database::getPdo();
$id = (int)$_GET['id'] ?? null;
$req = $pdo->prepare("SELECT * FROM messages WHERE id=:id");
$req->execute([
    'id' => $id
]);
$message = $req->fetch();

if(!empty(($_POST))){
    if(empty($_POST['username'])){
        $errors['username'] = 'this filed username is required';
    }
    if(empty($_POST['message'])){
        $errors['message'] = 'this filed message is requried';
    }
    if (empty($errors)){
        $req = $pdo->prepare("UPDATE messages SET username= :username, message = :message WHERE id=:id");
        $req->execute([
            'username' => $_POST['username'],
            'message' => $_POST['message'],
            'id' => $id
        ]);
        header('Location: /contact');
    }
}
?>

<h1>Modifier le message <?= $message->username?></h1>

<form action="" method="post">
    <div class="form-group">
        <input value="<?= htmlentities($_POST['username'] ?? $message->username) ?>" type="text" name="username"
            class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>">
        <?php if (isset($errors['username'])):?>
        <div class="invalid-feedback"><?= $errors['username'] ?></div>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <textarea name="message" placeholder="Votre message"
            class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"><?= htmlentities($_POST['message'] ?? $message->message) ?></textarea>
        <?php if (isset($errors['message'])): ?>
        <div class="invalid-feedback"> <?= $errors['message'] ?></div>
        <?php endif; ?>
    </div>
    <button class="btn btn-success"> <i class="fa fa-pencil-square-o"></i> Modifier</button>
    <a href="/delete?id=<?= $message->id ?>" class="btn btn-danger" id="salut"> <i class="fa fa-trash"></i>
        supprimer</a>
</form>