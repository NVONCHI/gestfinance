<div class="flex-between" style="margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
    <h1 style="margin: 0; font-size: 28px; color: var(--md-sys-color-primary);">Bonjour, <?= explode(' ', $_SESSION['user_name'])[0] ?> !</h1>
    <?php if ($_SESSION['user_space'] === 'user'): ?>
    <a href="/demandes/create" class="btn btn-filled">
        <span class="material-symbols-outlined">add</span>
        Nouvelle Demande
    </a>
    <?php endif; ?>
</div>

<?php if (isset($stats) && $_SESSION['user_space'] === 'admin'): ?>
<!-- Tableau de bord DG / Statistiques Globales -->
<div style="margin-bottom: 32px;">
    <h2 style="font-size: 16px; color: var(--md-sys-color-outline); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;">Aperçu Global</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        
        <div class="card" style="padding: 16px; margin: 0; display: flex; align-items: center; gap: 16px;">
            <div style="background: var(--md-sys-color-primary-container); color: var(--md-sys-color-primary); padding: 12px; border-radius: 12px;">
                <span class="material-symbols-outlined" style="font-size: 28px;">account_balance_wallet</span>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 700; color: var(--md-sys-color-primary);"><?= number_format((float)($stats['budget_consomme'] ?? 0), 0, ',', ' ') ?></div>
                <div style="font-size: 12px; color: var(--md-sys-color-outline);">FCFA Dépensés</div>
            </div>
        </div>

        <div class="card" style="padding: 16px; margin: 0; display: flex; align-items: center; gap: 16px;">
            <div style="background: #E8F5E9; color: #2E7D32; padding: 12px; border-radius: 12px;">
                <span class="material-symbols-outlined" style="font-size: 28px;">check_circle</span>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 700; color: #2E7D32;"><?= $stats['validees'] ?? 0 ?></div>
                <div style="font-size: 12px; color: var(--md-sys-color-outline);">Demandes validées</div>
            </div>
        </div>

        <div class="card" style="padding: 16px; margin: 0; display: flex; align-items: center; gap: 16px;">
            <div style="background: #FFF3E0; color: #C62828; padding: 12px; border-radius: 12px;">
                <span class="material-symbols-outlined" style="font-size: 28px;">pending_actions</span>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 700; color: #C62828;"><?= ($stats['en_attente_dir'] ?? 0) + ($stats['en_attente_dg'] ?? 0) + ($stats['en_attente_ra'] ?? 0) ?></div>
                <div style="font-size: 12px; color: var(--md-sys-color-outline);">En attente de traitement</div>
            </div>
        </div>

        <div class="card" style="padding: 16px; margin: 0; display: flex; align-items: center; gap: 16px;">
            <div style="background: var(--md-sys-color-surface-variant); color: var(--md-sys-color-on-surface-variant); padding: 12px; border-radius: 12px;">
                <span class="material-symbols-outlined" style="font-size: 28px;">list_alt</span>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 700;"><?= $stats['total_demandes'] ?? 0 ?></div>
                <div style="font-size: 12px; color: var(--md-sys-color-outline);">Demandes totales</div>
            </div>
        </div>

    </div>
</div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
    <!-- Section Mes Demandes -->
    <div class="card">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
            <span class="material-symbols-outlined" style="color: var(--md-sys-color-primary); font-size: 32px;">history</span>
            <h2 style="margin: 0; font-size: 20px;">Mes activités</h2>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <a href="/demandes" class="btn btn-outlined" style="justify-content: flex-start; width: 100%;">
                <span class="material-symbols-outlined">list_alt</span>
                Suivre mes demandes
            </a>
            <p style="font-size: 14px; color: var(--md-sys-color-on-surface-variant); padding: 0 12px;">
                Consultez l'état d'avancement de vos demandes de besoin financier en temps réel.
            </p>
        </div>
    </div>

    <!-- Section Validations (Visible selon rôle) -->
    <?php if ($_SESSION['user_category'] !== 'agent'): ?>
    <div class="card" style="border-left: 4px solid var(--md-sys-color-secondary);">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
            <span class="material-symbols-outlined" style="color: var(--md-sys-color-secondary); font-size: 32px;">fact_check</span>
            <h2 style="margin: 0; font-size: 20px;">Centre de décision</h2>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <a href="/validations" class="btn btn-filled" style="justify-content: flex-start; width: 100%; background-color: var(--md-sys-color-secondary);">
                <span class="material-symbols-outlined">rule</span>
                Demandes en attente
            </a>
            <p style="font-size: 14px; color: var(--md-sys-color-on-surface-variant); padding: 0 12px;">
                Vous avez des demandes qui nécessitent votre approbation.
            </p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Section Administration (Visible selon rôle) -->
    <?php if (in_array($_SESSION['user_category'], ['dg', 'responsable_administratif'])): ?>
    <div class="card" style="border-left: 4px solid var(--md-sys-color-outline);">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
            <span class="material-symbols-outlined" style="color: var(--md-sys-color-outline); font-size: 32px;">settings</span>
            <h2 style="margin: 0; font-size: 20px;">Pilotage</h2>
        </div>
        <nav style="display: flex; flex-direction: column; gap: 8px;">
            <a href="/admin/users" class="btn btn-text" style="justify-content: flex-start;">
                <span class="material-symbols-outlined">group</span> Gestion des Utilisateurs
            </a>
            <a href="/admin/services" class="btn btn-text" style="justify-content: flex-start;">
                <span class="material-symbols-outlined">lan</span> Configuration des Services
            </a>
        </nav>
    </div>
    <?php endif; ?>
</div>

<!-- Rappel de statut rapide (Optionnel) -->
<div class="card" style="margin-top: 24px; background: var(--md-sys-color-primary-container); border: none;">
    <div style="display: flex; align-items: center; gap: 16px; color: var(--md-sys-color-on-primary-container);">
        <span class="material-symbols-outlined" style="font-size: 40px;">info</span>
        <div>
            <div style="font-weight: 700; font-size: 16px;">Système de validation multi-niveaux</div>
            <div style="font-size: 14px; opacity: 0.8;">Toute demande suit le circuit : Directeur de Service → Direction Générale → Responsable Administratif.</div>
        </div>
    </div>
</div>
