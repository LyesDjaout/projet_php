<?php

function deleteRecipesPost(array $input){
    session_start();
    require_once('app/controllers/redirect.php');
    require_once(__DIR__ . '/isConnect.php');

    $identifier = $input['id'];

    if (!isset($identifier) || !is_numeric($identifier)) {
        throw new Exception('Il faut un identifiant valide pour supprimer une recette.');
    }

    $success = deleteRecipe($identifier);
    if (!$success) {
        throw new Exception('Impossible de supprimer la recette !');
    } else {
        redirectToUrl('index.php');
    }
}