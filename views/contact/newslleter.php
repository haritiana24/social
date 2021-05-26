<?php
$title = 'Newslleter';
$email = null;
$success = null;
$error = null;
if(!empty($_POST['email']))
{
    $email = $_POST['email'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $file = __DIR__. DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . date('Y-m-d');
        file_put_contents($file,$email . PHP_EOL,FILE_APPEND);
        $success = 'Votre email à bien été enregistre';
        $email = null;
    }else{
        $error = "Email invalide";
    }
}
?>
<h1>S'inscrire à la newslleter</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum deleniti doloribus iste neque praesentium quas qui rem.
    Atque delectus doloribus eius illum molestias odit quas reprehenderit, rerum tenetur ullam veniam.</p>
<?php if ($error): ?>
<div class="alert alert-danger">
    <?=$error?>
</div>
<?php endif; ?>
<?php if($success): ?>
<div class="alert alert-success">
    <?=$success?>
</div>
<?php else: ?>
<form action="newslleter.php" method="post" class="form-inline">
    <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Enter votre email..."
            value="<?= htmlentities($email) ?>">
    </div>
    <button type="submit" class="btn btn-primary">S'inscrire</button>
</form>
<?php endif; ?>