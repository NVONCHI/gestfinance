<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="/admin/services/create" method="POST">
        <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

        <div class="form-group">
            <label for="libelle">Libellé du Service</label>
            <input type="text" id="libelle" name="libelle" class="form-control" placeholder="ex: Direction des Systèmes d'Information" required>
        </div>

        <div class="form-group">
            <label for="code">Code (unique)</label>
            <input type="text" id="code" name="code" class="form-control" placeholder="ex: DSI" required>
        </div>

        <div class="form-group">
            <label for="responsable_id">Responsable du Service</label>
            <select id="responsable_id" name="responsable_id" class="form-control">
                <option value="">-- Sélectionner un responsable --</option>
                <?php 
                $db = \App\Core\Database::getInstance();
                $users = $db->query("SELECT id, nom, prenom FROM users WHERE categorie = 'responsable_directeur' ORDER BY nom ASC")->fetchAll();
                foreach ($users as $u): ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['prenom'] . ' ' . $u['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description détaillée</label>
            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Objectifs et responsabilités du service..."></textarea>
        </div>

        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 8px 0;">
                <input type="checkbox" name="is_active" checked style="width: 20px; height: 20px; accent-color: var(--md-sys-color-primary);">
                <span style="font-size: 16px;">Service actif</span>
            </label>
        </div>

        <div class="flex gap-16 mt-24" style="border-top: 1px solid var(--md-sys-color-surface-variant); padding-top: 24px;">
            <button type="submit" class="btn btn-filled">
                <span class="material-symbols-outlined">save</span>
                Créer le service
            </button>
            <a href="/admin/services" class="btn btn-outlined">Annuler</a>
        </div>
    </form>
</div>
