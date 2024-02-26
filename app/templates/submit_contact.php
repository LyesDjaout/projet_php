<?php $title = "Site de Recettes - Page de contact"; ?>
<?php ob_start(); ?>
    <h1>Message bien reçu !</h1>
    <div>
        <div>
            <h5>Rappel de vos informations</h5>
            <p><b>Email</b> : <?php echo htmlspecialchars($postData['email']); ?></p>
            <p><b>Message</b> : <?php echo htmlspecialchars(strip_tags($postData['message'])); ?></p>
            <?php if ($isFileLoaded) : ?>
                <div role="alert">
                    L'envoi a bien été effectué !
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
