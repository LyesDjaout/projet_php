<?php
require_once('app/model/recipe.php');
require_once('app/model/user.php');

function homepage(){
    session_start();
    
    $users = getUsers();
    $recipes = getRecipes();

    require('app/templates/homepage.php');
}
