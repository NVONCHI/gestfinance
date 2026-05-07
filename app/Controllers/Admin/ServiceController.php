<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Service;
use App\Middleware\RoleMiddleware;
use App\Enums\CategorieUtilisateur;

class ServiceController extends Controller
{
    private Service $serviceModel;

    public function __construct()
    {
        RoleMiddleware::handle([CategorieUtilisateur::DG->value, CategorieUtilisateur::RESPONSABLE_ADMINISTRATIF->value]);
        $this->serviceModel = new Service();
    }

    public function index(): void
    {
        $this->render('admin/services/index', [
            'services' => $this->serviceModel->all(),
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
            $_SESSION['flash_error'] = "Erreur.";
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
            'description' => $_POST['description'],
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
    }
}
