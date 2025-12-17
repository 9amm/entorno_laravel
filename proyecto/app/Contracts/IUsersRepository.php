<?php
interface IUsersRepository {
    function save(User $usuario): void;

    function update(User $usuario): void;

    function getById($id): ?User;

    function getByEmail(string $email): ?User;

    function getByNombre(string $nombre): ?User;
}
?>