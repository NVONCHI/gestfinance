<?php

namespace App\Enums;

enum ServiceTypeEnum: string
{
    case INF = 'INF';
    case RH = 'RH';
    case COMPTA = 'COMPTA';
    case DG = 'DG';

    public function label(): string
    {
        return match ($this) {
            self::INF => 'Informatique',
            self::RH => 'Ressources Humaines',
            self::COMPTA => 'Comptabilité',
            self::DG => 'Direction Générale',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::INF => 'Direction des Systèmes d\'Information',
            self::RH => 'Gestion du personnel',
            self::COMPTA => 'Gestion financière et comptable',
            self::DG => 'Administration générale',
        };
    }
}
