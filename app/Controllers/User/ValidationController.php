<?php

declare(strict_types=1);

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Services\ValidationService;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Enums\CategorieUtilisateur;

class ValidationController extends Controller
{
    private ValidationService $validationService;

    public function __construct()
    {
        AuthMiddleware::handle();
        $this->validationService = new ValidationService();
    }

    public function index(): void
    {
        $userCat = $_SESSION['user_category'];
        if ($userCat === CategorieUtilisateur::AGENT->value) {
            $this->redirect('/');
        }

        $db = \App\Core\Database::getInstance();
        $query = "SELECT d.*, u.nom, u.prenom FROM demandes d JOIN users u ON d.user_id = u.id WHERE ";
        
        if ($userCat === CategorieUtilisateur::RESPONSABLE_DIRECTEUR->value) {
            $query .= "d.statut = 'soumis'";
        } elseif ($userCat === CategorieUtilisateur::RESPONSABLE_ADMINISTRATIF->value) {
            $query .= "d.statut = 'valide_directeur'";
        } elseif ($userCat === CategorieUtilisateur::DG->value) {
            $query .= "d.statut = 'valide_ra'";
        } else {
            $query .= "1=0";
        }

        $demandes = $db->query($query)->fetchAll();

        $stmt = $db->prepare("
            SELECT d.*, u.nom, u.prenom 
            FROM demandes d 
            JOIN users u ON d.user_id = u.id 
            WHERE d.id IN (
                SELECT demande_id FROM validations WHERE validateur_id = ?
            )
            ORDER BY d.created_at DESC
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $demandesPassees = $stmt->fetchAll();
        
        $this->render('user/validation/index', [
            'demandes' => $demandes,
            'demandesPassees' => $demandesPassees,
            'title' => 'Validations en attente',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Validations', 'url' => '/validations']
            ]
        ]);
    }

    public function approve(int $id): void
    {
        CsrfMiddleware::handle();
        $commentaire = $_POST['commentaire'] ?? '';
        
        if ($this->validationService->validate($id, $_SESSION['user_id'], $commentaire)) {
            $_SESSION['flash_success'] = "Validée.";
        }
        $this->redirect('/validations');
    }

    public function reject(int $id): void
    {
        CsrfMiddleware::handle();
        $commentaire = $_POST['commentaire'] ?? '';
        if ($this->validationService->reject($id, $_SESSION['user_id'], $commentaire)) {
            $_SESSION['flash_success'] = "Rejetée.";
        }
        $this->redirect('/validations');
    }
}
