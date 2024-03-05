<?php $title = "Page de contact"; ?>
<?php ob_start(); ?>

    <section class="flex-container section-container">
        <h1 class="section-flex-item title">Contactez nous</h1>
        <form class="flex-container form-container" action="index.php?action=contact" method="POST" enctype="multipart/form-data">
            <?php if (isset($_SESSION['csrf_token'])) : ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <?php else : ?>
                <?php generateCsrfToken(); ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <?php endif; ?>
            <label class="form-flex-item label" for="email">Email</label>
            <input class="form-flex-item input" placeholder="Votre email..." type="email" id="email" name="email" aria-describedby="email-help" required>
            <?php if (isset($data['errors']['email'])) : ?>
                <p class="error-message"><?= $data['errors']['email']; ?></p>
            <?php endif; ?>
            <label class="form-flex-item label" for="message">Message</label>
            <textarea class="form-flex-item area" placeholder="Exprimez vous..." id="message" name="message" required></textarea>
            <?php if (isset($data['errors']['message'])) : ?>
                <p class="error-message"><?= $data['errors']['message']; ?></p>
            <?php endif; ?>
            <input class="contact-form-flex-item fifth" type="file" id="screenshot" name="screenshot" />
            <?php if (isset($data['errors']['file_volume'])) : ?>
                <p class="error-message">L'envoi n'a pas pu être effectué : <?= $data['errors']['file_volume']; ?></p>
            <?php endif; ?>
            <?php if (isset($data['errors']['file_extension'])) : ?>
                <p class="error-message">L'envoi n'a pas pu être effectué : <?= $data['errors']['file_extension']; ?></p>
            <?php endif; ?>
            <?php if (isset($data['errors']['file_path'])) : ?>
                <p class="error-message">L'envoi n'a pas pu être effectué : <?= $data['errors']['file_path']; ?></p>
            <?php endif; ?>
            <button class="form-flex-item button" type="submit">Envoyer</button>
        </form>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?> 
