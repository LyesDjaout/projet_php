<?php   
require_once('functions/load_env.php');

function getUsers(){
    try{
        $database = userdbConnect();
        $usersStatement = $database->prepare('SELECT * FROM users');
        $usersStatement->execute();
        $users = $usersStatement->fetchAll();
        return $users;
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function registerUser(string $full_name, int $age, string $email, string $password, string $salt){
    try{
        $database = userdbConnect();

        $stmt = $database->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            // L'email existe déjà, renvoyer une erreur
            return "email_exists";
        } else {
            $insertUser = $database->prepare('INSERT INTO users(full_name, email, password, age) VALUES (:full_name, :email, :password, :age)');
            $insertUser->execute([
            'full_name' => $full_name,
            'email' => $email,
            'password' => $password . ":" . $salt,
            'age' => $age,
            ]);
            return true;
        }
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function loginUser($email, $password) {
    try {
        $database = userDbConnect();
        // Récupérer les informations de l'utilisateur (Requête préparée pour prévenir l'injection SQL)
        $stmt = $database->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user){
            list($hashedPassword, $salt) = explode(':', $user['password'], 2);
            $saltedPassword = $password . $salt;

            if (password_verify($saltedPassword, $hashedPassword)) {
                // Connexion réussie, stocker l'ID de l'utilisateur en session
                $_SESSION['LOGGED_USER'] = [
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'user_id' => $user['user_id'],
                ];
                
                return true;
            } else {
                return "wrong_email_password";
            }
        } else {
            // Échec de connexion, afficher un message d'erreur
            return "wrong_email_password";
        }
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la connexion de l'utilisateur : " . $e->getMessage());
    }
}

function userDbConnect(){
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

function createRecipe(string $title, string $recipe, string $author){
    try{
        $database = recipeDbConnect();

        $recipesStatement = $database->prepare("SELECT recipe_id FROM recipes WHERE title = ? AND author = ?");
        $recipesStatement->execute([$title, $author]);
        $existingRecipe = $recipesStatement->fetch();

        if($existingRecipe){
            return 'recipe_exists';
        } else {
            $insertRecipe = $database->prepare('INSERT INTO recipes(title, recipe, author, is_enabled) VALUES (:title, :recipe, :author, :is_enabled)');
            $insertRecipe->execute([
            'title' => $title,
            'recipe' => $recipe,
            'is_enabled' => 1,
            'author' => $author,
            ]);
            return true;
        }
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function getRecipeWithComments(int $recipeId){
    try{
        $database = recipeDbConnect();
        $retrieveRecipeWithCommentsStatement = $database->prepare('SELECT r.*, c.comment_id, c.comment, c.user_id,  DATE_FORMAT(c.created_at, "%d/%m/%Y") as comment_date, u.full_name FROM recipes r 
        LEFT JOIN comments c on c.recipe_id = r.recipe_id
        LEFT JOIN users u ON u.user_id = c.user_id
        WHERE r.recipe_id = :id 
        ORDER BY comment_date DESC');
        $retrieveRecipeWithCommentsStatement->execute([
            'id' => (int)$recipeId,
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

function updateRecipe(string $title, string $recipe, int $id, string $author){
    try{
        $database= recipeDbConnect();

        $recipesStatement = $database->prepare("SELECT recipe_id FROM recipes WHERE title = ? AND author = ?");
        $recipesStatement->execute([$title, $author]);
        $existingRecipe = $recipesStatement->fetch();

        if($existingRecipe){
            return 'recipe_exists';
        } else {
            $insertRecipeStatement = $database->prepare('UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :id');
            $insertRecipeStatement->execute([
            'title' => $title,
            'recipe' => $recipe,
            'id' => $id,
            ]);
            return true;
        }
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