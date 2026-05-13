<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $isEdit = (bool) $userItem; ?>
<h1><?= esc($title) ?></h1>
<form class="panel form-grid" method="post" action="<?= $isEdit ? site_url('users/' . $userItem['id']) : site_url('users') ?>">
    <?= csrf_field() ?><?php if ($isEdit): ?><input type="hidden" name="_method" value="PUT"><?php endif; ?>
    <div><label class="form-label">Vardas</label><input class="form-control" name="name" value="<?= old('name', $userItem['name'] ?? '') ?>"></div>
    <div><label class="form-label">El. paštas</label><input class="form-control" type="email" name="email" value="<?= old('email', $userItem['email'] ?? '') ?>"></div>
    <div><label class="form-label">Telefonas</label><input class="form-control" name="phone" value="<?= old('phone', $userItem['phone'] ?? '') ?>"></div>
    <?php if (! $isEdit): ?><div><label class="form-label">Laikinas slaptažodis</label><input class="form-control" name="password" value="Pamoka123"></div><?php endif; ?>
    <div><label class="form-label">Įmonė</label><select class="form-select" name="company_id"><option value="">Be įmonės</option><?php foreach ($companies as $company): ?><option value="<?= $company['id'] ?>" <?= old('company_id', $userItem['company_id'] ?? '') == $company['id'] ? 'selected' : '' ?>><?= esc($company['name']) ?></option><?php endforeach; ?></select></div>
    <div><label class="form-label">Rolė</label><select class="form-select" name="role"><?php foreach (['system_admin', 'company_admin', 'tutor', 'student'] as $role): ?><option value="<?= $role ?>" <?= old('role', $userItem['role'] ?? '') === $role ? 'selected' : '' ?>><?= esc(lt_role($role)) ?></option><?php endforeach; ?></select></div>
    <div><label class="form-label">Statusas</label><select class="form-select" name="status"><option value="active" <?= old('status', $userItem['status'] ?? '') === 'active' ? 'selected' : '' ?>>Aktyvus</option><option value="inactive" <?= old('status', $userItem['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Neaktyvus</option></select></div>
    <div class="full"><button class="btn btn-primary">Išsaugoti</button></div>
</form>
<?= $this->endSection() ?>
