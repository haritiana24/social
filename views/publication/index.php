<?php
use App\Model\Post;
use App\User;
$user = User::getUserAuth();
?>
<h1>Les publication de <?= $user->username ?></h1>

<ul>
    <?php foreach(Post::getUserPosts($user->id) as $post): ?>
    <li>
        <div class="d-flex justify-content-between align-items-center">
            <a href="/publication/show?id=<?= $post->id ?>">
                <?= $post->title ?>
            </a>
            <em class="text-muted"> Le <?= $post->created_at ?></em>
        </div>
    </li>
    <?php endforeach; ?>
</ul>