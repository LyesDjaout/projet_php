<?php

function createRecipes(){
    session_start();

    require_once(__DIR__ . '/isConnect.php');

    require('app/templates/recipes_create.php');
}