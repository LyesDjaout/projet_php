<?php   
require_once('functions/load_env.php');

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

function registerUser(string $full_name, int $age, string $email, string $password, string $salt){
    try{
        $database = userdbConnect();

        $stmt = $database->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            // L'email existe déjà, renvoyer une erreur
            return "email_exists";
        } else {
            $insertUser = $database->prepare('INSERT INTO users(full_name, email, password, age) VALUES (:full_name, :email, :password, :age)');
            $insertUser->execute([
            'full_name' => $full_name,
            'email' => $email,
            'password' => $password . ":" . $salt,
            'age' => $age,
            ]);
            return true;
        }
    } catch (Exception $exception) {
        throw new Exception('Erreur : ' . $exception->getMessage());
    }
}

function loginUser($email, $password) {
    try {
        $database = userDbConnect();
        // Récupérer les informations de l'utilisateur (Requête préparée pour prévenir l'injection SQL)
        $stmt = $database->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user){
            list($hashedPassword, $salt) = explode(':', $user['password'], 2);
            $saltedPassword = $password . $salt;

            if (password_verify($saltedPassword, $hashedPassword)) {
                // Connexion réussie, stocker l'ID de l'utilisateur en session
                $_SESSION['LOGGED_USER'] = [
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'user_id' => $user['user_id'],
                ];
                
                return true;
            } else {
                return "wrong_email_password";
            }
        } else {
            // Échec de connexion, afficher un message d'erreur
            return "wrong_email_password";
        }
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la connexion de l'utilisateur : " . $e->getMessage());
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