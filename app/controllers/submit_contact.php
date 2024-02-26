<?php

function submitContact(array $input){
    $postData = $input;

if (
    !isset($postData['email'])
    || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)
    || empty($postData['message'])
    || trim($postData['message']) === ''
) {
    throw new Exception('Il faut un email et un message valides pour soumettre le formulaire.');
}

$isFileLoaded = false;
// Testons si le fichier a bien été envoyé et s'il n'y a pas des erreurs
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === 0) {
    // Testons, si le fichier est trop volumineux
    if ($_FILES['screenshot']['size'] > 1000000) {
        throw new Exception("L'envoi n'a pas pu être effectué, erreur ou image trop volumineuse");
    }

    // Testons, si l'extension n'est pas autorisée
    $fileInfo = pathinfo($_FILES['screenshot']['name']);
    $extension = $fileInfo['extension'];
    $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
    if (!in_array($extension, $allowedExtensions)) {
        throw new Exception("L'envoi n'a pas pu être effectué, l'extension {$extension} n'est pas autorisée");
    }

    // Testons, si le dossier uploads est manquant
    $path = __DIR__ . '/../uploads/';
    if (!is_dir($path)) {
        throw new Exception("L'envoi n'a pas pu être effectué, le dossier uploads est manquant");
    }

    // On peut valider le fichier et le stocker définitivement
    move_uploaded_file($_FILES['screenshot']['tmp_name'], $path . basename($_FILES['screenshot']['name']));
    $isFileLoaded = true;
}

require('app/templates/submit_contact.php');
}