<?php

function submitLogin(array $input){
    session_start();
    require_once('app/controllers/redirect.php');

    $postData = $input;

    // Validation du formulaire
    $users = getUsers();

    if (isset($postData['email']) &&  isset($postData['password'])) {
        if($postData['email'] == '' || $postData['password'] == ''){
            $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Vueillez renseigner votre email et mot de passe !';
            require('app/templates/login.php');
            return;
        }
        if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire.';
        } else {
            foreach ($users as $user) {
                if ($user['email'] === $postData['email']){
                    list($hashedPassword, $salt) = explode(':', $user['password'], 2);
                    $saltedPassword = $postData['password'] . $salt;
                    
                    if(password_verify($saltedPassword, $hashedPassword)) {
                        $_SESSION['LOGGED_USER'] = [
                            'full_name' => $user['full_name'],
                            'email' => $user['email'],
                            'user_id' => $user['user_id'],
                        ];
                        $csrfToken = bin2hex(random_bytes(32));
                        $_SESSION['csrf_token'] = $csrfToken;
                        redirectToUrl('index.php');
                    }
                }
            }

            if (!isset($_SESSION['LOGGED_USER'])) {
                $_SESSION['LOGIN_ERROR_MESSAGE'] = sprintf(
                    'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
                    $postData['email'],
                    strip_tags($postData['password'])
                );
                require('app/templates/login.php');
            }
        }
    } 
}