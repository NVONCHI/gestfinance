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
        $userCat = \App\Core\AuthHelper::getCategory();
        if ($userCat === CategorieUtilisateur::AGENT->value) {
            $this->redirect('/');
        }

        $db = \App\Core\Database::getInstance();
        
        if ($userCat === CategorieUtilisateur::RESPONSABLE_DIRECTEUR->value) {
            $query = "SELECT d.*, u.nom, u.prenom 
                      FROM demandes d 
                      JOIN users u ON d.user_id = u.id 
                      JOIN services s ON d.service_id = s.id
                      WHERE d.statut = :statut AND s.responsable_id = :userId";
            $stmt = $db->prepare($query);
            $stmt->execute([
                'statut' => \App\Enums\StatutDemande::SOUMIS->value,
                'userId' => \App\Core\AuthHelper::getUserId()
            ]);
            $demandes = $stmt->fetchAll();
        } elseif ($userCat === CategorieUtilisateur::DG->value) {
            $query = "SELECT d.*, u.nom, u.prenom 
                      FROM demandes d 
                      JOIN users u ON d.user_id = u.id 
                      WHERE d.statut = :statut";
            $stmt = $db->prepare($query);
            $stmt->execute([
                'statut' => \App\Enums\StatutDemande::VALIDE_DIRECTEUR->value
            ]);
            $demandes = $stmt->fetchAll();
        } elseif ($userCat === CategorieUtilisateur::RESPONSABLE_ADMINISTRATIF->value) {
            $query = "SELECT d.*, u.nom, u.prenom 
                      FROM demandes d 
                      JOIN users u ON d.user_id = u.id 
                      WHERE d.statut = :statut";
            $stmt = $db->prepare($query);
            $stmt->execute([
                'statut' => \App\Enums\StatutDemande::VALIDE_DG->value
            ]);
            $demandes = $stmt->fetchAll();
        } else {
            $demandes = [];
        }

        $stmt = $db->prepare("
            SELECT d.*, u.nom, u.prenom 
            FROM demandes d 
            JOIN users u ON d.user_id = u.id 
            WHERE d.id IN (
                SELECT demande_id FROM validations WHERE validateur_id = ? AND action = 'validation'
            )
            ORDER BY d.created_at DESC
        ");
        $stmt->execute([\App\Core\AuthHelper::getUserId()]);
        $demandesPassees = $stmt->fetchAll();

        $stmt = $db->prepare("
            SELECT d.*, u.nom, u.prenom 
            FROM demandes d 
            JOIN users u ON d.user_id = u.id 
            WHERE d.id IN (
                SELECT demande_id FROM validations WHERE validateur_id = ? AND action = 'rejet'
            )
            ORDER BY d.created_at DESC
        ");
        $stmt->execute([\App\Core\AuthHelper::getUserId()]);
        $demandesRejetees = $stmt->fetchAll();
        
        $this->render('user/validation/index', [
            'demandes' => $demandes,
            'demandesPassees' => $demandesPassees,
            'demandesRejetees' => $demandesRejetees,
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
        
        if ($this->validationService->validate($id, \App\Core\AuthHelper::getUserId(), $commentaire)) {
            $_SESSION['flash_success'] = "Validée.";
        }
        $this->redirect('/validations');
    }

    public function reject(int $id): void
    {
        CsrfMiddleware::handle();
        $commentaire = $_POST['commentaire'] ?? '';
        if ($this->validationService->reject($id, \App\Core\AuthHelper::getUserId(), $commentaire)) {
            $_SESSION['flash_success'] = "Rejetée.";
        }
        $this->redirect('/validations');
    }
}
