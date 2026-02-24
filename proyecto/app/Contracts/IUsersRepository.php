<?php

namespace App\Contracts;
use App\Models\User;

interface IUsersRepository {
    function save(User $usuario): User;

    function delete(int $idUsuario): bool;

    function update(User $usuario): void;

    function getById($id): ?User;

    function getByEmail(string $email): ?User;

    function getByNombre(string $nombre): ?User;
}
?>