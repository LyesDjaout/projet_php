<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="templates/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />
</head>
<body>
<header>
    <nav class="flex-container nav-container">
        <a class="nav-flex-item first" href="index.php">Site de recettes</a>
        <a class="nav-flex-item first icone-menu" href="index.php">
            <i class="fa-solid fa-house"></i>
        </a>
        <a class="nav-flex-item second" href="index.php?action=contact">Contact</a>
        <a class="nav-flex-item second icone-menu" href="index.php?action=contact">
            <i class="fa-regular fa-message"></i>
        </a>
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
            <a class="nav-flex-item third" href="index.php?action=login">Se connecter</a>
            <a class="nav-flex-item third icone-menu" href="index.php?action=login">
                <i class="fa-solid fa-right-to-bracket"></i>
            </a>
        <?php else : ?>
            <a class="nav-flex-item sixth" href="#"><?= sanitizeInput($_SESSION['LOGGED_USER']['full_name']); ?></a>
            <a class="nav-flex-item sixth icone-menu" href="#">
                <i class="fa-regular fa-user"></i>
            </a>
            <a class="nav-flex-item fourth" href="index.php?action=create_recipe">Ajoutez une recette !</a>
            <a class="nav-flex-item fourth icone-menu" href="index.php?action=create_recipe">
                <i class="fa-solid fa-plus"></i>
            </a>
            <a class="nav-flex-item fifth" href="index.php?action=logout">Déconnexion</a>
            <a class="nav-flex-item fifth icone-menu" href="index.php?action=logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        <?php endif; ?>
    </nav>
</header>