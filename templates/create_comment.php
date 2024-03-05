<form class="flex-container read-recipe-form-container" action="index.php?action=display_create_comment" method="POST">
    <input type="hidden" name="recipe_id" value="<?= sanitizeInput($recipe['recipe_id']); ?>" />
    <input type="hidden" name="csrf_token" value="<?= sanitizeInput($_SESSION['csrf_token']); ?>">
    <label class="form-flex-item label" for="review">Evaluez la recette (de 1 à 5)</label>
    <input class="form-flex-item input" type="number" id="review" name="review" min="1" max="5" step="1" required/>
    <?php if (isset($data['errors']['review'])) : ?>
        <p class="error-message"><?= $data['errors']['review']; ?></p>
    <?php endif; ?>
    <label class="form-flex-item label" for="comment">Postez un commentaire</label>
    <textarea class="form-flex-item area" id="comment" name="comment" required></textarea>
    <?php if (isset($data['errors']['comment'])) : ?>
        <p class="error-message"><?= $data['errors']['comment']; ?></p>
    <?php endif; ?>
    <button class="form-flex-item button" type="submit">Envoyer</button>
</form>