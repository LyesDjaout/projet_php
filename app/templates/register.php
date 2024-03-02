<?php $title = "Page d'inscription"; ?>
<?php ob_start(); ?> 

    <section class="flex-container section-container">
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
        <h1 class="section-flex-item title">Vueillez vous inscrire</h1>
        <form class="flex-container form-container" action="index.php?action=submit_register" method="POST">
            <?php if (isset($_SESSION['REGISTER_ERROR_MESSAGE'])) : ?>
                <p><?php echo htmlspecialchars($_SESSION['REGISTER_ERROR_MESSAGE']); unset($_SESSION['REGISTER_ERROR_MESSAGE']); ?></p>
            <?php endif; ?>
            <label class="form-flex-item label" for="full_name">Nom complet</label>
            <input class="form-flex-item input" type="text" id="full_name" name="full_name" aria-describedby="full_name-help" required>
            <label class="form-flex-item label" for="age">Age</label>
            <input class="form-flex-item input" type="number" id="age" name="age" aria-describedby="age-help" required>
            <label class="form-flex-item label" for="email">Email</label>
            <input class="form-flex-item input" type="email" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com" required>
            <label class="form-flex-item label" for="password">Mot de passe</label>
            <input class="form-flex-item input" type="password" id="password" name="password" required>
            <button class="form-flex-item button" type="submit">S'inscrire</button>
            <a class="form-flex-item change-page-button" href="index.php?action=login">Se connecter</a>
        </form>
        <?php endif; ?>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
