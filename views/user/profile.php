<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 32px;">
        <div style="display: inline-flex; background: var(--md-sys-color-primary-container); color: var(--md-sys-color-primary); padding: 16px; border-radius: 50%; margin-bottom: 16px;">
            <span class="material-symbols-outlined" style="font-size: 48px;">account_circle</span>
        </div>
        <h1 style="margin: 0; font-size: 24px;"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h1>
        <p style="color: var(--md-sys-color-outline); margin-top: 4px;"><?= ucfirst($user['categorie']) ?> - <?= htmlspecialchars($service['libelle'] ?? 'Aucun service') ?></p>
    </div>

    <form action="/profile" method="POST">
        <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

        <div class="flex gap-16">
            <div class="form-group" style="flex: 1;">
                <label for="nom">Nom</label>
                <input disabled readonly type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($user['nom']) ?>" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label for="prenom">Prénom</label>
                <input disabled readonly type="text" id="prenom" name="prenom" class="form-control" value="<?= htmlspecialchars($user['prenom']) ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input disabled readonly type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••">
        </div>

        <div class="flex gap-16 mt-24" style="border-top: 1px solid var(--md-sys-color-surface-variant); padding-top: 24px;">
            <button type="submit" class="btn btn-filled">
                <span class="material-symbols-outlined">save</span>
                Mettre à jour mon profil
            </button>
        </div>
    </form>
</div>
