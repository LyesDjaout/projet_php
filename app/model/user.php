<?php   
require_once('app/load_env.php');

function getUsers(){
    $database = userdbConnect();
    $usersStatement = $database->prepare('SELECT * FROM users');
    $usersStatement->execute();
    $users = $usersStatement->fetchAll();
    return $users;
}

function displayAuthor(string $authorEmail, array $users): string
{
    foreach ($users as $user) {
        if ($authorEmail === $user['email']) {
            return $user['full_name'] . '(' . $user['age'] . ' ans)';
        }
    }

    return 'Auteur inconnu';
}

function userDbConnect(){
    $mysqlHost = getenv('MYSQL_HOST');
    $mysqlPort = getenv('MYSQL_PORT');
    $mysqlName = getenv('MYSQL_NAME');
    $mysqlUser = getenv('MYSQL_USER');
    $mysqlPassword = getenv('MYSQL_PASSWORD');
    // try {
        $database = new PDO(
            sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8', $mysqlHost, $mysqlName, $mysqlPort),
            $mysqlUser,
            $mysqlPassword
        );
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $database;
    // } catch (Exception $exception) {
    //     die('Erreur : ' . $exception->getMessage());
    // }
}