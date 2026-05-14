<?php

declare(strict_types=1);

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Demande;
use App\Models\Service;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Enums\StatutDemande;

/**
 * Contrôleur pour la gestion des demandes par les utilisateurs.
 */
class DemandeController extends Controller
{
    private Demande $demandeModel;

    public function __construct()
    {
        AuthMiddleware::handle();
        $this->demandeModel = new Demande();
    }

    /**
     * Liste les demandes de l'utilisateur connecté.
     */
    public function index(): void
    {
        $demandes = $this->demandeModel->findByUser($_SESSION['user_id']);
        
        $this->render('user/demandes/index', [
            'demandes' => $demandes,
            'title' => 'Mes Demandes',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Mes Demandes', 'url' => '/demandes']
            ]
        ]);
    }

    /**
     * Formulaire de création d'une demande.
     */
    public function create(): void
    {
        $this->render('user/demandes/create', [
            'services' => (new Service())->all(),
            'title' => 'Nouvelle Demande',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Mes Demandes', 'url' => '/demandes'],
                ['label' => 'Nouvelle', 'url' => '/demandes/create']
            ]
        ]);
    }

    /**
     * Enregistre une nouvelle demande.
     */
    public function store(): void
    {
        CsrfMiddleware::handle();

        $statut = StatutDemande::BROUILLON->value;
        if (isset($_POST['submit_action']) && $_POST['submit_action'] === 'soumettre') {
            $cat = $_SESSION['user_category'];
            if ($cat === \App\Enums\CategorieUtilisateur::DG->value) {
                $statut = StatutDemande::ENREGISTRE->value;
            } elseif ($cat === \App\Enums\CategorieUtilisateur::RESPONSABLE_ADMINISTRATIF->value) {
                $statut = StatutDemande::VALIDE_RA->value;
            } elseif ($cat === \App\Enums\CategorieUtilisateur::RESPONSABLE_DIRECTEUR->value) {
                $statut = StatutDemande::VALIDE_DIRECTEUR->value;
            } else {
                $statut = StatutDemande::SOUMIS->value;
            }
        }

        $data = [
            'user_id' => $_SESSION['user_id'],
            'service_id' => $_POST['service_id'],
            'fonction' => $_POST['fonction'],
            'objet' => $_POST['objet'],
            'montant' => $_POST['montant'],
            'statut' => $statut,
        ];

        if ($this->demandeModel->create($data)) {
            $_SESSION['flash_success'] = "La demande a été enregistrée avec succès.";
            $this->redirect('/demandes');
        } else {
            $_SESSION['flash_error'] = "Une erreur est survenue lors de l'enregistrement.";
            $this->redirect('/demandes/create');
        }
    }

    /**
     * Affiche les détails d'une demande.
     */
    public function show(int $id): void
    {
        $demande = $this->demandeModel->findWithDetails($id);

        if (!$demande) {
            $_SESSION['flash_error'] = "Demande introuvable.";
            $this->redirect('/demandes');
        }

        // Vérifier l'accès (le demandeur ou un valideur concerné)
        // Pour simplifier : le demandeur
        if ($demande['user_id'] != $_SESSION['user_id'] && $_SESSION['user_category'] === 'agent') {
            http_response_code(403);
            die("Accès non autorisé.");
        }

        // Récupérer l'historique des validations
        $db = \App\Core\Database::getInstance();
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
                ['label' => "Demande #" . $id, 'url' => '#']
            ]
        ]);
    }
}
