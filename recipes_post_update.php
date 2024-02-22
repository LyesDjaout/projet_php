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
    !isset($postData['id'])
    || !is_numeric($postData['id'])
    || empty($postData['title'])
    || empty($postData['recipe'])
    || trim(strip_tags($postData['title'])) === ''
    || trim(strip_tags($postData['recipe'])) === ''
) {
    echo 'Il manque des informations pour permettre l\'édition du formulaire.';
    return;
}

$id = (int)$postData['id'];
$title = trim(strip_tags($postData['title']));
$recipe = trim(strip_tags($postData['recipe']));

$mysqlClient= dbConnect();
$insertRecipeStatement = $mysqlClient->prepare('UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :id');
$insertRecipeStatement->execute([
    'title' => $title,
    'recipe' => $recipe,
    'id' => $id,
]);

require('templates/recipes_post_update.php');