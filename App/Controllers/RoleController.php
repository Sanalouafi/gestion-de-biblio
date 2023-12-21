<?php
namespace App\Controllers;

include __DIR__ . '/../../vendor/autoload.php';

use App\Models\Role;
class RoleController
{
    public function getAllRoles()
    {
        $role = new Role('');
        return $role->getAllRoles();
    }

    public function getRoleById($id)
    {
        $role = new Role('');
        return $role->getRoleById($id);
    }
}
