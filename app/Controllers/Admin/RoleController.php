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
        RoleMiddleware::handle([CategorieUtilisateur::DG->value, CategorieUtilisateur::RESPONSABLE_ADMINISTRATIF->value,CategorieUtilisateur::SUPER_ADMIN->value]);
        $this->roleModel = new Role();
    }

    public function index(): void
    {
        $roles = $this->roleModel->allWithParents();
        $tree = $this->buildTree($roles);

        $this->render('admin/roles/index', [
            'roles' => $roles,
            'tree' => $tree,
            'title' => 'Gestion des Rôles (Hiérarchie)',
            'breadcrumbs' => [['label' => 'Accueil', 'url' => '/'], ['label' => 'Rôles', 'url' => '/admin/roles']]
        ]);
    }

    private function buildTree(array $elements, $parentId = null): array 
    {
        $branch = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    public function create(): void
    {
        $this->render('admin/roles/create', [
            'roles' => $this->roleModel->all(),
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
            'roles' => $this->roleModel->all(),
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
            'parent_id' => !empty($_POST['parent_id']) ? (int) $_POST['parent_id'] : null,
            'libelle' => $_POST['libelle'],
            'code' => $_POST['code'],
            'description' => $_POST['description'],
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
    }
}
