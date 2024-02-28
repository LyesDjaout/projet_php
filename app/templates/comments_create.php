<form action="index.php?action=comments_post_create" method="POST">
    <div>
        <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe['recipe_id']); ?>" />
    </div>
    <div>
        <label for="review">Evaluez la recette (de 1 à 5)</label>
        <input type="number" id="review" name="review" min="1" max="5" step="1" />
    </div>
    <div>
        <label for="comment">Postez un commentaire</label>
        <textarea id="comment" name="comment" required></textarea>
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
    <button type="submit">Envoyer</button>
</form>