<?php   
require_once('app/load_env.php');

function getUsers(){
    try{
        $database = userdbConnect();
        $usersStatement = $database->prepare('SELECT * FROM users');
        $usersStatement->execute();
        $users = $usersStatement->fetchAll();
        return $users;
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function addUser(string $full_name, int $age, string $email, string $password, string $salt){
    try{
        $database = userdbConnect();
        $insertUser = $database->prepare('INSERT INTO users(full_name, email, password, age) VALUES (:full_name, :email, :password, :age)');
        $insertUser->execute([
        'full_name' => $full_name,
        'email' => $email,
        'password' => $password . ":" . $salt,
        'age' => $age,
        ]);
        return $insertUser;
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function userDbConnect(){
    try {
        $mysqlHost = getenv('MYSQL_HOST');
        $mysqlPort = getenv('MYSQL_PORT');
        $mysqlName = getenv('MYSQL_NAME');
        $mysqlUser = getenv('MYSQL_USER');
        $mysqlPassword = getenv('MYSQL_PASSWORD');
        $database = new PDO(
            sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8', $mysqlHost, $mysqlName, $mysqlPort),
            $mysqlUser,
            $mysqlPassword
        );
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $database;
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}