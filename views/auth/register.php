<?php
/**
 * Author
 * Haritina Randria
 */

use App\Database;

$pdo = Database::getPdo();
$errors = [];
if(!empty($_POST)){

    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Votre email n \'est pas valide ';
    }
    if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
        $errors['username'] = 'Votre pseudo n \'est pas valide';
    }
    if(empty($_POST['password']) || $_POST['password'] !== $_POST['password_confirm']){
        $errors['password'] = 'Vous devez entre une mots de passe valide';
        $errors['password_confirm'] = 'Vous devez entre une mots de passe valide';
    }
    if(empty($errors)){
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        App\User::create([
            'email' => $_POST['email'],
            'username' => $_POST['username'],
            'password' => $password,
            'created_at' => App\Date\GenerateDate::now(),
            'updated_at' => App\Date\GenerateDate::now()
        ]);
        session_start();
        $_SESSION['connecte'] = 1;
        header('Location: /dashboard');
        $_POST = [];
    }
}
?>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h6>Création d'un compte </h6>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="email">Votre adress email</label>
                        <input type="email" class="form-control <?= $errors['email'] ? 'is-invalid' : null?>" id="email"
                            name="email" value="<?= htmlentities($_POST['email'] ?? '') ?>">
                        <?php if (isset($errors['email'])):?>
                        <div class="invalid-feedback">
                            <?= $errors['email'] ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="username">Votre pseudo</label>
                        <input type="text" class="form-control <?= $errors['username'] ? 'is-invalid' : null?>"
                            id="username" name="username" value="<?= htmlentities($_POST['username'] ?? '') ?>">
                        <?php if (isset($errors['username'])):?>
                        <div class="invalid-feedback">
                            <?= $errors['username'] ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Votre mots de passe</label>
                        <input type="password" class="form-control
                        <?=$errors['password'] ? 'is-invalid' : null?>" id="password" name="password">
                        <?php if (isset($errors['password'])):?>
                        <div class="invalid-feedback">
                            <?= $errors['password'] ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="password_confrim">Confirmer votre mots de pass</label>
                        <input type="password"
                            class="form-control <?=$errors['password_confrim'] ? 'is-invalid' : null?>"
                            id="password_confrim" name="password_confirm">
                        <?php if (isset($errors['password_confrim'])):?>
                        <div class="invalid-feedback">
                            <?= $errors['password_confrim'] ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-primary">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>