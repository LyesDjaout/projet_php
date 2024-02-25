<?php
require_once('config/mysql.php');

function createComment($comment, $recipeId, $review, $userId){
    $database = commentsdbConnect();
    
    $insertComment = $database->prepare('INSERT INTO comments(comment, recipe_id, user_id, review) VALUES (:comment, :recipe_id, :user_id, :review)');
    $insertComment->execute([
    'comment' => $comment,
    'recipe_id' => $recipeId,
    'user_id' => $userId,
    'review' => $review,
]);
return $insertComment;
}

function commentsDbConnect(){
    // try {
        $database = new PDO(
            sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8', MYSQL_HOST, MYSQL_NAME, MYSQL_PORT),
            MYSQL_USER,
            MYSQL_PASSWORD
        );
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $database;
    // } catch (Exception $exception) {
    //     die('Erreur : ' . $exception->getMessage());
    // }
}