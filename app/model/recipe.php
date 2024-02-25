<?php

function getRecipes(){
    $database = recipedbConnect();
    $recipesStatement = $database->prepare('SELECT * FROM recipes');
    $recipesStatement->execute();
    $recipes = $recipesStatement->fetchAll();
    return $recipes;
}

function isValidRecipe(array $recipe): bool
{
    if (array_key_exists('is_enabled', $recipe)) {
        $isEnabled = $recipe['is_enabled'];
    } else {
        $isEnabled = false;
    }

    return $isEnabled;
}

function getValidRecipes(array $recipes): array
{
    $valid_recipes = [];

    foreach ($recipes as $recipe) {
        if (isValidRecipe($recipe)) {
            $valid_recipes[] = $recipe;
        }
    }

    return $valid_recipes;
}

function createRecipe(string $title, string $recipe, string $autor){
    $database = recipeDbConnect();
    $insertRecipe = $database->prepare('INSERT INTO recipes(title, recipe, author, is_enabled) VALUES (:title, :recipe, :author, :is_enabled)');
    $insertRecipe->execute([
    'title' => $title,
    'recipe' => $recipe,
    'is_enabled' => 1,
    'author' => $autor,
]);
    return $insertRecipe;
}

function getRecipeWithComments(int $identifier){
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
}

function getAverageRating(int $identifier){
    $database = recipeDbConnect();
    $retrieveAverageRatingStatement = $database->prepare('SELECT ROUND(AVG(c.review),1) as rating FROM recipes r LEFT JOIN comments c on r.recipe_id = c.recipe_id WHERE r.recipe_id = :id');
    $retrieveAverageRatingStatement->execute([
        'id' => (int)$identifier,
    ]);
    return $retrieveAverageRatingStatement->fetch();
}

function getRecipe(int $identifier){
    $database = recipeDbConnect();
    $retrieveRecipeStatement = $database->prepare('SELECT * FROM recipes WHERE recipe_id = :id');
    $retrieveRecipeStatement->execute([
        'id' => (int)$identifier,
    ]);
    return $retrieveRecipeStatement->fetch(PDO::FETCH_ASSOC);
}

function updateRecipe(string $title, string $recipe, int $id){
    $database= recipeDbConnect();
    $insertRecipeStatement = $database->prepare('UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :id');
    $insertRecipeStatement->execute([
    'title' => $title,
    'recipe' => $recipe,
    'id' => $id,
]);
    return $insertRecipeStatement;
}

function deleteRecipe(int $identifier){
    $mysqlClient = recipeDbConnect();
    $deleteRecipeStatement = $mysqlClient->prepare('DELETE FROM recipes WHERE recipe_id = :id');
    $deleteRecipeStatement->execute([
    'id' => (int)$identifier,
]);
    return $deleteRecipeStatement;
}

function recipeDbConnect(){
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