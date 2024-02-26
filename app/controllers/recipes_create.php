<?php

function createRecipes(){
    session_start();

    require_once(__DIR__ . '/is_connect.php');

    require('app/templates/recipes_create.php');
}