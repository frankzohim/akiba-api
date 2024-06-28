<?php

namespace App\Interface\auth;


interface NewAccountInterface{

    public function createAccount(string $username,string $email=null,
    string $phone_number,
    string $password,
    string $role_id);
}
