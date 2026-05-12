<?php $title = __('user_login_title'); ?>

<div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
    <div class="card" style="width: 100%; max-width: 400px; border: none; box-shadow: 0 8px 32px rgba(83,95,112,0.15);">
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="display: inline-flex; background: var(--md-sys-color-secondary-container); color: var(--md-sys-color-secondary); padding: 12px; border-radius: 16px; margin-bottom: 16px;">
                <span class="material-symbols-outlined" style="font-size: 32px;">person</span>
            </div>
            <h2 style="margin: 0; color: var(--md-sys-color-secondary);"><?= __('user_space') ?></h2>
            <p style="font-size: 14px; color: var(--md-sys-color-outline);"><?= __('user_login_desc') ?></p>
        </div>
        
        <form action="/login" method="POST">
            <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">
            <input type="hidden" name="space" value="user">
            
            <div class="form-group">
                <label for="email"><?= __('your_email') ?></label>
                <input type="email" id="email" name="email" class="form-control" placeholder="nom@exemple.com" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password"><?= __('password') ?></label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn btn-filled" style="width: 100%; margin-top: 16px; height: 48px; font-size: 16px; background-color: var(--md-sys-color-secondary);">
                <?= __('login_btn') ?>
            </button>
            
            <div style="text-align: center; margin-top: 24px;">
                <a href="/" class="btn btn-text" style="font-size: 13px; color: var(--md-sys-color-secondary);">
                    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                    <?= __('back_to_home') ?>
                </a>
            </div>
        </form>
    </div>
</div>
