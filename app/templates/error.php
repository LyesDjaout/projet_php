<?php $title = "Site de Recettes"; ?>
<?php ob_start(); ?>
    <h1>Site de recettes</h1>
    <p>Une erreur est survenue : <?= $error_message ?></p>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>