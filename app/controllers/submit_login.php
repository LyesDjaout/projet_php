<?php

function submitLogin(array $input){
    session_start();
    require_once('app/controllers/redirect.php');

    $postData = $input;

    // Validation du formulaire
    $users = getUsers();
    if (isset($postData['email']) &&  isset($postData['password'])) {
        if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire.';
        } else {
            foreach ($users as $user) {
                if (
                    $user['email'] === $postData['email'] &&
                    $user['password'] === $postData['password']
                ) {
                    $_SESSION['LOGGED_USER'] = [
                        'email' => $user['email'],
                        'user_id' => $user['user_id'],
                    ];
                    redirectToUrl('index.php');
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