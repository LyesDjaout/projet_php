<?php $title = "Page de création de recettes"; ?>
<?php ob_start(); ?>

    <section class="flex-container section-container">
        <h1 class="section-flex-item title">Ajouter une recette</h1>
        <form class="flex-container form-container" action="index.php?action=recipes_post_create" method="POST">
            <label class="form-flex-item label" for="title">Titre de la recette</label>
            <input class="form-flex-item input" type="text" id="title" name="title" aria-describedby="title-help" required>
            <label class="form-flex-item label" for="recipe">Description de la recette</label>
            <textarea class="create-recipe-form-flex-item fourth" placeholder="Seulement du contenu vous appartenant ou libre de droits." id="recipe" name="recipe" required></textarea>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
            <button class="form-flex-item button" type="submit">Envoyer</button>
        </form>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
