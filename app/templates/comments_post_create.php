
<?php $title = "Création de commentaire"; ?>
<?php ob_start(); ?>
    <h1>Commentaire ajouté avec succès !</h1>
    <p><b>Note</b> : <?php echo htmlspecialchars($review); ?> / 5</p>
    <p><b>Votre commentaire</b> : <?php echo htmlspecialchars(strip_tags($comment)); ?></p>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>

