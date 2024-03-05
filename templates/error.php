<?php $title = "Site de Recettes"; ?>
<?php ob_start(); ?>

    <section class="flex-container section-container">
        <h1>Site de recettes</h1>
        <p>Une erreur est survenue : <?= $error_message ?></p>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>