<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="app/templates/assets/css/style.css">
</head>
<body>
<header>
    <nav class="flex-container nav-container">
        <a class="nav-flex-item first" href="index.php">Site de recettes</a>
        <a class="nav-flex-item second" href="index.php?action=contact">Contact</a>
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
            <a class="nav-flex-item third" href="index.php?action=login">Se connecter</a>
        <?php else : ?>
            <a class="nav-flex-item sixth" href="#"><?= htmlspecialchars($_SESSION['LOGGED_USER']['full_name']); ?></a>
            <a class="nav-flex-item fourth" href="index.php?action=recipes_create">Ajoutez une recette !</a>
            <a class="nav-flex-item fifth" href="index.php?action=logout">Déconnexion</a>
        <?php endif; ?>
    </nav>
</header>