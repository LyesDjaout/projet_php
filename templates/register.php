<?php $title = "Page d'inscription"; ?>
<?php ob_start(); ?> 

    <section class="flex-container section-container">
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
        <h1 class="section-flex-item title">Veuillez vous inscrire</h1>
        <form class="flex-container form-container" action="index.php?action=register" method="POST">
            <?php if (isset($_SESSION['csrf_token'])) : ?>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <?php else : ?>
                <?php generateCsrfToken(); ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <?php endif; ?>
            <label class="form-flex-item label" for="full_name">Nom complet</label>
            <input class="form-flex-item input" type="text" id="full_name" name="full_name" aria-describedby="full_name-help" required>
            <?php if (isset($data['errors']['fullname'])) : ?>
                <p class="error-message"><?= $data['errors']['fullname']; ?></p>
            <?php endif; ?>
            <label class="form-flex-item label" for="age">Age</label>
            <input class="form-flex-item input" type="number" id="age" name="age" aria-describedby="age-help" required>
            <?php if (isset($data['errors']['age'])) : ?>
                <p class="error-message"><?= $data['errors']['age']; ?></p>
            <?php endif; ?>
            <label class="form-flex-item label" for="email">Email</label>
            <input class="form-flex-item input" type="email" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com" required>
            <?php if (isset($data['errors']['email'])) : ?>
                <p class="error-message"><?= $data['errors']['email']; ?></p>
            <?php endif; ?>
            <label class="form-flex-item label" for="password">Mot de passe</label>
            <input class="form-flex-item input" type="password" id="password" name="password" required>
            <?php if (isset($data['errors']['password'])) : ?>
                <p class="error-message"><?= $data['errors']['password']; ?></p>
            <?php endif; ?>
            <?php
            if (isset($error) && $error === 'email_exists') {
                echo "<p class='error-message'>Cet email est déjà enregistré. Choisissez un autre email.</p>";
            } 
            ?>
            <button class="form-flex-item button" type="submit">S'inscrire</button>
            <a class="form-flex-item change-page-button" href="index.php?action=login">Se connecter</a>
        </form>
        <?php endif; ?>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
