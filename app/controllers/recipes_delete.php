<?php

function deleteRecipes(int $identifier){
    session_start();

    require_once(__DIR__ . '/is_connect.php');

    if (!isset($identifier) || !is_numeric($identifier)) {
        throw new Exception('Il faut un identifiant pour supprimer la recette.');
    }

    require('app/templates/recipes_delete.php');
}