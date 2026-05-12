<div class="flex-between" style="margin-bottom: 24px;">
    <div></div>
    <a href="/admin/services/create" class="btn btn-filled">
        <span class="material-symbols-outlined">add</span>
        Nouveau Service
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Responsable</th>
                <th>Code</th>
                <th>Statut</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
            <tr>
                <td style="font-weight: 500;"><?= htmlspecialchars($service['libelle']) ?></td>
                <td>
                    <?php if ($service['resp_nom']): ?>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="material-symbols-outlined" style="font-size: 18px; color: var(--md-sys-color-primary);">account_circle</span>
                            <span style="font-size: 14px;"><?= htmlspecialchars($service['resp_prenom'] . ' ' . $service['resp_nom']) ?></span>
                        </div>
                    <?php else: ?>
                        <span style="color: var(--md-sys-color-outline); font-style: italic; font-size: 13px;">Non assigné</span>
                    <?php endif; ?>
                </td>
                <td><code style="background: var(--md-sys-color-secondary-container); color: var(--md-sys-color-on-secondary-container); padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 12px;"><?= htmlspecialchars($service['code']) ?></code></td>
                <td>
                    <?php if ($service['is_active']): ?>
                        <span style="color: #2E7D32; background: #E8F5E9; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 700;">Actif</span>
                    <?php else: ?>
                        <span style="color: #C62828; background: #FFEBEE; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 700;">Inactif</span>
                    <?php endif; ?>
                </td>
                <td style="text-align: right;">
                    <a href="/admin/services/edit/<?= $service['id'] ?>" class="btn btn-text" title="Modifier">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                    <a href="/admin/services/delete/<?= $service['id'] ?>" class="btn btn-text btn-danger" title="Supprimer" onclick="return confirm('Supprimer ce service ?')">
                        <span class="material-symbols-outlined">delete</span>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
