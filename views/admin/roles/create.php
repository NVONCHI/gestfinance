<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="/admin/roles/create" method="POST">
        <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

        <div class="form-group">
            <label for="libelle">Libellé du Rôle</label>
            <input type="text" id="libelle" name="libelle" class="form-control" placeholder="ex: Directeur Technique" required>
        </div>

        <div class="form-group">
            <label for="code">Code métier</label>
            <input type="text" id="code" name="code" class="form-control" placeholder="ex: DIR_TECH" required>
        </div>

        <div class="form-group">
            <label for="description">Description du rôle</label>
            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Responsabilités associées à ce rôle..."></textarea>
        </div>

        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 8px 0;">
                <input type="checkbox" name="is_active" checked style="width: 20px; height: 20px; accent-color: var(--md-sys-color-primary);">
                <span style="font-size: 16px;">Rôle actif</span>
            </label>
        </div>

        <div class="flex gap-16 mt-24" style="border-top: 1px solid var(--md-sys-color-surface-variant); padding-top: 24px;">
            <button type="submit" class="btn btn-filled">
                <span class="material-symbols-outlined">save</span>
                Créer le rôle
            </button>
            <a href="/admin/roles" class="btn btn-outlined">Annuler</a>
        </div>
    </form>
</div>
