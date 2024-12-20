<?php

namespace App\Security;


final class UserRoles
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_DRIVER = 'ROLE_DRIVER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public static function getAllRoles(): array
    {
        return [
            'User' => self::ROLE_USER,
            'Driver' => self::ROLE_DRIVER,
            'Admin' => self::ROLE_ADMIN,
        ];
    }

    public static function getRoleHierarchy(): array
    {
        return [
            self::ROLE_ADMIN => [self::ROLE_DRIVER, self::ROLE_USER],
            self::ROLE_DRIVER => [self::ROLE_USER],
        ];
    }
}