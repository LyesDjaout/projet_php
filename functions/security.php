<?php

function isConnect(){
    if (!isset($_SESSION['LOGGED_USER'])) {
        throw new Exception('Il faut être authentifié pour cette action.');
    }
}

function sanitizeInput($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

function validateAddCommentForm($comment, $review){
    $errors = [];

    if (!preg_match("/^(?:[\p{L}0-9\s.,@!?'\(\)\"\-\£\€\$]{1,30}\s)*[\p{L}0-9\s.,@!?'\(\)\"\-\£\€\$]{1,30}$/u", $comment) || trim(strip_tags($comment)) === '' || empty($comment)) {
        $errors['comment'] = "Le commentaire n'est pas valide ou ne doit pas être vide";
    }
    if (!is_numeric($review) || $review < 1 || $review > 5) {
        $errors['review'] = "La note n'est pas valide (elle doit être comprise entre 1 et 5)";
    }

    return $errors;
}

function validateContactForm($email, $message){
    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email n'est pas valide.";
    }
    if (!preg_match("/^(?:[\p{L}0-9\s.,@!?'\(\)\"\-\£\€\$]{1,30}\s)*[\p{L}0-9\s.,@!?'\(\)\"\-\£\€\$]{1,30}$/u", $message) || trim(strip_tags($message)) === '' || empty($message)) {
        $errors['message'] = "Le message n'est pas valide ou ne doit pas être vide";
    }
    return $errors;
}

function validateAddRecipeForm($recipeTitle, $recipe){
    $errors = [];

    if (!preg_match("/^[a-zA-Z\sàáâãäåèéêëìíîïòóôõöùúûüýÿç']+$/", $recipeTitle) || trim(strip_tags($recipeTitle)) === '' || empty($recipeTitle)) {
        $errors['recipeTitle'] = "Le titre n'est pas valide ou ne doit pas être vide";
    }
    if (!preg_match("/^(?:[\p{L}0-9\s.,@!?'\(\)\"\-\£\€\$]{1,30}\s)*[\p{L}0-9\s.,@!?'\(\)\"\-\£\€\$]{1,30}$/u", $recipe) || trim(strip_tags($recipe)) === '' || empty($recipe)) {
        $errors['recipe'] = "La recette n'est pas valide ou ne doit pas être vide";
    }

    return $errors;
}

function validateRegisterForm($fullname, $age, $email, $password){
    $errors = [];

    if($fullname === '' || empty($fullname) || !preg_match("/^[\p{L}'\-]+(?:\s[\p{L}'\-]+)*$/u", $fullname)){
        $errors['fullname'] = "Vous devez renseigner un nom complet valide!";
    }
    if($age <= 0 || !preg_match('/[0-9]/', $age)){
        $errors['age'] = "Veuillez renseiger un age valide !";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email n'est pas valide.";
    }
    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9\s]).{4,}$/', $password)){
        $errors['password'] = "Le mot de passe doit contenir au moins 4 caractères, une majuscule, une minuscule, un caractère spécial et un chiffre !";
    }

    return $errors;
}

function saltPassword($password){
    $salt = bin2hex(random_bytes(16));
    $saltedPassword = $password . $salt;

    return [
        'saltedPassword' => $saltedPassword,
        'salt' => $salt
    ];
}

function hashPassword($password){
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    return $hashedPassword;
}

function generateCsrfToken(){
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verifyCsrfToken() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        throw new Exception("Jeton CSRF invalide.");
    }
}