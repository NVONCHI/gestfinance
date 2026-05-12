<?php

namespace App\Enums;

enum RoleTypeEnum : string
{
    case ADMIN = 'ADMIN';
    case AGENT = 'AGENT';
    case DIR = 'DIR';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrateur',
            self::AGENT => 'Agent',
            self::DIR => 'Directeur',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::ADMIN => 'Accès total au système',
            self::AGENT => 'Utilisateur standard',
            self::DIR => 'Responsable de service',
        };
    }
}
