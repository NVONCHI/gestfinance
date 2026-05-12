<?php $title = __('pending_validations_title'); ?>

<?php if (empty($demandes)): ?>
    <div class="card" style="text-align: center; padding: 48px; color: var(--md-sys-color-on-surface-variant);">
        <span class="material-symbols-outlined" style="font-size: 48px; display: block; margin-bottom: 12px; opacity: 0.3;">fact_check</span>
        <?= __('no_pending_validation') ?>
    </div>
<?php else: ?>
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <?php foreach ($demandes as $demande): ?>
        <div class="card" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 32px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 300px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <span class="material-symbols-outlined" style="color: var(--md-sys-color-primary); font-size: 32px;">account_circle</span>
                        <div>
                            <h3 style="margin: 0; font-size: 18px;"><?= htmlspecialchars($demande['prenom'] . ' ' . $demande['nom']) ?></h3>
                            <span style="font-size: 13px; color: var(--md-sys-color-outline);"><?= __('received_on') ?> <?= date('d/m/Y H:i', strtotime($demande['created_at'])) ?></span>
                        </div>
                    </div>
                    
                    <p style="margin-bottom: 8px;"><strong><?= __('object_label') ?></strong> <?= htmlspecialchars($demande['objet']) ?></p>
                    <p style="font-size: 20px; color: var(--md-sys-color-primary); margin-top: 12px;">
                        <strong><?= __('amount_label') ?></strong> <span style="font-weight: 700;"><?= number_format((float)$demande['montant'], 2, ',', ' ') ?> FCFA</span>
                    </p>
                </div>
                
                <div style="width: 1px; background: var(--md-sys-color-surface-variant); align-self: stretch;"></div>

                <form action="/validations/<?= $demande['id'] ?>/approve" method="POST" style="flex: 1; min-width: 300px;">
                    <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">
                    
                    <div class="form-group">
                        <label for="commentaire_<?= $demande['id'] ?>"><?= __('decision_comment') ?></label>
                        <textarea id="commentaire_<?= $demande['id'] ?>" name="commentaire" class="form-control" rows="3" placeholder="<?= __('decision_placeholder') ?>" required></textarea>
                    </div>
                    
                    <div class="flex gap-16">
                        <button type="submit" class="btn btn-filled" style="flex: 2;">
                            <span class="material-symbols-outlined">check_circle</span>
                            <?= __('approve_request') ?>
                        </button>
                        <button type="submit" formaction="/validations/<?= $demande['id'] ?>/reject" class="btn btn-outlined btn-danger" style="flex: 1; border-color: var(--md-sys-color-error);">
                            <span class="material-symbols-outlined">cancel</span>
                            <?= __('reject_request') ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
