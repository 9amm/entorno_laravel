<?php

namespace App\Providers;

use App\Contracts\IUsersRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;


class UsuarioProvider implements UserProvider {
    protected IUsersRepository $repositorioUsuarios;

    public function __construct(IUsersRepository $repositorioUsuarios) {
        $this->repositorioUsuarios = $repositorioUsuarios;
    }


    public function retrieveById($identifier): Authenticatable {
        return $this->repositorioUsuarios->getById($identifier);
    }

    public function retrieveByToken($identifier, $token) {
    }

    public function updateRememberToken(Authenticatable $user, $token){
    }

    public function retrieveByCredentials(array $credentials) {
        $email = $credentials["email"];
        return $this->repositorioUsuarios->getByEmail($email);
    }

    public function validateCredentials(Authenticatable $user, array $credentials) {
        //ya deberia venir hasheada
        $passComprobar = $credentials["pass"];
        return $user->getAuthPassword() == $passComprobar;
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false) {
    }
}
