<?php

if (!isset($_SESSION['LOGGED_USER'])) {
    throw new Exception('Il faut être authentifié pour cette action.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token'])) {
    throw new Exception('Jeton CSRF invalide.');
}