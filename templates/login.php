<?php $title = "Page de connexion"; ?>
<?php ob_start(); ?>

    <section class="flex-container section-container">
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
        <h1 class="section-flex-item title">Merci de vous connecter</h1>
        <form class="flex-container form-container" action="index.php?action=login" method="POST">
            <?php if (isset($_SESSION['csrf_token'])) : ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <?php else : ?>
                <?php generateCsrfToken(); ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <?php endif; ?>
            <?php if (isset($_SESSION['LOGIN_ERROR_MESSAGE'])) : ?>
                <p><?= htmlspecialchars($_SESSION['LOGIN_ERROR_MESSAGE']); unset($_SESSION['LOGIN_ERROR_MESSAGE']); ?></p>
            <?php endif; 
             if (isset($error) && $error === 'wrong_email_password') {
                echo "<p class='error-message'>Email ou mot de passe incorrect.</p>";
            } 
            ?>
            <label class="form-flex-item label" for="email">Email</label>
            <input class="form-flex-item input" type="email" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com" required>
            <label class="form-flex-item label" for="password">Mot de passe</label>
            <input class="form-flex-item input" type="password" id="password" name="password" required>
            <button class="form-flex-item button" type="submit">Se connecter</button>
            <a class="form-flex-item change-page-button" href="index.php?action=register">S'inscrire</a>
        </form>
        <?php endif; ?>
    </section>


<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
