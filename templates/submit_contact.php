<?php $title = "Page de contact"; ?>
<?php ob_start(); ?>

    <section class="flex-container section-container">
        <h1>Message bien reçu !</h1>
        <h4>Rappel de vos informations</h4>
        <p><b>Email</b> : <?= sanitizeInput($email); ?></p>
        <p><b>Message</b> : <?= sanitizeInput(strip_tags($message)); ?></p>
        <?php if ($isFileLoaded) : ?>
            <p>L'envoi a bien été effectué !</p>
        <?php endif; ?>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
