<?php
require_once('app/controllers/redirect.php');
require_once('app/model/user.php');

function submitRegister(array $input){
    session_start();
    $postData = $input;

    if(isset($postData['full_name'])){
        if($postData['full_name'] == ''){
            $_SESSION['REGISTER_ERROR_MESSAGE'] = "Vous devez renseigner votre nom complet !";       
            require('app/templates/register.php');
            return; 
        }
    } else {
        throw new Exception("Erreur le champ Nom complet n'existe pas"); 
    }

    if(isset($postData['age'])){
        if($postData['age'] == 0){
            $_SESSION['REGISTER_ERROR_MESSAGE'] = "Veuillez renseiger un age valide !";    
            require('app/templates/register.php');
            return;    
        }
    } else {
        throw new Exception("Erreur le champ Age n'existe pas"); 
    }

    if(isset($postData['email'])){
        if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['REGISTER_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire !';
            require('app/templates/register.php');
            return;
        }
    } else {
        throw new Exception("Erreur le champ Email n'existe pas"); 
    }

    if(isset($postData['password'])){
        if (strlen($postData['password']) < 4 || !preg_match('/[0-9]/', $postData['password']) || !preg_match('/[a-z]/', $postData['password']) || !preg_match('/[A-Z]/', $postData['password']) || !preg_match('/[^a-zA-Z0-9\s]/', $postData['password'])) {
            $_SESSION['REGISTER_ERROR_MESSAGE'] = 'Le mot de passe doit contenir au moins 4 caractères, une majuscule, une minuscule, un caractère spécial et un chiffre !';
            require('app/templates/register.php');
            return;
        }else {
            $salt = bin2hex(random_bytes(16));
            $saltedPassword = $postData['password'] . $salt;
            $password = password_hash($saltedPassword, PASSWORD_DEFAULT);
        }
    } else {
        throw new Exception("Erreur le champ Mot de passe n'existe pas"); 
    }
    
    $success = addUser($postData['full_name'], $postData['age'], $postData['email'], $password, $salt);
    if (!$success) {
        throw new Exception('Impossible d\'ajouter l\'utilisateur !');
    } else {
        require('app/templates/login.php');
    }
};