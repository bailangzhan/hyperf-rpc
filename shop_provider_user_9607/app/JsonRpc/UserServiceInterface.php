<?php

namespace App\JsonRpc;

interface UserServiceInterface
{
    public function createUser(string $name, int $gender);

    public function getUserInfo(int $id);

    public function discovery();

    public function getServerInfo();
}
