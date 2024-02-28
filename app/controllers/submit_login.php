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
        if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL) || !preg_match('/^(("[\w\s!#$%&\'*+\/=?^`{|}~.-]+")|([\w\s!#$%&\'*+\/=?^`{|}~.-]+))@(?:[\w-]+\.)+[\w]{2,}$/', $postData['email'])) {
            $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire.';
            require('app/templates/login.php');
            return;
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
                $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Les informations envoyées ne permettent pas de vous identifier';
                require('app/templates/login.php');
            }
        }
    } 
}