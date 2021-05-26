<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= $bootstrap ?>">
    <link rel="stylesheet" href="<?= $font ?>">
    <link rel="stylesheet" href="<?= $css ?>">
    <script src="<?= $jquery?>" defer></script>
    <script src="<?= $js ?>" defer></script>
    <title>
        <?= $title ?? "Zarao" ?>
    </title>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-primary mb-4">
        <a class="navbar-brand" href="#">ZARAO</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <?= App\HTML::nav_menu('nav-link') ?>
            </ul>
            <ul class="navbar-nav titles">
                <?php if(App\Session::isConnected()) :?>
                <?php if(\App\User::getUserAuth()->image):?>
                <img src="/images/<?= \App\User::getUserAuth()->image
                        ?>" alt="imagesDefault" class="imagLayout">
                <?php else: ?>
                <img src="/images/image.jpg" alt="imagesDefault" class="imagLayout">
                <?php endif  ?>

                <?= App\HTML::nav_item('/profil', App\User::getUserAuth()->username, 'nav-link')?>
                <?php else: ?>
                <?= App\HTML::nav_item("/register", "S'inscrire", "nav-link") ?>
                <?php endif ?>
            </ul>
        </div>
    </nav>
    <div class="container">
        <?= $content ?>
    </div>
</body>

</html>