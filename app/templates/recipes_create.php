<?php $title = "Site de Recettes - Page de création de recettes"; ?>
<?php ob_start(); ?>
    <h1>Ajouter une recette</h1>
    <form action="index.php?action=recipes_post_create" method="POST">
        <div>
            <label for="title">Titre de la recette</label>
            <input type="text" id="title" name="title" aria-describedby="title-help">
            <div id="title-help">Choisissez un titre percutant !</div>
        </div>
        <div>
            <label for="recipe">Description de la recette</label>
            <textarea placeholder="Seulement du contenu vous appartenant ou libre de droits." id="recipe" name="recipe"></textarea>
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <button type="submit">Envoyer</button>
    </form>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
