<?php

namespace App\Models;

include __DIR__ . '/../../vendor/autoload.php';

use App\Database\DbHandler;

session_start();
class User
{
    private $fullname;
    private $lastname;
    private $email;
    private $password;
    private $phone;
    private $conn;

    public function __construct($fullname, $lastname, $email, $password, $phone)
    {
        $this->conn = DbHandler::connect();
        $this->setFullname($fullname);
        $this->setLastname($lastname);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setPhone($phone);
    }

    public function createUser()
    {
        $fullname = $this->getFullname();
        $lastname = $this->getLastname();
        $email = $this->getEmail();
        $password = $this->getPassword();
        $phone = $this->getPhone();

        $EmailError = $this->validateEmail($email);
        $fullnameError = $this->validateFullname($fullname);
        $passwordError = $this->validatePassword($password);

        if (!empty($EmailError) || !empty($fullnameError) || !empty($passwordError)) {
            echo "Validation error: $EmailError $fullnameError $passwordError";
            return false;
        }

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (fullname, lastname, email, password, phone) VALUES ('$fullname', '$lastname', '$email', '$hashPassword', '$phone')";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            $lastId = mysqli_insert_id($this->conn);
            $queryRole = "INSERT INTO user_role (user_id, role_id) VALUES ($lastId, 2)";
            $resultRole = mysqli_query($this->conn, $queryRole);

            if ($resultRole) {
                return true;
            } else {
                echo "Error adding user role";
            }
        }
    }

    public function createUserWithRole($fullname, $lastname, $email, $password, $phone, $roleId)
    {
        $emailError = $this->validateEmail($email);
        $fullnameError = $this->validateFullname($fullname);
        $passwordError = $this->validatePassword($password);

        if (!empty($emailError) || !empty($fullnameError) || !empty($passwordError)) {
            echo "Validation error: $emailError $fullnameError $passwordError";
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $queryUser = "INSERT INTO user (fullname, lastname, email, password, phone) VALUES ('$fullname', '$lastname', '$email', '$hashedPassword', '$phone')";
        $resultUser = mysqli_query($this->conn, $queryUser);

        if (!$resultUser) {
            echo "Error creating user: " . mysqli_error($this->conn);
            return false;
        }

        $userId = mysqli_insert_id($this->conn);

        $queryUserRole = "INSERT INTO user_role (user_id, role_id) VALUES ($userId, $roleId)";
        $resultUserRole = mysqli_query($this->conn, $queryUserRole);

        if (!$resultUserRole) {
            echo "Error assigning role to user: " . mysqli_error($this->conn);

            $queryRollback = "DELETE FROM user WHERE id=$userId";
            mysqli_query($this->conn, $queryRollback);

            return false;
        }

        return true;
    }

    public function editUser($id, $fullname, $lastname, $email, $phone, $roleId)
    {
        $id = mysqli_real_escape_string($this->conn, $id);
        $fullname = mysqli_real_escape_string($this->conn, $fullname);
        $lastname = mysqli_real_escape_string($this->conn, $lastname);
        $email = mysqli_real_escape_string($this->conn, $email);
        $phone = mysqli_real_escape_string($this->conn, $phone);
        $roleId = mysqli_real_escape_string($this->conn, $roleId);


        $query = "UPDATE user SET fullname='$fullname', lastname='$lastname', email='$email', phone='$phone' WHERE id=$id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error updating user: " . mysqli_error($this->conn);
            return false;
        }

        $queryUpdateRole = "UPDATE user_role SET role_id=$roleId WHERE user_id=$id";
        $resultUpdateRole = mysqli_query($this->conn, $queryUpdateRole);

        if (!$resultUpdateRole) {
            echo "Error updating user role: " . mysqli_error($this->conn);
            return false;
        }

        return true;
    }


    public function deleteUser($id)
    {
        $id = mysqli_real_escape_string($this->conn, $id);

        $query = "DELETE FROM user WHERE id=$id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error deleting user: " . mysqli_error($this->conn);
            return false;
        }

        $queryUserRole = "DELETE FROM user_role WHERE user_id=$id";
        $resultUserRole = mysqli_query($this->conn, $queryUserRole);

        if (!$resultUserRole) {
            echo "Error deleting user role: " . mysqli_error($this->conn);
            return false;
        }

        return true;
    }


    private function validateEmail($email)
    {
        if (empty($email)) {
            return 'email is required';
        }

        $queryCheck = "SELECT * FROM user WHERE email='$email'";
        $resultCheck = mysqli_query($this->conn, $queryCheck);

        if (mysqli_num_rows($resultCheck) > 0) {
            return 'email is already taken';
        }

        return '';
    }

    private function validatePassword($password)
    {
        return empty($password) ? 'Password is required' : '';
    }

    private function validateFullname($fullname)
    {
        return empty($fullname) ? 'Fullname is required' : '';
    }

    public function getAllUsers()
    {
        $query = "SELECT u.*, r.name FROM user AS u INNER JOIN user_role AS ur ON u.id = ur.user_id INNER JOIN role AS r ON ur.role_id = r.id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error in query: " . mysqli_error($this->conn);
            return false;
        } else {
            return $result;
        }
    }




    public function getByEmail()
    {
        $email = $this->getEmail();
        $password = $this->getPassword();
        $passwordError = $this->validatePassword($password);

        if (!empty($passwordError)) {
            echo "Validation error: $passwordError";
            return false;
        }

        $query = "SELECT u.*, ur.role_id, r.name FROM user AS u INNER JOIN user_role AS ur ON u.id = ur.user_id INNER JOIN role AS r ON ur.role_id = r.id WHERE email='$email'";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error retrieving user: " . mysqli_error($this->conn);
            return false;
        }

        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            echo "User not found";
            return false;
        }

        if (password_verify($password, $row['password'])) {
            $_SESSION['role'] = $row['role_id'];
            $_SESSION['name'] = $row['fullname'];
            $_SESSION['user_id'] = $row['id'];

            return true;
        } else {
            echo "Incorrect password";
            return false;
        }
    }

    public function logout()
    {
        $_SESSION['role'];
        $_SESSION['user_id'];
        $_SESSION['name'];
        
        session_destroy();

        header("Location:../../views/auth/sign_login.php");
        exit();
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = mysqli_real_escape_string($this->conn, $lastname);
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function setFullname($fullname)
    {
        $this->fullname = mysqli_real_escape_string($this->conn, $fullname);
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = mysqli_real_escape_string($this->conn, $email);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = mysqli_real_escape_string($this->conn, $password);
    }
    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = mysqli_real_escape_string($this->conn, $phone);
    }
}
