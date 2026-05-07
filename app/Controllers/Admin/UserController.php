<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Role;
use App\Middleware\RoleMiddleware;
use App\Enums\CategorieUtilisateur;

/**
 * Contrôleur pour la gestion des utilisateurs par l'administrateur.
 */
class UserController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        RoleMiddleware::handle([CategorieUtilisateur::DG->value, CategorieUtilisateur::RESPONSABLE_ADMINISTRATIF->value]);
        $this->userModel = new User();
    }

    public function index(): void
    {
        $users = $this->userModel->all();
        $this->render('admin/users/index', [
            'users' => $users,
            'title' => 'Gestion des Utilisateurs',
            'breadcrumbs' => [['label' => 'Accueil', 'url' => '/'], ['label' => 'Utilisateurs', 'url' => '/admin/users']]
        ]);
    }

    public function create(): void
    {
        $this->render('admin/users/create', [
            'services' => (new Service())->all(),
            'roles' => (new Role())->all(),
            'categories' => CategorieUtilisateur::cases(),
            'title' => 'Créer un utilisateur',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Utilisateurs', 'url' => '/admin/users'],
                ['label' => 'Nouveau', 'url' => '/admin/users/create']
            ]
        ]);
    }

    public function store(): void
    {
        $data = $this->getFormData();
        if ($this->userModel->create($data)) {
            $_SESSION['flash_success'] = "Utilisateur créé avec succès.";
            $this->redirect('/admin/users');
        } else {
            $_SESSION['flash_error'] = "Erreur lors de la création.";
            $this->redirect('/admin/users/create');
        }
    }

    public function edit(int $id): void
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            $_SESSION['flash_error'] = "Utilisateur introuvable.";
            $this->redirect('/admin/users');
        }

        $this->render('admin/users/edit', [
            'user' => $user,
            'services' => (new Service())->all(),
            'roles' => (new Role())->all(),
            'categories' => CategorieUtilisateur::cases(),
            'title' => 'Modifier l\'utilisateur',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => '/'],
                ['label' => 'Utilisateurs', 'url' => '/admin/users'],
                ['label' => 'Modifier', 'url' => "#"]
            ]
        ]);
    }

    public function update(int $id): void
    {
        $data = $this->getFormData();
        if (empty($data['password'])) {
            unset($data['password']);
        }

        if ($this->userModel->update($id, $data)) {
            $_SESSION['flash_success'] = "Utilisateur mis à jour.";
            $this->redirect('/admin/users');
        } else {
            $_SESSION['flash_error'] = "Erreur lors de la mise à jour.";
            $this->redirect("/admin/users/edit/$id");
        }
    }

    public function delete(int $id): void
    {
        if ($this->userModel->delete($id)) {
            $_SESSION['flash_success'] = "Utilisateur supprimé.";
        } else {
            $_SESSION['flash_error'] = "Erreur lors de la suppression.";
        }
        $this->redirect('/admin/users');
    }

    private function getFormData(): array
    {
        return [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'email' => $_POST['email'],
            'password' => $_POST['password'] ?? null,
            'service_id' => $_POST['service_id'] ?: null,
            'role_id' => $_POST['role_id'] ?: null,
            'categorie' => $_POST['categorie'],
            'niveau_validation' => (int) $_POST['niveau_validation'],
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
    }
}
