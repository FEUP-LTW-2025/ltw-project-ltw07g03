<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');


$uploadDir = __DIR__ . '/../assets/images/ProfilePictures';
$defaultProfilePicture = 'default.jpeg'; // caso nenhum ficheiro seja enviado

$session = new Session();



$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$mockId = 0; //ao fazer insert na função upload o id vai ser automaticamente gerado
$isAdmin = false; //considerar que todos os novos useres registrados não são admins
$status = 'active'; //confirmar para que serve isto


$db = getDatabaseConnection();

if (!isEmptyInput($name, $username, $email, $password))
{
    if(isUsernameUnique($db, $username) && isEmailUnique($db, $email))
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $profielPictureURL = handlePicture($uploadDir, $defaultProfilePicture, $session);
        $user = new User($mockId, $name, $username, $email, $hashedPassword, $isAdmin, $profielPictureURL, $status);
        $user->upload($db);

        $session->setId($user->getId());
        $session->setName($user->getName());
        $session->addMessage('success', 'SignUp successful!');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        $session->addMessage('error', 'Username or Email already used, try again');
        echo 'Hello from username or email in use';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
        }
} else{
    $session->addMessage('error', 'Failed to SignUp due to missing fields');
    echo 'Hello from empty input';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
    }


//profilePicture pode estar a null, se o user quiser depois mete quando editar o seu perfil
function isEmptyInput(string $name, string $username, string $email, string $password): bool {
    return (empty($name) || empty($username) || empty($email) || empty($password));
}


function isUsernameUnique(PDO $db, string $username): bool {
    return User::getUserByUsername($db, $username) === null;
}

function isEmailUnique(PDO $db, string $email): bool {
    return User::getUserByEmail($db, $email) === null;
}



function handlePicture(string $uploadDir, string $default, Session $session): string {
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (!isset($_FILES['profilePicture']) || $_FILES['profilePicture']['error'] !== UPLOAD_ERR_OK) {
        return $default;
    }

    $file = $_FILES['profilePicture'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        $session->addMessage('error', 'Profile picture type not allowed. Allowed: .jpeg, .png, .gif');
        return $default;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = uniqid('profile_', true) . '.' . $ext;
    $targetPath = $uploadDir . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return 'assets/images/ProfilePictures/' . $filename;
    } else {
        $session->addMessage('error', 'Failed to upload image. Default picture used.');
        return $default;
    }
}





/*
CREATE TABLE User
(
    userId            INTEGER,
    name              NVARCHAR(255),
    username          VARCHAR(255),
    email             VARCHAR(255),
    password          VARCHAR(255),
    isAdmin           BOOLEAN     DEFAULT 0,
    profilePictureURL VARCHAR(1023),
    status            VARCHAR(15) DEFAULT 'inactive',

    CONSTRAINT User_PK PRIMARY KEY (userId),
    CONSTRAINT User_email_unique UNIQUE (email),
    CONSTRAINT User_username_unique UNIQUE (username),
    CONSTRAINT User_name_NN CHECK (name IS NOT NULL),
    CONSTRAINT User_username_NN CHECK (username IS NOT NULL),
    CONSTRAINT User_email_NN CHECK (email IS NOT NULL),
    CONSTRAINT User_password_NN CHECK (password IS NOT NULL),
    CONSTRAINT User_isAdmin_NN CHECK (isAdmin IS NOT NULL),
    CONSTRAINT User_status_NN CHECK (status IS NOT NULL),
    CONSTRAINT User_isAdmin_CK CHECK (isAdmin IN (0, 1)),
    CONSTRAINT User_status_CK CHECK (status IN ('active', 'inactive'))
);
*/ 

/*
public function upload(PDO $db): void
    {
        $stmt = $db->prepare(
            "INSERT INTO User (name, username, email, password, isAdmin, profilePictureURL, status) 
        VALUES (:name, :username, :email, :password, :isAdmin, :profilePictureURL, :status)"
        );

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":isAdmin", $this->isAdmin);
        $stmt->bindParam(":profilePictureURL", $this->profilePicture);
        $stmt->bindParam(":status", $this->status);

        $stmt->execute();
    }


*/





