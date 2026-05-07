<?php $title = "Tableau de Bord"; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
    <?php if (in_array($_SESSION['user_category'], ['dg', 'responsable_administratif'])): ?>
    <div class="card">
        <h2 style="font-size: 20px; color: var(--md-sys-color-primary); margin-top: 0; margin-bottom: 24px;">Administration</h2>
        <nav style="display: flex; flex-direction: column; gap: 12px;">
            <a href="/admin/users" class="btn btn-outlined" style="justify-content: flex-start; width: 100%;">
                <span class="material-symbols-outlined">group</span> Gestion des Utilisateurs
            </a>
            <a href="/admin/services" class="btn btn-outlined" style="justify-content: flex-start; width: 100%;">
                <span class="material-symbols-outlined">lan</span> Gestion des Services
            </a>
            <a href="/admin/roles" class="btn btn-outlined" style="justify-content: flex-start; width: 100%;">
                <span class="material-symbols-outlined">badge</span> Gestion des Rôles
            </a>
        </nav>
    </div>
    <?php endif; ?>

    <div class="card">
        <h2 style="font-size: 20px; color: var(--md-sys-color-primary); margin-top: 0; margin-bottom: 24px;">Mes Demandes</h2>
        <nav style="display: flex; flex-direction: column; gap: 12px;">
            <a href="/demandes/create" class="btn btn-filled" style="justify-content: flex-start; width: 100%;">
                <span class="material-symbols-outlined">add</span> Nouvelle Demande
            </a>
            <a href="/demandes" class="btn btn-outlined" style="justify-content: flex-start; width: 100%;">
                <span class="material-symbols-outlined">list</span> Suivre mes demandes
            </a>
        </nav>
    </div>

    <?php if ($_SESSION['user_category'] !== 'agent'): ?>
    <div class="card">
        <h2 style="font-size: 20px; color: var(--md-sys-color-primary); margin-top: 0; margin-bottom: 24px;">Validations</h2>
        <nav style="display: flex; flex-direction: column; gap: 12px;">
            <a href="/validations" class="btn btn-filled" style="justify-content: flex-start; width: 100%; background-color: var(--md-sys-color-secondary);">
                <span class="material-symbols-outlined">rule</span> Demandes à valider
            </a>
        </nav>
    </div>
    <?php endif; ?>
</div>
