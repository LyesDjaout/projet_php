<?php $title = "Page de modification de recettes"; ?>
<?php ob_start(); ?>

    <section class="flex-container section-container">
        <h1 class="update-recipe-section-flex-item title">Recette modifiée avec succès !</h1>
        <h4 class="update-recipe-section-flex-item title_recipe"><?= htmlspecialchars($title_recipe); ?></h4>
        <p class="read-recipe-section-flex-item first-article recipe"><?= htmlspecialchars($recipe); ?></p>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
