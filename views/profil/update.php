<?php

use App\Database;
use App\User;
$title = "Update profil"; 
$user = User::getUserAuth();
$errors = [];
$pdo = Database::getPdo();

if(!empty($_POST)){
    if(empty($_POST['email'])){
        $errors['email'] = "Le champ email est obligatoire";
    }
     if(empty($_POST['username'])){
        $errors['username'] = "Le champ  pseudo  est obligatoire";
    }
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
        // if ($_FILES['image']['size'] <= 1000000){
        //     $errors['image'] = "Votre image est trop grand";
        // }

        $infosFile = pathinfo($_FILES['image']['name']);
        $extension_upload = $infosFile['extension'];
        $goodExtension = ['jpg', 'JPG', 'jpge', 'gif', 'png'];
        if(!in_array($extension_upload, $goodExtension)){
            $errors['image'] = "Votre ficher n'est pas valide";
        }

    }

    if(empty($errors)){
        $file = basename($_FILES['image']['name']);
        if(empty($file)){
            $file = $user->image;
        }
        move_uploaded_file($_FILES['image']['tmp_name'], 'images//'. $file);
        User::update([
            'email' => $_POST['email'],
            'username' => $_POST['username'],
            'image' => $file
        ], $user->id);
        header('Location: /profil');
    }

}


 ?>
<h1>Modifier votre profil</h1>
<?php if($errors):?>
<ul class="alert alert-danger">

    <?php foreach($errors as $key => $error): ?>
    <li><?= $key . " =>" .$error ?></li>
    <?php endforeach ?>
</ul>
<?php endif; ?>


<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="email">Adresse email </label>
        <input type="text" class="form-control" name="email" value="<?= htmlentities($user->email ??null) ?>">
    </div>
    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" class="form-control" name="username" value="<?= htmlentities($user->username ?? null) ?>">
    </div>
    <div class="form-group">
        <label for="">Changer le photo de profil</label>
        <input type="file" name="image" class="form-control" value="<?= htmlentities($user->image ?? null) ?>">
    </div>
    <button class="btn btn-success">Modification</button>
</form>