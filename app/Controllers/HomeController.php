<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Middleware\AuthMiddleware;

class HomeController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();
        
        $this->render('dashboard', [
            'title' => 'Tableau de Bord',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/']
            ]
        ]);
    }
}
