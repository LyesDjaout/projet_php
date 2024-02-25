<?php

function updateRecipes(int $identifier){
    session_start();

    require_once(__DIR__ . '/isConnect.php');

    if (!isset($identifier) || !is_numeric($identifier)) {
        throw new Exception('Il faut un identifiant de recette pour la modifier.');
    }

    $recipe = getRecipe($identifier);
    
    // si la recette n'est pas trouvée, renvoyer un message d'erreur
    require('app/templates/recipes_update.php');
} 