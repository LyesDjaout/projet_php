<?php $title = "Site de Recettes - Page de contact"; ?>
<?php ob_start(); ?>
    <h1>Contactez nous</h1>
    <form action="index.php?action=submit_contact" method="POST" enctype="multipart/form-data">
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" aria-describedby="email-help" required>
        </div>
        <div>
            <label for="message">Votre message</label>
            <textarea placeholder="Exprimez vous" id="message" name="message" required></textarea>
        </div>
        <div>
            <label for="screenshot">Votre capture d'écran</label>
            <input type="file" id="screenshot" name="screenshot" />
        </div>
        <button type="submit">Envoyer</button>
    </form>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?> 
