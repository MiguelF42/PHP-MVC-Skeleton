<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <?= $loader ?>
    <title>Website | <?= $title ?></title>
</head>
<body>
    <header>
        <nav>
            
        </nav>
    </header>
    <main>
        <?= $content ?>
    </main>
    <footer>
        <p>Website | <?= date('Y') ?></p>
    </footer>
    <?= $script ?>
</body>
</html>