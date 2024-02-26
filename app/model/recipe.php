<?php
require_once('app/load_env.php');

function getRecipes(){
    try{
        $database = recipedbConnect();
        $recipesStatement = $database->prepare('SELECT * FROM recipes');
        $recipesStatement->execute();
        $recipes = $recipesStatement->fetchAll();
        return $recipes;
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function createRecipe(string $title, string $recipe, string $autor){
    try{
        $database = recipeDbConnect();
        $insertRecipe = $database->prepare('INSERT INTO recipes(title, recipe, author, is_enabled) VALUES (:title, :recipe, :author, :is_enabled)');
        $insertRecipe->execute([
        'title' => $title,
        'recipe' => $recipe,
        'is_enabled' => 1,
        'author' => $autor,
        ]);
        return $insertRecipe;
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function getRecipeWithComments(int $identifier){
    try{
        $database = recipeDbConnect();
        $retrieveRecipeWithCommentsStatement = $database->prepare('SELECT r.*, c.comment_id, c.comment, c.user_id,  DATE_FORMAT(c.created_at, "%d/%m/%Y") as comment_date, u.full_name FROM recipes r 
        LEFT JOIN comments c on c.recipe_id = r.recipe_id
        LEFT JOIN users u ON u.user_id = c.user_id
        WHERE r.recipe_id = :id 
        ORDER BY comment_date DESC');
        $retrieveRecipeWithCommentsStatement->execute([
            'id' => (int)$identifier,
        ]);
        return $retrieveRecipeWithCommentsStatement->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function getAverageRating(int $identifier){
    try{
        $database = recipeDbConnect();
        $retrieveAverageRatingStatement = $database->prepare('SELECT ROUND(AVG(c.review),1) as rating FROM recipes r LEFT JOIN comments c on r.recipe_id = c.recipe_id WHERE r.recipe_id = :id');
        $retrieveAverageRatingStatement->execute([
            'id' => (int)$identifier,
        ]);
        return $retrieveAverageRatingStatement->fetch();
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function getRecipe(int $identifier){
    try{
        $database = recipeDbConnect();
        $retrieveRecipeStatement = $database->prepare('SELECT * FROM recipes WHERE recipe_id = :id');
        $retrieveRecipeStatement->execute([
            'id' => (int)$identifier,
        ]);
        return $retrieveRecipeStatement->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function updateRecipe(string $title, string $recipe, int $id){
    try{
        $database= recipeDbConnect();
        $insertRecipeStatement = $database->prepare('UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :id');
        $insertRecipeStatement->execute([
        'title' => $title,
        'recipe' => $recipe,
        'id' => $id,
        ]);
        return $insertRecipeStatement;
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function deleteRecipe(int $identifier){
    try{
        $mysqlClient = recipeDbConnect();
        $deleteRecipeStatement = $mysqlClient->prepare('DELETE FROM recipes WHERE recipe_id = :id');
        $deleteRecipeStatement->execute([
        'id' => (int)$identifier,
        ]);
        return $deleteRecipeStatement;
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function recipeDbConnect(){
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