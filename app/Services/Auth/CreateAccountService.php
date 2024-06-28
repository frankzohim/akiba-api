<?php

namespace App\services\auth;

use App\Interface\auth\NewAccountInterface;
use App\Models\User;

class CreateAccountService implements NewAccountInterface{

    // ici le scope est une chaine de caractere unique a chaque user
    public function createAccount(string $username, ?string $email = null, string $phone_number, string $password, string $scope)
    {

    }
}

