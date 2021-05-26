<?php

use App\Ajax\Ajax;
use App\Controller\CommentController;
use App\Date\GenerateDate;
use App\User;

$id = $_GET["id"] ?? null;
if(is_null($id)){
    throw new Exception("Not post for this id");
}
$errors = [];
$user = User::getUserAuth();

if(!empty($_POST)){
     $commentController = new CommentController(trim($_POST['comment'], " \t\n\r\0\x0B"), $user);
     if(!$commentController->isCommentValid()){
        if(Ajax::isAjax()){
            $errors['comment'] = "Vous ne pouvez pas posté une commtaire vide";
            // send the error to ajax 
            echo json_encode($errors);
            header('Content-Type: application/json');
            http_response_code(400);
            die();
        }
     }else{
        if(Ajax::isAjax()){
            // send the all data to the ajax 
            echo json_encode([
                'success' => 'Merci pour votre commentaire',
                'comment' => trim($_POST['comment'], " \t\n\r\0\x0B"),
                'username' => $user->username,
                'date' => GenerateDate::now()
            ]);
            header('Content-Type: application/json');
            $commentController->addComment((int)$_POST['id'], "App\Model\Post");
            die();
        }   
    }
     
 }