<?php

namespace App\Interfaces;

interface UserReadableInterface
{
    public function getAllUsers();
    public function getUserById($id);
}