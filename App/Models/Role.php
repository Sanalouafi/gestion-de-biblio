<?php

namespace App\Models;

include __DIR__ . '/../../vendor/autoload.php';
use App\Database\DbHandler;

class Role
{
    private $id;
    private $name;
    private $conn;

    public function __construct($name)
    {
        $this->conn = DbHandler::connect();
        $this->setName($name);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = mysqli_real_escape_string($this->conn, $name);
    }

    public function getAllRoles()
    {
        $query = "SELECT * FROM role";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error in query: " . mysqli_error($this->conn);
            return false;
        } else {
            $roles = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $role = new Role($row['name']);
                $role->setId($row['id']);
                $roles[] = $role;
            }

            return $roles;
        }
    }

    public function getRoleById($id)
    {
        $id = mysqli_real_escape_string($this->conn, $id);

        $query = "SELECT * FROM role WHERE id=$id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error in query: " . mysqli_error($this->conn);
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $role = new Role($row['name']);
                $role->setId($row['id']);
                return $role;
            } else {
                return null;
            }
        }
    }
}
