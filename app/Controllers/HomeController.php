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
        
        $data = [
            'title' => ($space === 'admin' ? 'Dashboard Administrateur' : 'Mon Espace Utilisateur'),
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Dashboard', 'url' => '/dashboard']
            ]
        ];

        // Charger les statistiques globales pour les rôles décisionnels
        if (in_array($_SESSION['user_category'], ['dg', 'responsable_administratif'])) {
            $demandeModel = new \App\Models\Demande();
            $data['stats'] = $demandeModel->getGlobalStats();
        }

        $this->render('dashboard', $data);
    }
}
