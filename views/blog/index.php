<?php
$title = "Notre blog";
$pdo = App\Database::getPdo();
$error = null;
$success = null;
$query = $pdo->query('SELECT * FROM posts');
$posts = $query->fetchAll();
try{
    if(isset($_POST['name'], $_POST['content']))
    {
        $query = $pdo->prepare('INSERT INTO posts (name, content) VALUES(:name,:content)');
        $query->execute([
            'name' => $_POST['name'],
            'content' => $_POST['content']
        ]);
        $success = 'Votre article à bien été ajouter';
    }
}catch (PDOException $e)
{
    $error = $e->getMessage();
}

// Apprendre a coder avec moi


require '../elements/header.php';
?>
<div class="container">
    <?php if($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <?php if($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="form-group">
            <input class="form-control" type="text" name="name" placeholder="Titre de l'article">
        </div>
        <div class="form-group">
            <textarea name="content" class="form-control" placeholder="Contenue de l'article"></textarea>
        </div>
        <button class="btn btn-primary">Ajouter</button>
    </form>
    <?php foreach($posts as $post): ?>
    <h2><a href="blog/edit.php?id=<?= $post->id ?>"><?= htmlentities($post->name) ?></a></h2>
    <p>
        <?= nl2br(htmlentities($post->content)) ?>
    </p>
    <?php endforeach; ?>
</div>