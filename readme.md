# GestFinance — Système de Gestion des Besoins Financiers

GestFinance est une application web de gestion des besoins financiers développée en PHP 8.3 pur, respectant les normes PSR et utilisant Material Design 3 pour l'interface utilisateur.

## 🚀 Fonctionnalités

- **Authentification sécurisée** : Connexion par email/mot de passe avec sessions régénérées.
- **Gestion Administrative** : CRUD complet pour les utilisateurs, services et rôles.
- **Workflow de Validation** : 
    - Création de demandes (Agent)
    - Validation multi-niveaux (Directeur -> DG -> Responsable Administratif)
    - Suivi du statut en temps réel avec badges colorés.
- **Génération de Fiche PDF** : Fiche officielle générée automatiquement après validation finale.
- **Sécurité** : Protection CSRF, Middleware d'authentification et de rôles, Limitation du taux de requêtes (Rate Limiting).

## 🛠 Stack Technique

- **Backend** : PHP 8.4 (Compatible 8.3+), Architecture MVC pure.
- **Base de données** : MySQL 8+ / MariaDB via PDO.
- **Frontend** : Esthétique Material Design 3 (via CSS personnalisé), Vanilla JS (ES2022+).
- **Standards** : PSR-1, PSR-2, PSR-4, PSR-7, PSR-12.
- **Dépendances** : Dompdf (PDF), PHP Dotenv (Environnement).

## 📋 Prérequis

- PHP 8.3 ou supérieur
- MySQL / MariaDB
- Composer

## 🔧 Installation

1. **Cloner le projet** :
   ```bash
   git clone <repository-url>
   cd gestfinance
   ```

2. **Installer les dépendances** :
   ```bash
   composer install
   ```

3. **Configuration** :
   - Copiez le fichier `.env.example` vers `.env`.
   - Modifiez les variables `DB_*` pour correspondre à votre base de données locale.
   - Créez la base de données spécifiée dans votre `.env`.

4. **Migration de la base de données** :
   Importez le fichier `migrations/001_create_tables.sql` dans votre base de données.

5. **Lancer l'application** :
   Utilisez le serveur intégré de PHP pour le développement :
   ```bash
   php -S localhost:8000 -t public
   ```

## 👥 Comptes de Test (Exemple)

Vous pouvez insérer un administrateur par défaut via SQL :
```sql
INSERT INTO users (nom, prenom, email, password_hash, categorie, is_active) 
VALUES ('Admin', 'Gest', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'dg', 1);
-- Mot de passe : password
```

## 📂 Structure du Projet

- `app/` : Cœur de l'application (Controllers, Models, Services, Middleware, Enums, Core).
- `config/` : Fichiers de configuration.
- `public/` : Point d'entrée unique (`index.php`) et assets.
- `routes/` : Définition des routes web.
- `views/` : Templates HTML et Layouts.
- `migrations/` : Scripts SQL de création des tables.
