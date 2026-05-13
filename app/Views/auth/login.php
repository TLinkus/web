<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="auth-panel mx-auto">
    <h1 class="h3 mb-3">Prisijungimas</h1>
    <form method="post" action="<?= site_url('login') ?>" class="card card-body">
        <?= csrf_field() ?>
        <label class="form-label">El. paštas</label>
        <input class="form-control mb-3" type="email" name="email" value="<?= old('email') ?>" required>
        <label class="form-label">Slaptažodis</label>
        <input class="form-control mb-3" type="password" name="password" required>
        <button class="btn btn-primary">Prisijungti</button>
    </form>
    <p class="text-muted small mt-3">Demo: sysadmin@example.test / Pamoka123</p>
</div>
<?= $this->endSection() ?>
