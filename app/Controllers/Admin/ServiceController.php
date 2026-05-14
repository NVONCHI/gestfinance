<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use App\Middleware\RoleMiddleware;
use App\Enums\CategorieUtilisateur;

class ServiceController extends Controller
{
    private Service $serviceModel;

    public function __construct()
    {
        RoleMiddleware::handle([CategorieUtilisateur::DG->value, CategorieUtilisateur::RESPONSABLE_ADMINISTRATIF->value,CategorieUtilisateur::SUPER_ADMIN->value]);
        $this->serviceModel = new Service();
    }

    public function index(): void
    {
        // On récupère les services avec le nom du responsable
        $db = \App\Core\Database::getInstance();
        $services = $db->query("
            SELECT s.*, u.nom as resp_nom, u.prenom as resp_prenom 
            FROM services s 
            LEFT JOIN users u ON s.responsable_id = u.id
            ORDER BY s.libelle ASC
        ")->fetchAll();

        $this->render('admin/services/index', [
            'services' => $services,
            'title' => 'Gestion des Services',
            'breadcrumbs' => [['label' => 'Accueil', 'url' => '/'], ['label' => 'Services', 'url' => '/admin/services']]
        ]);
    }

    public function create(): void
    {
        $this->render('admin/services/create', [
            'title' => 'Nouveau Service',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Services', 'url' => '/admin/services'],
                ['label' => 'Nouveau', 'url' => '/admin/services/create']
            ]
        ]);
    }

    public function store(): void
    {
        $data = $this->getFormData();
        if ($this->serviceModel->create($data)) {
            $_SESSION['flash_success'] = "Service créé.";
            $this->redirect('/admin/services');
        } else {
            $_SESSION['flash_error'] = "Erreur lors de la création.";
            $this->redirect('/admin/services/create');
        }
    }

    public function edit(int $id): void
    {
        $service = $this->serviceModel->find($id);
        if (!$service) $this->redirect('/admin/services');

        $this->render('admin/services/edit', [
            'service' => $service,
            'title' => 'Modifier le Service',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Services', 'url' => '/admin/services'],
                ['label' => 'Modifier', 'url' => '#']
            ]
        ]);
    }

    public function update(int $id): void
    {
        $data = $this->getFormData();
        if ($this->serviceModel->update($id, $data)) {
            $_SESSION['flash_success'] = "Service mis à jour.";
            $this->redirect('/admin/services');
        } else {
            $this->redirect("/admin/services/edit/$id");
        }
    }

    public function delete(int $id): void
    {
        $this->serviceModel->delete($id);
        $_SESSION['flash_success'] = "Service supprimé.";
        $this->redirect('/admin/services');
    }

    private function getFormData(): array
    {
        return [
            'libelle' => $_POST['libelle'],
            'code' => $_POST['code'],
            'responsable_id' => !empty($_POST['responsable_id']) ? (int)$_POST['responsable_id'] : null,
            'description' => $_POST['description'],
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
    }
}
