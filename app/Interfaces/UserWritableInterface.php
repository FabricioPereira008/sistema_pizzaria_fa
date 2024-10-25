<?php

namespace App\Interfaces;

interface UserWritableInterface
{
    public function createUser(array $data);
    public function updateUser(array $data, $id);
}