<?php $title = "Page de connexion"; ?>
<?php ob_start(); ?>

    <section class="flex-container section-container">
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
        <h1 class="section-flex-item title">Merci de vous connecter</h1>
        <form class="flex-container form-container" action="index.php?action=submit_login" method="POST">
            <?php if (isset($_SESSION['LOGIN_ERROR_MESSAGE'])) : ?>
                <p><?= htmlspecialchars($_SESSION['LOGIN_ERROR_MESSAGE']); unset($_SESSION['LOGIN_ERROR_MESSAGE']); ?></p>
            <?php endif; ?>
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
