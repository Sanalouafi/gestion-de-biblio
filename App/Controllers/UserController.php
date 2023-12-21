<?php

namespace App\Controllers;

include __DIR__.'/../../vendor/autoload.php';

use App\Models\User;

class UserController
{
    public function registerUser($fullname, $lastname, $email, $password, $phone)
    {
        $user = new User($fullname, $lastname, $email, $password, $phone);
        if ($user->createUser()) {
            header('Location:../../views/auth/sign_login.php');
        } else {
            echo "Error adding user !!";
        }
    }

    public function loginUser($email, $password)
    {
        $user = new User('', '', $email, $password, '');

        if ($user->getByEmail()) {
            $this->redirectUser($_SESSION['role']);
        } else {
            echo "Incorrect username or password";
        }
    }

    private function redirectUser($role)
    {
        switch ($role) {
            case 1:
                header("Location:../../views/admin/dashboard.php");
                exit();
            case 2:
                echo "user";
                exit();
            default:
                echo "Unknown role";
                break;
        }
    }
}


if (isset($_POST['sign_submit'])) {
    $userController = new UserController();
    $userController->registerUser(
        $_POST['fullname'],
        $_POST['lastname'],
        $_POST['sign_email'],
        $_POST['sign_pswd'],
        $_POST['phone']
    );
}


if (isset($_POST['login_submit'])) {
    $userController = new UserController();
    $userController->loginUser(
        $_POST['login_email'],
        $_POST['login_pswd'],
    );
}
