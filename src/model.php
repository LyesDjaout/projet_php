<?php

function dbConnect(){
    try {
        $mysqlClient = new PDO(
            sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8', MYSQL_HOST, MYSQL_NAME, MYSQL_PORT),
            MYSQL_USER,
            MYSQL_PASSWORD
        );
        $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $mysqlClient;
    } catch (Exception $exception) {
        die('Erreur : ' . $exception->getMessage());
    }
}

function getUsers(){
    $mysqlClient = dbConnect();
    $usersStatement = $mysqlClient->prepare('SELECT * FROM users');
    $usersStatement->execute();
    $users = $usersStatement->fetchAll();
    return $users;
}

function getRecipes(){
    $mysqlClient = dbConnect();
    $recipesStatement = $mysqlClient->prepare('SELECT * FROM recipes');
    $recipesStatement->execute();
    $recipes = $recipesStatement->fetchAll();
    return $recipes;
}

function displayAuthor(string $authorEmail, array $users): string
{
    foreach ($users as $user) {
        if ($authorEmail === $user['email']) {
            return $user['full_name'] . '(' . $user['age'] . ' ans)';
        }
    }

    return 'Auteur inconnu';
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

function redirectToUrl(string $url): never
{
    header("Location: {$url}");
    exit();
}
