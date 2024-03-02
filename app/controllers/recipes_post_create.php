<?php

function addRecipes(array $input){
    session_start();
    require_once('app/controllers/is_connect.php');

    $postData = $input;

    // Vérification du formulaire soumis
    if (
        empty($postData['title'])
        || empty($postData['recipe'])
        || trim(strip_tags($postData['title'])) === ''
        || trim(strip_tags($postData['recipe'])) === ''
        || !preg_match("/^[\p{L}'\-]+(?:\s[\p{L}'\-]+)*$/u", $postData['title'])
        || !preg_match("/^[\p{L}'\-\.,]+(?:\s[\p{L}'\-\.\",]+)*$/u", $postData['recipe'])
    ) {
        throw new Exception('Il faut un titre et une recette valides pour soumettre le formulaire.');
    }

    $title_recipe = trim(strip_tags($postData['title']));
    $recipe = trim(strip_tags($postData['recipe']));
    $autor = $_SESSION['LOGGED_USER']['email'];
    // Faire l'insertion en base
    $success = createRecipe($title_recipe, $recipe, $autor);
    if (!$success) {
        throw new Exception('Impossible d\'ajouter la recette !');
    } else {
        require('app/templates/recipes_post_create.php');
    }
}