<?php

function addComment(array $input){
    session_start();
    require_once('app/model/comment.php');

    require_once(__DIR__ . '/is_connect.php');

    $postData = $input;

    if (
        !isset($postData['comment']) ||
        !isset($postData['recipe_id']) ||
        !is_numeric($postData['recipe_id']) ||
        !is_numeric($postData['review'])
    ) {
        throw new Exception('Le commentaire ou la note sont invalides.');
    }

    $userId = $_SESSION['LOGGED_USER']['user_id'];
    $comment = trim(strip_tags($postData['comment']));
    $recipeId = (int)$postData['recipe_id'];
    $review = (int)$postData['review'];

    if ($review < 1 || $review > 5) {
        throw new Exception('La note doit être comprise entre 1 et 5');
    }

    if ($comment === '') {
        throw new Exception('Le commentaire ne peut pas être vide.');
    }

    $success = createComment($comment, $recipeId, $review, $userId);
    if (!$success) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        require('app/templates/comments_post_create.php');
    }
}


