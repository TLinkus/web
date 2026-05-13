<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="auth-panel mx-auto">
    <h1 class="h3 mb-3">Registracija</h1>
    <form method="post" action="<?= site_url('register') ?>" class="card card-body">
        <?= csrf_field() ?>
        <label class="form-label">Vardas ir pavardė</label>
        <input class="form-control mb-3" name="name" value="<?= old('name') ?>" required>
        <label class="form-label">El. paštas</label>
        <input class="form-control mb-3" type="email" name="email" value="<?= old('email') ?>" required>
        <label class="form-label">Telefonas</label>
        <input class="form-control mb-3" name="phone" value="<?= old('phone') ?>">
        <label class="form-label">Įmonė</label>
        <select class="form-select mb-3" name="company_id" required>
            <?php foreach ($companies as $company): ?><option value="<?= $company['id'] ?>" <?= old('company_id') == $company['id'] ? 'selected' : '' ?>><?= esc($company['name']) ?></option><?php endforeach; ?>
        </select>
        <label class="form-label">Rolė</label>
        <select class="form-select mb-3" name="role"><option value="student">Mokinys</option><option value="tutor">Korepetitorius</option></select>
        <label class="form-label">Slaptažodis</label>
        <input class="form-control mb-3" type="password" name="password" required>
        <label class="form-label">Pakartokite slaptažodį</label>
        <input class="form-control mb-3" type="password" name="password_confirm" required>
        <button class="btn btn-primary">Registruotis</button>
    </form>
</div>
<?= $this->endSection() ?>
