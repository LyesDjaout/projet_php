<?php
session_start();

require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/src/model.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$postData = $_POST;

if (
    !isset($postData['comment']) ||
    !isset($postData['recipe_id']) ||
    !is_numeric($postData['recipe_id']) ||
    !is_numeric($postData['review'])
) {
    echo('Le commentaire ou la note sont invalides.');
    return;
}

$comment = trim(strip_tags($postData['comment']));
$recipeId = (int)$postData['recipe_id'];
$review = (int)$postData['review'];

if ($review < 1 || $review > 5) {
    echo 'La note doit être comprise entre 1 et 5';
    return;
}

if ($comment === '') {
    echo 'Le commentaire ne peut pas être vide.';
    return;
}

$mysqlClient = dbConnect();

$insertRecipe = $mysqlClient->prepare('INSERT INTO comments(comment, recipe_id, user_id, review) VALUES (:comment, :recipe_id, :user_id, :review)');
$insertRecipe->execute([
    'comment' => $comment,
    'recipe_id' => $recipeId,
    'user_id' => $_SESSION['LOGGED_USER']['user_id'],
    'review' => $review,
]);

require('templates/comments_post_create.php');