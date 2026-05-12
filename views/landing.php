<?php $title = __('welcome_title'); ?>

<style>
    .hero-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
        text-align: center;
        padding: 24px;
    }
    .landing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 32px;
        width: 100%;
        max-width: 900px;
        margin-top: 48px;
    }
    .space-card {
        padding: 40px;
        border-radius: 24px;
        background: white;
        border: 1px solid var(--md-sys-color-surface-variant);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }
    .space-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        border-color: var(--md-sys-color-primary);
    }
    .icon-container {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
    }
    .icon-admin { background: var(--md-sys-color-primary-container); color: var(--md-sys-color-primary); }
    .icon-user { background: var(--md-sys-color-secondary-container); color: var(--md-sys-color-secondary); }
</style>

<div class="hero-section">
    <div style="background: var(--md-sys-color-primary); color: white; padding: 12px 24px; border-radius: 100px; font-size: 14px; font-weight: 700; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 1px;">
        <?= __('platform_title') ?>
    </div>
    <h1 style="font-size: 48px; margin: 0; font-weight: 700; line-height: 1.2;"><?= __('simplify_requests') ?> <br><span style="color: var(--md-sys-color-primary);"><?= __('financial_needs') ?></span></h1>
    <p style="font-size: 18px; color: var(--md-sys-color-on-surface-variant); max-width: 600px; margin-top: 24px;">
        <?= __('landing_desc') ?>
    </p>

    <div class="landing-grid">
        <a href="/login/admin" class="space-card">
            <div class="icon-container icon-admin">
                <span class="material-symbols-outlined" style="font-size: 40px;">admin_panel_settings</span>
            </div>
            <h2 style="margin: 0; font-size: 24px;"><?= __('admin_space') ?></h2>
            <p style="margin: 0; font-size: 14px; color: var(--md-sys-color-on-surface-variant);"><?= __('admin_space_desc') ?></p>
            <div class="btn btn-filled" style="margin-top: 8px;"><?= __('access_admin') ?></div>
        </a>

        <a href="/login/user" class="space-card">
            <div class="icon-container icon-user">
                <span class="material-symbols-outlined" style="font-size: 40px;">person</span>
            </div>
            <h2 style="margin: 0; font-size: 24px;"><?= __('user_space') ?></h2>
            <p style="margin: 0; font-size: 14px; color: var(--md-sys-color-on-surface-variant);"><?= __('user_space_desc') ?></p>
            <div class="btn btn-outlined" style="margin-top: 8px;"><?= __('access_user_space') ?></div>
        </a>
    </div>
</div>
