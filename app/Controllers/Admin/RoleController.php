<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Role;
use App\Middleware\RoleMiddleware;
use App\Enums\CategorieUtilisateur;

class RoleController extends Controller
{
    private Role $roleModel;

    public function __construct()
    {
        RoleMiddleware::handle([CategorieUtilisateur::DG->value, CategorieUtilisateur::RESPONSABLE_ADMINISTRATIF->value]);
        $this->roleModel = new Role();
    }

    public function index(): void
    {
        $this->render('admin/roles/index', [
            'roles' => $this->roleModel->all(),
            'title' => 'Gestion des Rôles',
            'breadcrumbs' => [['label' => 'Accueil', 'url' => '/'], ['label' => 'Rôles', 'url' => '/admin/roles']]
        ]);
    }

    public function create(): void
    {
        $this->render('admin/roles/create', [
            'title' => 'Nouveau Rôle',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Rôles', 'url' => '/admin/roles'],
                ['label' => 'Nouveau', 'url' => '/admin/roles/create']
            ]
        ]);
    }

    public function store(): void
    {
        $data = $this->getFormData();
        if ($this->roleModel->create($data)) {
            $_SESSION['flash_success'] = "Rôle créé.";
            $this->redirect('/admin/roles');
        } else {
            $_SESSION['flash_error'] = "Erreur.";
            $this->redirect('/admin/roles/create');
        }
    }

    public function edit(int $id): void
    {
        $role = $this->roleModel->find($id);
        if (!$role) $this->redirect('/admin/roles');

        $this->render('admin/roles/edit', [
            'role' => $role,
            'title' => 'Modifier le Rôle',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Rôles', 'url' => '/admin/roles'],
                ['label' => 'Modifier', 'url' => '#']
            ]
        ]);
    }

    public function update(int $id): void
    {
        $data = $this->getFormData();
        if ($this->roleModel->update($id, $data)) {
            $_SESSION['flash_success'] = "Rôle mis à jour.";
            $this->redirect('/admin/roles');
        } else {
            $this->redirect("/admin/roles/edit/$id");
        }
    }

    public function delete(int $id): void
    {
        $this->roleModel->delete($id);
        $_SESSION['flash_success'] = "Rôle supprimé.";
        $this->redirect('/admin/roles');
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
