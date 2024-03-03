<?php
require_once('app/controllers/submit_contact.php');
require_once('app/controllers/recipes_post_create.php');
require_once('app/controllers/submit_login.php');
require_once('app/controllers/recipes_read.php');
require_once('app/controllers/recipes_update.php');
require_once('app/controllers/recipes_post_update.php');
require_once('app/controllers/recipes_delete.php');
require_once('app/controllers/recipes_post_delete.php');
require_once('app/controllers/comments_post_create.php');
require_once('app/controllers/submit_register.php');
require_once('app/controllers/display_autor.php');
require_once('app/controllers/get_valid_recipes.php');
require_once('app/model/recipe.php');
require_once('app/model/user.php');
require_once('app/controllers/is_connect.php');

try{
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        switch ($_GET['action']) {
            case 'comments_post_create':
                addComment($_POST);
                break;
            case 'contact':
                session_start(); 
                require('app/templates/contact.php');
                break;
            case 'submit_contact':
                submitContact($_POST);
                break;
            case 'recipes_create':
                session_start();
                isConnect();
                require('app/templates/recipes_create.php');
                break;
            case 'recipes_post_create':
                addRecipes($_POST);
                break;
            case 'logout':
                require_once('app/controllers/redirect.php');
                session_start();
                session_unset();
                session_destroy();
                redirectToUrl('index.php');
                break;
            case 'submit_login':
                submitLogin($_POST);
                break;
            case 'recipes_read':
                if (isset($_POST['recipe_id']) && $_POST['recipe_id'] > 0) {
                    $identifier = $_POST['recipe_id'];
                    readRecipes($identifier);
                }
                break;
            case 'recipes_update':
                if (isset($_POST['recipe_id']) && $_POST['recipe_id'] > 0) {
                    $identifier = $_POST['recipe_id'];
                    updateRecipes($identifier);
                }
                break;
            case 'recipes_post_update':
                updateRecipesPost($_POST);
                break;
            case 'recipes_delete':
                if (isset($_POST['recipe_id']) && $_POST['recipe_id'] > 0) {
                    $identifier = $_POST['recipe_id'];
                    deleteRecipes($identifier);
                }
                break;
            case 'recipes_post_delete':
                deleteRecipesPost($_POST);
                break;
            case 'login':
                require('app/templates/login.php');
                break;
            case 'submit_register':
                submitRegister($_POST);
                break;
                case 'register':
                    require('app/templates/register.php');
                    break;
            default:
                throw new Exception("La page que vous recherchez n'existe pas.");
        }
    } else {
        session_start();
        $users = getUsers();
        $recipes = getRecipes();
        require('app/templates/homepage.php');    
    }
    
}catch(Exception $e){
    $error_message = $e->getMessage();
    require('app/templates/error.php');
}