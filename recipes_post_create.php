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

// Vérification du formulaire soumis
if (
    empty($postData['title'])
    || empty($postData['recipe'])
    || trim(strip_tags($postData['title'])) === ''
    || trim(strip_tags($postData['recipe'])) === ''
) {
    echo 'Il faut un titre et une recette pour soumettre le formulaire.';
    return;
}

$title = trim(strip_tags($postData['title']));
$recipe = trim(strip_tags($postData['recipe']));

// Faire l'insertion en base
$mysqlClient = dbConnect();
$insertRecipe = $mysqlClient->prepare('INSERT INTO recipes(title, recipe, author, is_enabled) VALUES (:title, :recipe, :author, :is_enabled)');
$insertRecipe->execute([
    'title' => $title,
    'recipe' => $recipe,
    'is_enabled' => 1,
    'author' => $_SESSION['LOGGED_USER']['email'],
]);

require('templates/recipes_post_create.php');