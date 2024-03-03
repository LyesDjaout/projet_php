<?php

function readRecipes(int $identifier){
    session_start();

if (!isset($identifier) || !is_numeric($identifier)) {
    throw new Exception('La recette n\'existe pas');
}

// On récupère la recette

$recipeWithComments = getRecipeWithComments($identifier);

if ($recipeWithComments === []) {
    throw new Exception('La recette n\'existe pas');
}

$averageRating = getAverageRating($identifier);

$recipe = [
    'recipe_id' => $recipeWithComments[0]['recipe_id'],
    'title' => $recipeWithComments[0]['title'],
    'recipe' => $recipeWithComments[0]['recipe'],
    'author' => $recipeWithComments[0]['author'],
    'comments' => [],
    'rating' => $averageRating['rating'],
];

foreach ($recipeWithComments as $comment) {
    if (!is_null($comment['comment_id'])) {
        $recipe['comments'][] = [
            'comment_id' => $comment['comment_id'],
            'comment' => $comment['comment'],
            'user_id' => (int) $comment['user_id'],
            'full_name' => $comment['full_name'],
            'created_at' => $comment['comment_date'],
        ];
    }
}

require('app/templates/recipes_read.php');
}