<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/src/model.php');

$users = getUsers();
$recipes = getRecipes();

require('templates/HomePage.php');