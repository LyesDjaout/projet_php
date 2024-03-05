<?php $title = "Page de création de recettes"; ?>
<?php ob_start(); ?>

    <section class="flex-container section-container">
        <h1 class="section-flex-item title">Ajouter une recette</h1>
        <form class="flex-container form-container" action="index.php?action=recipe_create" method="POST">
            <input type="hidden" name="csrf_token" value="<?= sanitizeInput($_SESSION['csrf_token']); ?>">
            <label class="form-flex-item label" for="title">Titre de la recette</label>
            <input class="form-flex-item input" type="text" id="title" name="title" aria-describedby="title-help" required>
            <?php if (isset($data['errors']['title_recipe'])) : ?>
                <p class="error-message"><?= $data['errors']['title_recipe']; ?></p>
            <?php endif; ?>
            <label class="form-flex-item label" for="recipe">Description de la recette</label>
            <textarea class="create-recipe-form-flex-item fourth" placeholder="Seulement du contenu vous appartenant ou libre de droits." id="recipe" name="recipe" required></textarea>
            <?php if (isset($data['errors']['recipe'])) : ?>
                <p class="error-message"><?= $data['errors']['recipe']; ?></p>
            <?php endif; ?>
            <?php
            // Afficher les messages d'erreur s'il y en a
            if (isset($error) && $error === 'recipe_exists') {
                echo "<p class='error-message'>Une de vos recettes avec ce titre existe déjà, veuillez choisir un autre titre ou modifier la recette existante.</p>";
            } 
            ?>
            <button class="form-flex-item button" type="submit">Envoyer</button>
        </form>
    </section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
