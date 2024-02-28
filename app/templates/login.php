<?php $title = "Site de Recettes - Page de connexion"; ?>
<?php ob_start(); 
    if (!isset($_SESSION['LOGGED_USER'])) : ?>
    <form action="index.php?action=submit_login" method="POST">
        <!-- si message d'erreur on l'affiche -->
        <?php if (isset($_SESSION['LOGIN_ERROR_MESSAGE'])) : ?>
            <div role="alert">
                <?php echo htmlspecialchars($_SESSION['LOGIN_ERROR_MESSAGE']);
                unset($_SESSION['LOGIN_ERROR_MESSAGE']); ?>
            </div>
        <?php endif; ?>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com" required>
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Se connecter</button>
        <a href="index.php?action=register">S'inscrire</a>
    </form>
    <?php endif; ?>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
