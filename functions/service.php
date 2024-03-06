<?php

function handleRegisterAction(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        verifyCsrfToken();

        if (
            !isset($_POST['full_name']) ||
            !isset($_POST['age']) ||
            !isset($_POST['email']) ||
            !isset($_POST['password'])
        )
          {
            throw new Exception('Le nom complet ou l\'age ou l\'email ou le mot de passe n\'existent pas');
          }

          $fullName = sanitizeInput($_POST['full_name']);
          $age = intval($_POST['age']);
          $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
          $password = $_POST['password'];

          $errors = validateRegisterForm($fullName, $age, $email, $password);

          if(!empty($errors)){
            $data['errors'] = $errors;
            include_once 'templates/register.php';
        } else {
            $saltedPasswordAndSalt = saltPassword($password);
            $salt = $saltedPasswordAndSalt['salt'];
            $saltedPassword = $saltedPasswordAndSalt['saltedPassword'];
            $hashedPassword = hashPassword($saltedPassword);

            $error = registerUser($fullName, $age, $email, $hashedPassword, $salt); 

            if ($error === true) {
                include_once 'templates/login.php';
                exit();
            } else {
                include_once 'templates/register.php';
            }
        }

    } else {
        include_once 'templates/register.php';
    }
};

function handleLoginAction(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        verifyCsrfToken();

        if (
            !isset($_POST['email']) ||
            !isset($_POST['password'])) 
          {
            throw new Exception('l\'email ou le mot de passe n\'existent pas');
          }

    if($_POST['email'] == '' || $_POST['password'] == ''){
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Vueillez renseigner votre email et mot de passe !';
        include_once 'templates/login.php';
        return;
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $error = loginUser($email, $password);

    if ($error === true) {
        redirectToUrl('index.php');
        exit();
    } else {
        $data['error'] = $error;
        include_once 'templates/login.php';
    }

    } else {
        include_once 'templates/login.php';
    }
}

function handleSubmitContactAction(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        verifyCsrfToken();

        if (
            !isset($_POST['email']) ||
            !isset($_POST['message']) 
            ) {
            throw new Exception('l\'email ou le message n\'existent pas');
        }

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $message = sanitizeInput($_POST['message']);

        $errors = validateContactForm($email, $message);

        $isFileLoaded = false;

        if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error']=== 0) {

            $file = $_FILES['screenshot'];

            $result = isValidFile($file, $isFileLoaded, $errors);

            $errors = $result['errors'];
            $isFileLoaded = $result['isFileLoaded'];
            $path = $result['path'];
        }

        if(!empty($errors)){
            $data['errors'] = $errors;
            include_once 'templates/contact.php';

        } else {
            if($isFileLoaded === true){
                // On peut valider le fichier et le stocker définitivement
                move_uploaded_file($file['tmp_name'], $path . basename($file['name']));
            }
            
            include_once 'templates/submit_contact.php';
        }

    } else {
        include_once 'templates/contact.php';
    }
}

function handleAddRecipeAction(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        verifyCsrfToken();

        isConnect();

        if (
            !isset($_POST['title']) ||
            !isset($_POST['recipe'])
        ) {
            throw new Exception('Le titre ou la recette n\'existent pas !');
        }

        $recipeTitle = sanitizeInput($_POST['title']);
        $recipe = sanitizeInput($_POST['recipe']);
        $author = $_SESSION['LOGGED_USER']['email'];

        $errors = validateAddRecipeForm($recipeTitle, $recipe);

        if(!empty($errors)){
            $data['errors'] = $errors;
            include_once 'templates/recipe_create.php';
        } else {
            
            $error = createRecipe($recipeTitle, $recipe, $author);

            if ($error === true) {
                include_once 'templates/display_create_recipe.php';
                exit();
            } else {
                include_once 'templates/create_recipe.php';
            }
        }

    } else {
        include_once 'templates/create_recipe.php';
    }
}

function handleReadRecipeAction(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_SESSION['recipe'])) {

        verifyCsrfToken();

        $recipeId = isset($_POST['recipe_id']) ? intval($_POST['recipe_id']) : (isset($_SESSION['recipe']) ? intval($_SESSION['recipe']) : null);

        if(isset($_SESSION['recipe']) && isset($_SESSION['add_comment_errors'])){
            $data['errors'] = $_SESSION['add_comment_errors'];
        }

        if (!isset($recipeId) || !is_numeric($recipeId)) {
            throw new Exception('L\'identifiant de la recette n\'existe pas ou n\'est pas valide');
        }
        
        $recipeWithComments = getRecipeWithComments($recipeId);

        if ($recipeWithComments === []) {
            throw new Exception('La recette n\'existe pas');
        }

        $averageRating = getAverageRating($recipeId);

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

        unset($_SESSION['recipe']);
        unset($_SESSION['add_comment_errors']);

        include_once 'templates/read_recipe.php';

    } else {
        redirectToUrl('index.php');
    }
}

function handleUpdateRecipeAction(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        verifyCsrfToken();

        isConnect();

        if (!isset($_POST['recipe_id']) || !is_numeric($_POST['recipe_id'])) {
            throw new Exception('Il faut un identifiant de recette pour la modifier.');
        }

        $recipeId = intval($_POST['recipe_id']);

        $recipe = getRecipe($recipeId);

        include_once 'templates/update_recipe.php';

    } else {
        redirectToUrl('index.php');
    }
}

function handleDisplayUpdateRecipeAction(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        verifyCsrfToken();

        isConnect();

        if (
            !isset($_POST['recipe_id']) ||
            !isset($_POST['title']) ||
            !isset($_POST['recipe'])
            ) {
            throw new Exception('Le titre ou la recette ou l\'identifiant de la recette n\'existent pas');
        }

        if (!is_numeric($_POST['recipe_id'])) {
            throw new Exception("L'identifiant de la recette n'est pas valide.");
        }

        $recipeId = intval($_POST['recipe_id']);
        $recipeTitle = sanitizeInput($_POST['title']);
        $recipe = sanitizeInput($_POST['recipe']);
        $author = $_SESSION['LOGGED_USER']['email'];

        $errors = validateAddRecipeForm($recipeTitle, $recipe);

        if(!empty($errors)){
            $data['errors'] = $errors;
            $recipe = getRecipe($recipeId);
            include_once 'templates/update_recipe.php';
        } else {
            
            $error = updateRecipe($recipeTitle, $recipe, $recipeId, $author);

            if ($error === true) {
                include_once 'templates/display_update_recipe.php';
                exit();
            } else {
                $recipe = getRecipe($recipeId);
                include_once 'templates/recipe_update.php';
            }
        }

    } else {
        redirectToUrl('index.php');
    }
}

function handleDeleteRecipesAction(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        verifyCsrfToken();

        isConnect();

        if (!isset($_POST['recipe_id']) || !is_numeric($_POST['recipe_id'])) {
            throw new Exception('Il faut un identifiant pour supprimer la recette.');
        }

        $recipeId = intval($_POST['recipe_id']); 

        $recipe = getRecipe($recipeId);

        include_once 'templates/delete_recipe.php';

    } else {
        redirectToUrl('index.php');
    }
}

function handleDisplayDeleteRecipeAction(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        verifyCsrfToken();

        isConnect();

        if (!isset($_POST['recipe_id']) || !is_numeric($_POST['recipe_id'])) {
            throw new Exception('Il faut un identifiant pour supprimer la recette.');
        }

        $recipeId = intval($_POST['recipe_id']);

        $error = deleteRecipe($recipeId);

        if ($error) {
            redirectToUrl('index.php');
            exit();
        } else {
            throw new Exception('Une erreur est survenue, veuillez réessayer');
        }

    } else {
        redirectToUrl('index.php');
    }
}

function handleAddCommentAction(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        verifyCsrfToken();

        isConnect();

        if (
            !isset($_POST['comment']) ||
            !isset($_POST['recipe_id']) ||
            !isset($_POST['review'])
        ) {
            throw new Exception('Le commentaire ou la note ou la recette n\'existent pas !');
        }

        if (!is_numeric($_POST['recipe_id'])) {
            throw new Exception("L'identifiant de la recette n'est pas valide.");
        }

        $recipeId = intval($_POST['recipe_id']);
        $userId = $_SESSION['LOGGED_USER']['user_id'];
        $comment = sanitizeInput($_POST['comment']);
        $review = intval($_POST['review']);

        $errors = validateAddCommentForm($comment, $review);

        if(!empty($errors)){
            $data['errors'] = $errors;

            $_SESSION['recipe'] = $recipeId;
            $_SESSION['add_comment_errors'] = $errors;

            handleReadRecipeAction();
        } else {
            createComment($comment, $recipeId, $review, $userId);
            
            include_once 'templates/display_create_comment.php';
        }
    } else {
        redirectToUrl('index.php');
    }
}

function handleLogoutAction(){
    session_start();
    session_unset();
    session_destroy();
    redirectToUrl('index.php');
}

function displayAuthor(string $authorEmail, array $users): string
{
    foreach ($users as $user) {
        if ($authorEmail === $user['email']) {
            return $user['full_name'] . ' (' . $user['age'] . ' ans)';
        }
    }

    return 'Auteur inconnu';
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

function isValidRecipe(array $recipe): bool
{
    if (array_key_exists('is_enabled', $recipe)) {
        $isEnabled = $recipe['is_enabled'];
    } else {
        $isEnabled = false;
    }

    return $isEnabled;
}

function redirectToUrl(string $url): never{
    header("Location: {$url}");
    exit();
}

function isValidFile($file, $isFileLoaded, $errors){

    // Testons, si le fichier est trop volumineux
    if ($file['size'] > 1000000) {
        $errors['file_volume'] = "Erreur ou image trop volumineuse.";
    }

    // Testons, si l'extension n'est pas autorisée
    $fileInfo = pathinfo($file['name']);
    $extension = $fileInfo['extension'];
    $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
    if (!in_array($extension, $allowedExtensions)) {
        $errors['file_extension'] = "L'extension {$extension} n'est pas autorisée.";
    }

    // Testons, si le dossier uploads est manquant
    $path = __DIR__ . '/../templates/assets/img/';
    if (!is_dir($path)) {
        $errors['file_path'] = "Le dossier uploads est manquant.";
    }

    if(empty($errors)){
        $isFileLoaded = true;
    }

    return [
        'errors' => $errors,
        'isFileLoaded' => $isFileLoaded,
        'path' => $path,
    ];
}