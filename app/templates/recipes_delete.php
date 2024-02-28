<?php $title = "Site de Recettes - Page de suppression de recettes"; ?>
<?php ob_start(); ?>
    <h1>Supprimer la recette ?</h1>
    <form action="index.php?action=recipes_post_delete" method="POST">
        <div>
            <label for="id"></label>
            <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($identifier); ?>">
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <button type="submit">La suppression est définitive</button>
    </form>
    <br />
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>