<?php
namespace App\Models;

include '../../vendor/autoload.php';
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

        // Basic validation
        $passwordError = $this->validatePassword($password);

        if (!empty($passwordError)) {
            // Validation failed
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

            return true;
        } else {
            echo "Incorrect password";
            return false;
        }
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
