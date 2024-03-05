<?php
require_once('functions/load_env.php');

function createComment($comment, $recipeId, $review, $userId){
    try{
        $database = commentsdbConnect();

        isConnect();
        
        $insertComment = $database->prepare('INSERT INTO comments(comment, recipe_id, user_id, review) VALUES (:comment, :recipe_id, :user_id, :review)');
        $insertComment->execute([
        'comment' => $comment,
        'recipe_id' => $recipeId,
        'user_id' => $userId,
        'review' => $review,
        ]);
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function commentsDbConnect(){
    try {
        $mysqlHost = getenv('MYSQL_HOST');
        $mysqlPort = getenv('MYSQL_PORT');
        $mysqlName = getenv('MYSQL_NAME');
        $mysqlUser = getenv('MYSQL_USER');
        $mysqlPassword = getenv('MYSQL_PASSWORD');
        $database = new PDO(
            sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8', $mysqlHost, $mysqlName, $mysqlPort),
            $mysqlUser,
            $mysqlPassword
        );
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $database;
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}