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
     * Affiche la page de connexion.
     */
    public function showLogin(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $this->render('auth/login');
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

            if (empty($email) || empty($password)) {
                $_SESSION['flash_error'] = "Veuillez remplir tous les champs.";
                $this->redirect('/login');
            }

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['prenom'] . ' ' . $user['nom'];
                $_SESSION['user_category'] = $user['categorie'];
                $_SESSION['service_id'] = $user['service_id'];

                $_SESSION['flash_success'] = "Bienvenue, {$_SESSION['user_name']} !";
                $this->redirect('/');
            } else {
                $_SESSION['flash_error'] = "Identifiants invalides ou compte inactif.";
                $this->redirect('/login');
            }
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = "Erreur : " . $e->getMessage();
            $this->redirect('/login');
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
        $this->redirect('/login');
    }
}
