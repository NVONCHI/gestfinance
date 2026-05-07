<div class="flex-between" style="margin-bottom: 24px;">
    <div></div>
    <a href="/admin/users/create" class="btn btn-filled">
        <span class="material-symbols-outlined">add</span>
        Nouvel Utilisateur
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nom & Prénom</th>
                <th>Email</th>
                <th>Catégorie</th>
                <th>Statut</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td style="font-weight: 500;"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></td>
                <td style="color: var(--md-sys-color-on-surface-variant);"><?= htmlspecialchars($user['email']) ?></td>
                <td><span style="font-size: 13px;"><?= htmlspecialchars($user['categorie']) ?></span></td>
                <td>
                    <?php if ($user['is_active']): ?>
                        <span style="color: #2E7D32; background: #E8F5E9; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 700;">Actif</span>
                    <?php else: ?>
                        <span style="color: #C62828; background: #FFEBEE; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 700;">Inactif</span>
                    <?php endif; ?>
                </td>
                <td style="text-align: right;">
                    <a href="/admin/users/edit/<?= $user['id'] ?>" class="btn btn-text" title="Modifier">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                    <a href="/admin/users/delete/<?= $user['id'] ?>" class="btn btn-text btn-danger" title="Supprimer" onclick="return confirm('Supprimer cet utilisateur ?')">
                        <span class="material-symbols-outlined">delete</span>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
