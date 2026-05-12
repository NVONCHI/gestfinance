<?php $title = "Connexion Administrateur - GestFinance"; ?>

<div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
    <div class="card" style="width: 100%; max-width: 400px; border: none; box-shadow: 0 8px 32px rgba(0,97,164,0.15);">
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="display: inline-flex; background: var(--md-sys-color-primary-container); color: var(--md-sys-color-primary); padding: 12px; border-radius: 16px; margin-bottom: 16px;">
                <span class="material-symbols-outlined" style="font-size: 32px;">admin_panel_settings</span>
            </div>
            <h2 style="margin: 0; color: var(--md-sys-color-primary);">Espace Admin</h2>
            <p style="font-size: 14px; color: var(--md-sys-color-outline);">Identifiez-vous pour gérer le système</p>
        </div>
        
        <form action="/login" method="POST">
            <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">
            <input type="hidden" name="space" value="admin">
            
            <div class="form-group">
                <label for="email">Email Administrateur</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="admin@exemple.com" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn btn-filled" style="width: 100%; margin-top: 16px; height: 48px; font-size: 16px;">
                Se connecter à l'admin
            </button>
            
            <div style="text-align: center; margin-top: 24px;">
                <a href="/" class="btn btn-text" style="font-size: 13px;">
                    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                    Retour à l'accueil
                </a>
            </div>
        </form>
    </div>
</div>
