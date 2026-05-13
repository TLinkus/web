<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $isEdit = (bool) $company; ?>
<h1><?= esc($title) ?></h1>
<form class="panel form-grid" method="post" action="<?= $isEdit ? site_url('companies/' . $company['id']) : site_url('companies') ?>">
    <?= csrf_field() ?><?php if ($isEdit): ?><input type="hidden" name="_method" value="PUT"><?php endif; ?>
    <?php foreach (['name' => 'Pavadinimas', 'code' => 'Kodas', 'email' => 'El. paštas', 'phone' => 'Telefonas', 'city' => 'Miestas', 'address' => 'Adresas'] as $field => $label): ?>
        <div><label class="form-label"><?= $label ?></label><input class="form-control" name="<?= $field ?>" value="<?= old($field, $company[$field] ?? '') ?>"></div>
    <?php endforeach; ?>
    <div><label class="form-label">Statusas</label><select class="form-select" name="status"><option value="active" <?= old('status', $company['status'] ?? '') === 'active' ? 'selected' : '' ?>>Aktyvi</option><option value="inactive" <?= old('status', $company['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Neaktyvi</option></select></div>
    <div class="full"><label class="form-label">Pastabos</label><textarea class="form-control" name="notes"><?= old('notes', $company['notes'] ?? '') ?></textarea></div>
    <div class="full"><button class="btn btn-primary">Išsaugoti</button></div>
</form>
<?= $this->endSection() ?>
