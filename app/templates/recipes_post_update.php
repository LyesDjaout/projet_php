<?php $title = "Site de Recettes - Page de modification de recettes"; ?>
<?php ob_start(); ?>
    <h1>Recette modifiée avec succès !</h1>
    <div>
        <div>
            <h5><?php echo htmlspecialchars($title); ?></h5>
            <p><b>Email</b> : <?php echo htmlspecialchars($_SESSION['LOGGED_USER']['email']); ?></p>
            <p><b>Recette</b> : <?php echo htmlspecialchars($recipe); ?></p>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
