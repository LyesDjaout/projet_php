<?php $title = "Site de Recettes - Page d'inscription"; ?>
<?php ob_start(); ?> 
    <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
        <form action="index.php?action=submit_register" method="POST">
            <!-- si message d'erreur on l'affiche -->
            <?php if (isset($_SESSION['REGISTER_ERROR_MESSAGE'])) : ?>
                <div role="alert">
                    <?php echo htmlspecialchars($_SESSION['REGISTER_ERROR_MESSAGE']);
                    unset($_SESSION['REGISTER_ERROR_MESSAGE']); ?>
                </div>
            <?php endif; ?>
            <div>
                <label for="full_name">Nom complet</label>
                <input type="text" id="full_name" name="full_name" aria-describedby="full_name-help" required>
            </div>
            <div>
                <label for="age">Age</label>
                <input type="number" id="age" name="age" aria-describedby="age-help" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com" required>
            </div>
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">S'inscrire</button>
            <a href="index.php?action=login">Se connecter</a>
        </form>
    <?php endif; ?>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
