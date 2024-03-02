<form class="flex-container read-recipe-form-container" action="index.php?action=comments_post_create" method="POST">
    <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe['recipe_id']); ?>" />
    <label class="form-flex-item label" for="review">Evaluez la recette (de 1 à 5)</label>
    <input class="form-flex-item input" type="number" id="review" name="review" min="1" max="5" step="1" required/>
    <label class="form-flex-item label" for="comment">Postez un commentaire</label>
    <textarea class="form-flex-item area" id="comment" name="comment" required></textarea>
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
    <button class="form-flex-item button" type="submit">Envoyer</button>
</form>