<?php $title = "Page de création de recettes"; ?>
<?php ob_start(); ?>
    
    <section class="flex-container section-container">
        <h1>Recette ajoutée avec succès !</h1>
        <h4><?= htmlspecialchars($title_recipe); ?></h4>
        <p class="read-recipe-section-flex-item first-article recipe"><?= htmlspecialchars($recipe); ?></p>
    </section>
    
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
