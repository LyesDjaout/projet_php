<?php $title = "Site de Recettes - Page de modification de recettes"; ?>
<?php ob_start(); ?>
    <h1>Mettre à jour <?php echo htmlspecialchars($recipe['title']); ?></h1>
    <form action="index.php?action=recipes_post_update" method="POST">
        <div>
            <label for="id"></label>
            <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($identifier); ?>">
        </div>
        <div>
            <label for="title">Titre de la recette</label>
            <input type="text" id="title" name="title" aria-describedby="title-help" value="<?php echo htmlspecialchars($recipe['title']); ?>">
        </div>
           <div>
            <label for="recipe">Description de la recette</label>
            <textarea placeholder="Seulement du contenu vous appartenant ou libre de droits." id="recipe" name="recipe"><?php echo htmlspecialchars($recipe['recipe']); ?></textarea>
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <button type="submit">Envoyer</button>
    </form>
    <br />
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
