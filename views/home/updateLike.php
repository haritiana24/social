<?php

/**
 * @author Haritiana24 
 */

use App\Model\Post;
use App\User;
use App\Model\Like;
use App\Debug\Dumper;

/**
 * user_id = User::getUserAuth();
 * post_id = $post->id;
 * like = +1 ou -1;
 * textLike = "j'aime ?? je n'aime plus";
 */

// Forced the user for authenticate
\App\Session::forcedToConnect();

$id = (int) $_GET['id'] ?? null;
$user = User::getUserAuth();
$post = Post::find($id);
$isLiked = Like::likeForOnePost($post->id);

if(empty($isLiked)){
    // create the like here
    Like::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'likes' => 1,
        'textLike' => "je n'aime plus"
    ]);
    $data = [
        'number' => Like::likeForOnePost($post->id),
        'userLike' => true
    ];
    echo json_encode($data);
}else{
    if(Like::userAlreadyLiked($user->id, $post->id)){
        Like::deleteLike($user->id, $post->id);
        $data = [
            'number' => Like::likeForOnePost($post->id),
            'userLike' => false
        ];
        echo json_encode($data);
    }else{
        Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'likes' => 1,
            'textLike' => "j'aime"
        ]);
        $data = [
            'number' => Like::likeForOnePost($post->id),
            'userLike' => true
        ];
        echo json_encode($data);
    }
}


die();
