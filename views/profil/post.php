<?php

use App\Date\GenerateDate;
use App\Model\Post;
use App\User;

$title = "Ajouter une novelle publication";
 $errors = [];
 
 if(!empty($_POST)){
    if(empty($_POST['title']) || strlen($_POST['title']) < 5){
        $errors['title'] = "Votre titre est trop court";
    }
    if(empty($_POST['content']) || strlen($_POST['title']) < 10){
        $errors['content'] = 'Le contenue de est trop court';
    }
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
        $infosFile = pathinfo($_FILES['image']['name']);
        $extension_upload = $infosFile['extension'];
        $goodExtension = ['jpg', 'jpge', 'gif', 'png'];
        if(!in_array($extension_upload, $goodExtension)){
            $errors['image'] = "Votre ficher n'est pas valide";
        }
    }

    if(empty($errors)){
        $file = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], 'images/posts/'. $file);
        Post::create([
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'image' => $file,
            'user_id' => (int) User::getUserAuth()->id,
            'created_at' => GenerateDate::now(),
            'updated_at' => GenerateDate::now()
        ]);
        header("Location: /");

        // HttpRequestFondation for Symfony 
    }
 }
  ?>

<h1>Publier quelque chose </h1>

<?php if($errors):?>
<ul class="alert alert-danger">

    <?php foreach($errors as $key => $error): ?>
    <li><?= $key . " =>" .$error ?></li>
    <?php endforeach ?>
</ul>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">AJouter une titre</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="content">Ajouter la contenue de la publication</label>
        <textarea name="content" id="content" class="form-control" rows="5"></textarea>
    </div>
    <div class="form-group">
        <label for="content">Une image peut être??</label>
        <input type="file" class="form-control" name="image">
    </div>
    <button class="btn btn-primary">Publier</button>
</form>