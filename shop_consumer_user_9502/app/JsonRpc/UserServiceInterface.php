<?php

namespace App\JsonRpc;

interface UserServiceInterface
{
    public function createUser(string $name, int $gender);

    public function getUserInfo(int $id);

    public function test();

    public function getServerInfo();

    public function timeout($id);

    public function getUserInfoFromCache(int $id);
}
