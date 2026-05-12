<?php use App\Core\AuthHelper; ?>

<div class="flex-between" style="margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
    <h1 style="margin: 0; font-size: 28px; color: var(--md-sys-color-primary);"><?= __('hello_user', ['name' => explode(' ', AuthHelper::getUserName())[0]]) ?></h1>
    <?php if (AuthHelper::getSpace() === 'user'): ?>
    <a href="/demandes/create" class="btn btn-filled">
        <span class="material-symbols-outlined">add</span>
        <?= __('new_request') ?>
    </a>
    <?php endif; ?>
</div>

<!-- 1. Section Statistiques Globales (DG / RA dans l'espace Admin) -->
<?php if (isset($global_stats) && AuthHelper::isAdminSpace()): ?>
<div style="margin-bottom: 32px;">
    <h2 style="font-size: 14px; color: var(--md-sys-color-outline); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; font-weight: 700;"><?= __('org_steering') ?></h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
        <div class="card" style="padding: 20px; border-left: 4px solid var(--md-sys-color-primary);">
            <div style="font-size: 12px; color: var(--md-sys-color-outline); margin-bottom: 4px;"><?= __('consumed_budget') ?></div>
            <div style="font-size: 24px; font-weight: 700; color: var(--md-sys-color-primary);"><?= number_format((float)$global_stats['budget_consomme'], 0, ',', ' ') ?> FCFA</div>
        </div>
        <div class="card" style="padding: 20px; border-left: 4px solid #2E7D32;">
            <div style="font-size: 12px; color: var(--md-sys-color-outline); margin-bottom: 4px;"><?= __('finalized_requests') ?></div>
            <div style="font-size: 24px; font-weight: 700; color: #2E7D32;"><?= $global_stats['validees'] ?></div>
        </div>
        <div class="card" style="padding: 20px; border-left: 4px solid #F57C00;">
            <div style="font-size: 12px; color: var(--md-sys-color-outline); margin-bottom: 4px;"><?= __('pending_decision') ?></div>
            <div style="font-size: 24px; font-weight: 700; color: #F57C00;"><?= $global_stats['en_attente_dg'] + $global_stats['en_attente_ra'] ?></div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- 2. Section Statistiques de Service (Responsable de Service) -->
<?php if (isset($service_stats)): ?>
<div style="margin-bottom: 32px;">
    <h2 style="font-size: 14px; color: var(--md-sys-color-outline); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; font-weight: 700;"><?= __('service_overview') ?></h2>
    <div class="card" style="display: flex; align-items: center; gap: 24px; background: var(--md-sys-color-secondary-container); border: none;">
        <div style="background: white; padding: 12px; border-radius: 12px; color: var(--md-sys-color-secondary);">
            <span class="material-symbols-outlined" style="font-size: 32px;">groups</span>
        </div>
        <div>
            <div style="font-size: 18px; font-weight: 700; color: var(--md-sys-color-on-secondary-container);">
                <?= __('requests_waiting_signature', ['count' => $service_stats['en_attente_validation']]) ?>
            </div>
            <a href="/validations" style="color: var(--md-sys-color-primary); font-size: 14px; font-weight: 500; text-decoration: underline;"><?= __('access_validations') ?></a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- 3. Section Statistiques Personnelles (Tous les utilisateurs) -->
<div style="margin-bottom: 32px;">
    <h2 style="font-size: 14px; color: var(--md-sys-color-outline); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; font-weight: 700;"><?= __('my_personal_requests') ?></h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <div class="card" style="padding: 16px; text-align: center;">
            <div style="font-size: 28px; font-weight: 700; color: var(--md-sys-color-primary);"><?= $user_stats['total'] ?></div>
            <div style="font-size: 12px; color: var(--md-sys-color-outline);"><?= __('total_created') ?></div>
        </div>
        <div class="card" style="padding: 16px; text-align: center;">
            <div style="font-size: 28px; font-weight: 700; color: #F57C00;"><?= $user_stats['en_cours'] ?></div>
            <div style="font-size: 12px; color: var(--md-sys-color-outline);"><?= __('pending_validation') ?></div>
        </div>
        <div class="card" style="padding: 16px; text-align: center;">
            <div style="font-size: 28px; font-weight: 700; color: #2E7D32;"><?= $user_stats['finalisees'] ?></div>
            <div style="font-size: 12px; color: var(--md-sys-color-outline);"><?= __('registered') ?></div>
        </div>
        <div class="card" style="padding: 16px; text-align: center;">
            <div style="font-size: 28px; font-weight: 700; color: #C62828;"><?= $user_stats['rejetees'] ?></div>
            <div style="font-size: 12px; color: var(--md-sys-color-outline);"><?= __('rejected') ?></div>
        </div>
    </div>
</div>

<!-- 4. Raccourcis Rapides -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
    <div class="card">
        <h3 style="margin-top: 0; font-size: 18px;"><?= __('profile_management') ?></h3>
        <p style="font-size: 14px; color: var(--md-sys-color-on-surface-variant);"><?= __('profile_management_desc') ?></p>
        <a href="/profile" class="btn btn-outlined" style="width: 100%;">
            <span class="material-symbols-outlined">person</span>
            <?= __('profile') ?>
        </a>
    </div>
    
    <div class="card">
        <h3 style="margin-top: 0; font-size: 18px;"><?= __('history') ?></h3>
        <p style="font-size: 14px; color: var(--md-sys-color-on-surface-variant);"><?= __('history_desc') ?></p>
        <a href="/demandes" class="btn btn-outlined" style="width: 100%;">
            <span class="material-symbols-outlined">list_alt</span>
            <?= __('see_my_requests') ?>
        </a>
    </div>
</div>
