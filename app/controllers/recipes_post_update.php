<?php

function updateRecipesPost(array $input){
    session_start();

    require_once(__DIR__ . '/isConnect.php');

    $postData = $input;

    if (
        !isset($postData['id'])
        || !is_numeric($postData['id'])
        || empty($postData['title'])
        || empty($postData['recipe'])
        || trim(strip_tags($postData['title'])) === ''
        || trim(strip_tags($postData['recipe'])) === ''
    ) {
        throw new Exception('Il manque des informations pour permettre l\'édition du formulaire.');
    }

    $id = (int)$postData['id'];
    $title = trim(strip_tags($postData['title']));
    $recipe = trim(strip_tags($postData['recipe']));

    $success = updateRecipe($title, $recipe, $id);
    if (!$success) {
        throw new Exception('Impossible de modifier la recette !');
    } else {
        require('app/templates/recipes_post_update.php');
    }
}