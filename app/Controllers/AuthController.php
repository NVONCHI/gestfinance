<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Middleware\CsrfMiddleware;

/**
 * Contrôleur pour l'authentification.
 */
class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Affiche la landing page.
     */
    public function landing(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }
        $this->render('landing');
    }

    /**
     * Affiche la page de connexion admin.
     */
    public function showAdminLogin(): void
    {
        $this->render('auth/login_admin', ['title' => 'Connexion Administrateur']);
    }

    /**
     * Affiche la page de connexion utilisateur.
     */
    public function showUserLogin(): void
    {
        $this->render('auth/login_user', ['title' => 'Connexion Utilisateur']);
    }

    /**
     * Gère la soumission du formulaire de connexion.
     */
    public function login(): void
    {
        try {
            CsrfMiddleware::handle();

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $space = $_POST['space'] ?? 'user'; // 'admin' ou 'user'

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                
                // Vérifier si l'utilisateur a le droit d'accéder à l'espace admin
                if ($space === 'admin' && !in_array($user['categorie'], ['dg', 'responsable_administratif'])) {
                    $_SESSION['flash_error'] = "Accès refusé : vous n'avez pas les droits d'administration.";
                    $this->redirect('/login/admin');
                }

                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['prenom'] . ' ' . $user['nom'];
                $_SESSION['user_category'] = $user['categorie'];
                $_SESSION['service_id'] = $user['service_id'];
                $_SESSION['user_space'] = $space;

                $_SESSION['flash_success'] = "Bienvenue, {$_SESSION['user_name']} !";
                $this->redirect('/dashboard');
            } else {
                $_SESSION['flash_error'] = "Identifiants invalides.";
                $this->redirect($space === 'admin' ? '/login/admin' : '/login/user');
            }
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = "Erreur : " . $e->getMessage();
            $this->redirect('/');
        }
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout(): void
    {
        session_destroy();
        session_start();
        $_SESSION['flash_success'] = "Vous avez été déconnecté.";
        $this->redirect('/');
    }
}
