<?php

use App\Register\ValidationFile;
use App\Session;

if(Session::isConnected()){
    header('Location: /home');
}

$title = 'Page de connexion';
$errors = [];


if (!empty($_POST))
{
    $validation = new ValidationFile($_POST['pseudo'], $_POST['password']);
    if(!$validation->isValid()){
        $errors['pseudo'] = 'Le champ pseudo est obligatoir';
        $errors['password'] = 'Le champ password est obligatior';
    }else{
       $user =  $validation->loginUser();
       if(is_null($user)){
           $errors['error'] = "Votre pseudo ou votre mots de pass est incrorrecte";
       }else{
           header("Location : /home");
           http_response_code(301);
       }
    }
}

?>
<h1 class="title-home">Bienvenue sur ZARAO :) </h1>
<div class="row mt-3">
    <div class=" col-md-4"></div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h6>Connexion</h6>
                </div>
            </div>
            <div class="card-body">
                <?php if (isset($errors['error'])):?>
                <div class="alert alert-danger"> <?= $errors['error'] ?></div>
                <?php endif;?>
                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" name="pseudo" class="form-control
                        <?= $errors['pseudo'] ? ' is-invalid' : null ?>" placeholder="Votre pseudo...">
                        <?php if(isset($errors['pseudo'])):?>
                        <div class="invalid-feedback">
                            <?= $errors['pseudo'] ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password"
                            class="form-control <?= $errors['password'] ? ' is-invalid' : null ?>"
                            placeholder="Votre mots de passe...">
                        <?php if(isset($errors['password'])):?>
                        <div class="invalid-feedback">
                            <?= $errors['password'] ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Connexion</button>
                            <a href="/reset">Mots de passe oubier?</a>
                        </div>
                        <div class="co-md-6">
                            <a href="/register" class="btn btn-success"> S'inscrire</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>