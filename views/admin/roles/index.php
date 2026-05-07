<div class="flex-between" style="margin-bottom: 24px;">
    <div></div>
    <a href="/admin/roles/create" class="btn btn-filled">
        <span class="material-symbols-outlined">add</span>
        Nouveau Rôle
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Code</th>
                <th>Description</th>
                <th>Statut</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $role): ?>
            <tr>
                <td style="font-weight: 500;"><?= htmlspecialchars($role['libelle']) ?></td>
                <td><code style="background: var(--md-sys-color-secondary-container); color: var(--md-sys-color-on-secondary-container); padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 12px;"><?= htmlspecialchars($role['code']) ?></code></td>
                <td style="color: var(--md-sys-color-on-surface-variant); font-size: 14px;"><?= htmlspecialchars(substr($role['description'] ?? '', 0, 60)) ?>...</td>
                <td>
                    <?php if ($role['is_active']): ?>
                        <span style="color: #2E7D32; background: #E8F5E9; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 700;">Actif</span>
                    <?php else: ?>
                        <span style="color: #C62828; background: #FFEBEE; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 700;">Inactif</span>
                    <?php endif; ?>
                </td>
                <td style="text-align: right;">
                    <a href="/admin/roles/edit/<?= $role['id'] ?>" class="btn btn-text" title="Modifier">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                    <a href="/admin/roles/delete/<?= $role['id'] ?>" class="btn btn-text btn-danger" title="Supprimer" onclick="return confirm('Supprimer ce rôle ?')">
                        <span class="material-symbols-outlined">delete</span>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
