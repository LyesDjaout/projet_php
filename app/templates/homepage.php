<?php $title = "Page d'accueil"; ?>
<?php ob_start();?>
        
    <section class="flex-container homepage-section-container">
    <?php foreach (getValidRecipes($recipes) as $recipe) : ?>
        <article class="flex-container homepage-article-container">
            <h3 class="homepage-article-flex-item first"><?= htmlspecialchars($recipe['title']); ?></h3>
            <p class="homepage-article-flex-item second"><?= htmlspecialchars($recipe['recipe']); ?></p>
            <p class="homepage-article-flex-item third"><?= htmlspecialchars(displayAuthor($recipe['author'], $users)); ?></p>
            <?php if (isset($_SESSION['LOGGED_USER']) && $recipe['author'] === $_SESSION['LOGGED_USER']['email']) : ?>
                <form class="homepage-article-flex-item fourth" action="index.php?action=recipes_update" method="post">
                    <input type="hidden" name="recipe_id" value="<?= htmlspecialchars($recipe['recipe_id']); ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <button class="hommepage-article-button" type="submit" name="update_recipe">Editer l'article</button>
                </form>
                <form class="homepage-article-flex-item fifth" action="index.php?action=recipes_delete" method="post">
                    <input type="hidden" name="recipe_id" value="<?= htmlspecialchars($recipe['recipe_id']); ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <button class="hommepage-article-button" type="submit" name="delete_recipe">Supprimer l'article</button>
                </form>
            <?php endif; ?>
            <form class="homepage-article-flex-item sixth" action="index.php?action=recipes_read" method="post">
                <input type="hidden" name="recipe_id" value="<?= htmlspecialchars($recipe['recipe_id']); ?>">
                <button class="hommepage-article-button" type="submit" name="read_recipe">Laisser un commentaire !</button>
            </form>
        </article>
    <?php endforeach ?>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
