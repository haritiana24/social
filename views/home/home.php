<?php

use App\HTML;
use App\Model\Comment;
use App\Session;
use App\User;
use App\Model\Like;

$user = User::getUserAuth();
Session::forcedToConnect();

?>

<?php if(!empty(Comment::getRelationResults())):?>
<?php foreach(Comment::getRelationResults() as $post): ?>
<aside id="modal" class="modal" arria-hidden="true" role="dialog" arrai-labelledby="title-modal" style="display:none;">
    <div class="modal-wrapp js-modal-stop">
    <button class="btn btn-primary js-close-modal">X</button>
    <h4 id="title-modal">Le utlisateur qui à aimée cette publication</h4>
        <ul>
        <?php foreach(User::getUserLikeThepost($post->id) as $user):?>
            <li><?=  $user->username?></li>
        <?php endforeach ?>
        </ul>
    </div>
</aside>
<div class="card m-3">
    <div class="card-header">
        <div class="card-title  titles">
            <?php if(!is_null($post->imageUser)):?>
            <a href="profil/show?username=<?= $post->username ?>"> <img src="/images/<?= $post->imageUser ?>"
                    alt="image">
                <?= ucfirst($post->username)  ?> </a>
            <?php else : ?>
            <a href="profil/show?username=<?= $post->username ?>"> <img src="/images/image.jpg" alt="image">
                <?= ucfirst($post->username) ?> </a>
            <?php endif ?>
        </div>
    </div>
    <div class="card-body">
        <h3><?= $post->title ?></h3>
        <?php if($post->image):?>
        <img src="/images/posts/<?=$post->image?>" alt="<?= $post->image ?>">
        <?php endif ?>
        <p><?= $post->content ?></p>
        <div class="d-flex justify-content-between align-items-center titles">
            <em class="text-muted"> Posté le : <?= $post->created_at ?></em>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <form action="/updateLike?id= <?= $post->id ?>" method="post" data-likes="" class="likes">
                <button class="btn btn-primary mt-2 t">
                    <?php if(Like::userLikePost($post->id)):?>
                        <?= Like::likeForOnePost($post->id) ?> je n'aime plus
                    <?php else: ?>
                        <?= Like::likeForOnePost($post->id) ?> j'aime
                    <?php endif ?>
                </button>
                <?php if(!empty(User::theUserLikePost($post->id))):?>
                <a href="#modal" class="link-modal">
                     <?=User::theUserLikePost($post->id) > 1 ? User::theUserLikePost($post->id) . " personnes aime  cette publication" : " Une personne aime cette publication" ?>
                </a>
                <?php else: ?>
                <a href="/show?id=<?= $post->id?>">
                    aucune presonne aime cette publication
                </a>
                <?php  endif ?>
            </form>
            <?php if(isset($_SESSION['auth'])): ?>
            <p onclick="replyComment(<?=$post->id?>)" class="fakeLink">
                <?= Comment::countCommentForOneUser($post->id) ?> Commentaire
            </p>
            <?php endif; ?>
        </div>
    </div>
</div>
<form action="/addComment?id=<?= $post->id?>" method="POST" class="d-none" id="comment<?=$post->id?>">
    <div class="form-group ml-5">
        <label for="comment">votre commentaire : </label>
        <textarea name="comment" id="comment" class="form-control">
        </textarea>
        <input type="hidden" name="id" value="<?=$post->id ?>">
        <button class="btn btn-primary mt-2" id="button<?= $post->id ?>">
            commenter
        </button>
    </div>
</form>
<?php if(!empty(Comment::getCommentWhitYourUser($post->id))):?>
<h6 class="ml-5 showComment">Commentaires : </h6>
<?= Comment::render($post->id) ?>
<?php else: ?>
<div class="alert alert-info">
    Aucunce commentaire sur cette post
</div>
<?php endif ?>
<?php endforeach; ?>
<?php else:?>
<div class="alert alert-info text-center">
<h1 >Aucune publication disponible</h1>
</div>
<?php  endif; ?>