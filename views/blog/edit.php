<?php
require_once '../functions/database.php';
$title = "Notre blog";
$pdo = getPdo();
$error = null;
$success = null;
try{
    if(isset($_POST['name'], $_POST['content']))
    {
        $query = $pdo->prepare('UPDATE posts SET name=:name, content=:content WHERE id=:id');
        $query->execute([
            'name' => $_POST['name'],
            'content' => $_POST['content'],
            'id' => $_GET['id']
        ]);
        $success = 'Votre article à bien été modifier';
    }
    $query = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
    $query->execute(['id' => $_GET['id']]);
    $post = $query->fetch();
}catch (PDOException $e)
{
    $error = $e->getMessage();
}
require '../elements/header.php';
?>
<div class="container">
    <p>
        <a href="/blog">Révenir au listing</a>
    </p>
    <?php if($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <?php if($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="form-group">
            <input class="form-control" type="text" name="name" value="<?= htmlentities($post->name) ?>">
        </div>
        <div class="form-group">
            <textarea name="content" class="form-control"><?= htmlentities($post->content) ?></textarea>
        </div>
        <button class="btn btn-success">Sauvegarder</button>
        <a href="/blog/delete.php?id=<?= $post->id ?>" class="btn
        btn-danger">supprimer</a>
    </form>
</div>
<?php require '../elements/footer.php' ?>