<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Middleware\AuthMiddleware;

class HomeController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();
        
        $space = $_SESSION['user_space'] ?? 'user';
        
        $this->render('dashboard', [
            'title' => ($space === 'admin' ? 'Dashboard Administrateur' : 'Mon Espace Utilisateur'),
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Dashboard', 'url' => '/dashboard']
            ]
        ]);
    }
}
