
<?php $title = "Création de commentaire"; ?>
<?php ob_start(); ?>

    <section class="flex-container section-container">
        <h1>Commentaire ajouté avec succès !</h1>
        <p><b>Note</b> : <?= sanitizeInput($review); ?> / 5</p>
        <p class="read-recipe-section-flex-item first-article recipe"><b>Votre commentaire</b> : <?= sanitizeInput(strip_tags($comment)); ?></p>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>

