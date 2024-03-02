<?php $title = "Page de suppression de recettes"; ?>
<?php ob_start(); ?>

    <section class="flex-container section-container">
        <h1 class="section-flex-item title">Supprimer la recette <?php echo htmlspecialchars($recipe['title']); ?> ?</h1>
        <form class="flex-container form-container" action="index.php?action=recipes_post_delete" method="POST">
            <label for="id"></label>
            <input type="hidden" id="id" name="id" value="<?= htmlspecialchars($identifier); ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
            <button class="delete-recipe-form-flex-item" type="submit">La suppression est définitive</button>
        </form>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>