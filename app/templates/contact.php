<?php $title = "Page de contact"; ?>
<?php ob_start(); ?>

    <section class="flex-container section-container">
        <h1 class="section-flex-item title">Contactez nous</h1>
        <form class="flex-container form-container" action="index.php?action=submit_contact" method="POST" enctype="multipart/form-data">
            <label class="form-flex-item label" for="email">Email</label>
            <input class="form-flex-item input" placeholder="Votre email..." type="email" id="email" name="email" aria-describedby="email-help" required>
            <label class="form-flex-item label" for="message">Message</label>
            <textarea class="form-flex-item area" placeholder="Exprimez vous..." id="message" name="message" required></textarea>
            <input class="contact-form-flex-item fifth" type="file" id="screenshot" name="screenshot" />
            <button class="form-flex-item button" type="submit">Envoyer</button>
        </form>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?> 
