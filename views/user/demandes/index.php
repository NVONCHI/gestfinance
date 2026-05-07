<div class="flex-between" style="margin-bottom: 24px;">
    <div></div>
    <a href="/demandes/create" class="btn btn-filled">
        <span class="material-symbols-outlined">add</span>
        Nouvelle Demande
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Objet</th>
                <th>Montant</th>
                <th>Statut</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($demandes)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 48px; color: var(--md-sys-color-on-surface-variant);">
                        <span class="material-symbols-outlined" style="font-size: 48px; display: block; margin-bottom: 12px; opacity: 0.3;">description</span>
                        Aucune demande enregistrée pour le moment.
                    </td>
                </tr>
            <?php endif; ?>
            <?php foreach ($demandes as $demande): ?>
            <?php $status = \App\Enums\StatutDemande::from($demande['statut']); ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($demande['created_at'])) ?></td>
                <td style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($demande['objet']) ?></td>
                <td style="font-weight: 700; color: var(--md-sys-color-primary);"><?= number_format((float)$demande['montant'], 2, ',', ' ') ?> FCFA</td>
                <td>
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 700; background-color: <?= $status->color() ?>; color: white;">
                        <?= $status->label() ?>
                    </span>
                </td>
                <td style="text-align: right;">
                    <a href="/demandes/<?= $demande['id'] ?>" class="btn btn-text" title="Voir les détails">
                        <span class="material-symbols-outlined">visibility</span>
                    </a>
                    <?php if ($demande['statut'] === 'enregistre'): ?>
                        <a href="/demandes/<?= $demande['id'] ?>/pdf" target="_blank" class="btn btn-text" title="Télécharger le PDF" style="color: #D32F2F;">
                            <span class="material-symbols-outlined">picture_as_pdf</span>
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
