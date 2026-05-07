<div class="card" style="max-width: 800px; margin: 0 auto;">
    <form action="/demandes/create" method="POST">
        <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

        <div class="flex gap-16">
            <div class="form-group" style="flex: 1;">
                <label>Nom du demandeur</label>
                <input type="text" class="form-control" value="<?= explode(' ', $_SESSION['user_name'])[1] ?? '' ?>" readonly disabled style="background: var(--md-sys-color-surface-variant); cursor: not-allowed;">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Prénom</label>
                <input type="text" class="form-control" value="<?= explode(' ', $_SESSION['user_name'])[0] ?? '' ?>" readonly disabled style="background: var(--md-sys-color-surface-variant); cursor: not-allowed;">
            </div>
        </div>

        <div class="form-group">
            <label for="service_id">Service bénéficiaire</label>
            <select name="service_id" id="service_id" class="form-control" required>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['id'] ?>" <?= $service['id'] == $_SESSION['service_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($service['libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fonction">Fonction occupée</label>
            <input type="text" name="fonction" id="fonction" class="form-control" placeholder="ex: Analyste Développeur" required>
        </div>
        
        <div class="form-group">
            <label for="objet">Objet précis de la demande</label>
            <textarea name="objet" id="objet" class="form-control" rows="4" placeholder="Détaillez votre besoin financier..." required></textarea>
        </div>

        <div class="form-group">
            <label for="montant">Montant estimé (FCFA)</label>
            <div style="position: relative;">
                <input type="number" name="montant" id="montant" class="form-control" step="0.01" placeholder="0.00" required style="padding-right: 60px;">
                <span style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--md-sys-color-outline); font-weight: 700;">FCFA</span>
            </div>
        </div>

        <div class="flex gap-16 mt-24" style="border-top: 1px solid var(--md-sys-color-surface-variant); padding-top: 24px;">
            <button type="submit" name="submit_action" value="soumettre" class="btn btn-filled">
                <span class="material-symbols-outlined">send</span>
                Soumettre pour validation
            </button>
            <button type="submit" name="submit_action" value="brouillon" class="btn btn-outlined">
                <span class="material-symbols-outlined">draft</span>
                Enregistrer brouillon
            </button>
            <a href="/demandes" class="btn btn-text">Annuler</a>
        </div>
    </form>
</div>
