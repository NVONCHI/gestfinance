<?php

declare(strict_types=1);

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Demande;
use App\Models\Service;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Enums\StatutDemande;

class DemandeController extends Controller
{
    private Demande $demandeModel;

    public function __construct()
    {
        AuthMiddleware::handle();
        $this->demandeModel = new Demande();
    }

    public function index(): void
    {
        $stmt = \App\Core\Database::getInstance()->prepare("SELECT * FROM demandes WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$_SESSION['user_id']]);
        $demandes = $stmt->fetchAll();
        
        $this->render('user/demandes/index', [
            'demandes' => $demandes,
            'title' => 'Mes Demandes',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Mes Demandes', 'url' => '/demandes']
            ]
        ]);
    }

    public function create(): void
    {
        $services = (new Service())->all();
        $this->render('user/demandes/create', [
            'services' => $services,
            'title' => 'Nouvelle Demande',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Mes Demandes', 'url' => '/demandes'],
                ['label' => 'Nouvelle', 'url' => '/demandes/create']
            ]
        ]);
    }

    public function show(int $id): void
    {
        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("SELECT d.*, u.nom, u.prenom, s.libelle as service_nom 
                             FROM demandes d 
                             JOIN users u ON d.user_id = u.id 
                             JOIN services s ON d.service_id = s.id 
                             WHERE d.id = ?");
        $stmt->execute([$id]);
        $demande = $stmt->fetch();

        if (!$demande) {
            die("Demande non trouvée.");
        }

        $stmt = $db->prepare("SELECT v.*, u.nom, u.prenom 
                             FROM validations v 
                             JOIN users u ON v.validateur_id = u.id 
                             WHERE v.demande_id = ? 
                             ORDER BY v.created_at ASC");
        $stmt->execute([$id]);
        $validations = $stmt->fetchAll();

        $this->render('user/demandes/show', [
            'demande' => $demande,
            'validations' => $validations,
            'title' => 'Détails de la demande',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Mes Demandes', 'url' => '/demandes'],
                ['label' => "Demande #$id", 'url' => "/demandes/$id"]
            ]
        ]);
    }

    public function store(): void
    {
        // ... (identique à l'original) ...
        CsrfMiddleware::handle();
        $data = [
            'user_id' => $_SESSION['user_id'],
            'service_id' => $_POST['service_id'],
            'fonction' => $_POST['fonction'],
            'objet' => $_POST['objet'],
            'montant' => $_POST['montant'],
            'statut' => isset($_POST['submit_action']) && $_POST['submit_action'] === 'soumettre' 
                        ? StatutDemande::SOUMIS->value 
                        : StatutDemande::BROUILLON->value,
        ];
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt = \App\Core\Database::getInstance()->prepare("INSERT INTO demandes ({$columns}) VALUES ({$placeholders})");
        if ($stmt->execute(array_values($data))) {
            $_SESSION['flash_success'] = "Demande enregistrée.";
            $this->redirect('/demandes');
        } else {
            $_SESSION['flash_error'] = "Erreur.";
            $this->redirect('/demandes/create');
        }
    }
}
