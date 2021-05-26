<?php
use App\Model\Post;
use App\User;
$user = User::getUserAuth();
$title = "le publication " ;
$id = $_GET['id'] ?? null;
$post = Post::find($id);

?>

<div class="card m-3">
    <div class="card-header">
        <div class="card-title  titles">
            <?= $post->title?>
        </div>
    </div>
    <div class="card-body">
        <h3><?= $post->title ?></h3>
        <?php if($post->image):?>
        <img src="/images/posts/<?=$post->image?>" alt="<?= $post->image ?>">
        <?php endif ?>
        <p><?= $post->content ?></p>
        <div class="d-flex justify-content-between align-items-center ">
            <em class="text-muted"> Posté le : <?= $post->created_at ?></em>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2">
            <a href="/pubication/show?id=<?= $post->id ?>" class="btn
            btn-success"> <i class="fa fa-pencil-square-o"></i>Modifier</a>
            <a href="/publication/delete?id=<?= $post->id ?>" class="btn btn-danger"> <i
                    class="fa fa-trash"></i>Supprimer</a>
        </div>
    </div>
</div>