<nav>
    <div>
        <a href="index.php">Site de recettes</a>
        <button type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
        </button>
        <div id="navbarSupportedContent">
            <ul>
                <li>
                    <a class="nav-link" href="index.php?action=contact">Contact</a>
                </li>
                <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
                <li>
                    <a href="index.php?action=login">Se connecter</a>
                </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                    <li>
                        <a href="index.php?action=recipes_create">Ajoutez une recette !</a>
                    </li>
                    <li>
                        <a href="index.php?action=logout">Déconnexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
