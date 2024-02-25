<?php
require_once('app/controllers/homepage.php');
require_once('app/controllers/contact.php');
require_once('app/controllers/submit_contact.php');
require_once('app/controllers/recipes_create.php');
require_once('app/controllers/recipes_post_create.php');
require_once('app/controllers/logout.php');
require_once('app/controllers/submit_login.php');
require_once('app/controllers/recipes_read.php');
require_once('app/controllers/recipes_update.php');
require_once('app/controllers/recipes_post_update.php');
require_once('app/controllers/recipes_delete.php');
require_once('app/controllers/recipes_post_delete.php');
require_once('app/controllers/comments_post_create.php');
require_once('app/controllers/login.php');

try{
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        switch ($_GET['action']) {
            case 'createCommentsPost':
                addComment($_POST);
                break;
            case 'contact':
                contact();
                break;
            case 'submitContact':
                submitContact($_POST);
                break;
            case 'createRecipes':
                createRecipes();
                break;
            case 'createRecipesPost':
                addRecipes($_POST);
                break;
            case 'logout':
                logout();
                break;
            case 'submitLogin':
                submitLogin($_POST);
                break;
            case 'readRecipes':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $identifier = $_GET['id'];
                    readRecipes($identifier);
                }
                break;
            case 'updateRecipes':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $identifier = $_GET['id'];
                    updateRecipes($identifier);
                }
                break;
            case 'updateRecipesPost':
                updateRecipesPost($_POST);
                break;
            case 'deleteRecipes':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $identifier = $_GET['id'];
                    deleteRecipes($identifier);
                }
                break;
            case 'deleteRecipesPost':
                deleteRecipesPost($_POST);
                break;
            case 'login':
                login();
                break;
            default:
                throw new Exception("La page que vous recherchez n'existe pas.");
        }
    } else {
        homepage();     
    }
    
}catch(Exception $e){
    echo $e->getMessage();
}