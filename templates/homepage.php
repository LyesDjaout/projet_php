<?php $title = "Page d'accueil"; ?>
<?php ob_start();?>
        
    <section class="flex-container homepage-section-container">
    <?php foreach (getValidRecipes($recipes) as $recipe) : ?>
        <article class="flex-container homepage-article-container">
            <h3 class="homepage-article-flex-item first"><?= sanitizeInput($recipe['title']); ?></h3>
            <p class="homepage-article-flex-item second"><?= sanitizeInput($recipe['recipe']); ?></p>
            <p class="homepage-article-flex-item third"><?= sanitizeInput(displayAuthor($recipe['author'], $users)); ?></p>
            <?php if (isset($_SESSION['LOGGED_USER']) && $recipe['author'] === $_SESSION['LOGGED_USER']['email']) : ?>
                <form class="homepage-article-flex-item fourth" action="index.php?action=update_recipe" method="post">
                    <input type="hidden" name="recipe_id" value="<?= sanitizeInput($recipe['recipe_id']); ?>">
                    <input type="hidden" name="csrf_token" value="<?= sanitizeInput($_SESSION['csrf_token']); ?>">
                    <button class="hommepage-article-button" type="submit" name="update_recipe">Editer la recette</button>
                </form>
                <form class="homepage-article-flex-item fifth" action="index.php?action=delete_recipe" method="post">
                    <input type="hidden" name="recipe_id" value="<?= sanitizeInput($recipe['recipe_id']); ?>">
                    <input type="hidden" name="csrf_token" value="<?= sanitizeInput($_SESSION['csrf_token']); ?>">
                    <button class="hommepage-article-button" type="submit" name="delete_recipe">Supprimer la recette</button>
                </form>
            <?php endif; ?>
            <form class="homepage-article-flex-item sixth" action="index.php?action=read_recipe" method="post">
                <?php if (isset($_SESSION['csrf_token'])) : ?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                <?php else : ?>
                    <?php generateCsrfToken(); ?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                <?php endif; ?>
                <input type="hidden" name="recipe_id" value="<?= sanitizeInput($recipe['recipe_id']); ?>">
                <button class="hommepage-article-button" type="submit" name="read_recipe">Laisser un commentaire !</button>
            </form>
        </article>
    <?php endforeach ?>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
