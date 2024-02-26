<?php $title = "Site de Recettes - Page d'accueil"; ?>
<?php ob_start();
        if (isset($_SESSION['LOGGED_USER'])) : ?> 
        <div role="alert">
            Bonjour <?php echo htmlspecialchars($_SESSION['LOGGED_USER']['full_name']); ?> et bienvenue sur le site !
        </div>
        <?php endif; ?>
        
        <?php foreach (getValidRecipes($recipes) as $recipe) : ?>
            <article>
                <form action="index.php?action=recipes_read" method="post">
                    <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe['recipe_id']); ?>">
                    <h3><button type="submit" name="read_recipe"><?php echo htmlspecialchars($recipe['title']); ?></button></h3>
                </form>
                <div><?php echo htmlspecialchars($recipe['recipe']); ?></div>
                <i><?php echo htmlspecialchars(displayAuthor($recipe['author'], $users)); ?></i>
                <?php if (isset($_SESSION['LOGGED_USER']) && $recipe['author'] === $_SESSION['LOGGED_USER']['email']) : ?>
                    <ul>
                        <li>
                            <form action="index.php?action=recipes_update" method="post">
                                <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe['recipe_id']); ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                <h3><button type="submit" name="update_recipe">Editer l'article</button></h3>
                            </form>
                        </li>
                        <li>
                            <form action="index.php?action=recipes_delete" method="post">
                                <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe['recipe_id']); ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                <h3><button type="submit" name="delete_recipe">Supprimer l'article</button></h3>
                            </form>
                        </li>
                    </ul>
                <?php endif; ?>
            </article>
        <?php endforeach ?>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
