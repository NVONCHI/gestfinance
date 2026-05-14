<?php

namespace App\Enums;

/**
 * Enum représentant les espaces utilisateurs.
 */
enum SpaceEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case SUPER_ADMIN = 'super_admin';
}