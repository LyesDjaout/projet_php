<?php
include_once 'service.php';
include_once 'security.php';
include_once 'model/comment.php';
include_once 'model/recipe.php';
include_once 'model/user.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();    
}

function controller(){
    try{

        if (session_status() == PHP_SESSION_NONE) {
            session_start();    
        }

        if (isset($_GET['action']) && $_GET['action'] !== '') {
            switch ($_GET['action']) {
                case 'register':
                    handleRegisterAction();
                    break;
                case 'login':
                    handleLoginAction();
                    break;
                case 'contact':
                    handleSubmitContactAction();
                    break;
                case 'create_recipe':
                    handleAddRecipeAction();
                    break;
                case 'read_recipe':
                    handleReadRecipeAction();
                    break;
                case 'update_recipe':
                    handleUpdateRecipeAction();
                    break;
                case 'display_update_recipe':
                    handleDisplayUpdateRecipeAction();
                    break;
                case 'delete_recipe':
                    handleDeleteRecipesAction();
                    break;
                case 'display_delete_recipe':
                    handleDisplayDeleteRecipeAction();
                    break;
                case 'display_create_comment':
                    handleAddCommentAction();
                    break;
                case 'logout':
                    handleLogoutAction();
                    break;
                default:
                    throw new Exception("La page que vous recherchez n'existe pas.");
            }
        } else {
            $users = getUsers();
            $recipes = getRecipes();
            include_once 'templates/homepage.php';    
        }
        
    }catch(Exception $e){
        $error_message = $e->getMessage();
        include_once 'templates/error.php';
    }
}