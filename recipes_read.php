<?php
session_start();

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/src/model.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$getData = $_GET;

if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('La recette n\'existe pas');
    return;
}

// On récupère la recette
$mysqlClient = dbConnect();
$retrieveRecipeWithCommentsStatement = $mysqlClient->prepare('SELECT r.*, c.comment_id, c.comment, c.user_id,  DATE_FORMAT(c.created_at, "%d/%m/%Y") as comment_date, u.full_name FROM recipes r 
LEFT JOIN comments c on c.recipe_id = r.recipe_id
LEFT JOIN users u ON u.user_id = c.user_id
WHERE r.recipe_id = :id 
ORDER BY comment_date DESC');
$retrieveRecipeWithCommentsStatement->execute([
    'id' => (int)$getData['id'],
]);
$recipeWithComments = $retrieveRecipeWithCommentsStatement->fetchAll(PDO::FETCH_ASSOC);

if ($recipeWithComments === []) {
    echo('La recette n\'existe pas');
    return;
}
$retrieveAverageRatingStatement = $mysqlClient->prepare('SELECT ROUND(AVG(c.review),1) as rating FROM recipes r LEFT JOIN comments c on r.recipe_id = c.recipe_id WHERE r.recipe_id = :id');
$retrieveAverageRatingStatement->execute([
    'id' => (int)$getData['id'],
]);
$averageRating = $retrieveAverageRatingStatement->fetch();
;

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

require('templates/recipes_read.php');