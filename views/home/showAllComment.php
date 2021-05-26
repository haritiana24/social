<?php 

/**
 * @author Haritiana24
 */

use App\Model\Comment;
use App\Debug\Dumper;
use App\Model\Post;
use App\Model\Like;
use App\User;
use App\Session;

$user = User::getUserAuth();
Session::forcedToConnect();

$idPost = $_GET['id'] ?? null;
$post = Comment::getOneRelationResults($idPost);
?>

<div class="row">
    <aside id="modal" class="modal" arria-hidden="true" role="dialog" arrai-labelledby="title-modal" style="display:none;">
        <div class="modal-wrapp js-modal-stop">
        <button class="btn btn-primary js-close-modal">X</button>
        <h4 id="title-modal">Le utlisateur qui à aimée cette publication</h4>
            <ul>
            <?php foreach(User::getUserLikeThepost($idPost) as $user):?>
                <a href="profil/show?username=<?= $post->username ?>"><?=  $user->username?></a><br>
            <?php endforeach ?>
            </ul>
        </div>
    </aside>
    <div class="col-md-8">
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
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
      <?php foreach(Comment::getCommentWhitYourUser($idPost) as $comment): ?>
        <div class="card mb-2">
            <div class="card-body comment">
                <?=$comment->content ?>
                <div class="d-flex justify-content-between align-items-center">
                    <small>Posté le <?= $comment->created_at?>  </small>
                    <span class="badge badge-primary">
                        <?= $comment->username?>
                    </span>
                </div>
            </div>
        </div>
      <?php  endforeach?>
    </div>
</div>

