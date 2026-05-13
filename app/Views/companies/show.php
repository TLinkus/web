<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="panel"><h1><?= esc($company['name']) ?></h1><p><?= esc($company['city']) ?>, <?= esc($company['address']) ?></p><p><?= esc($company['email']) ?> · <?= esc($company['phone']) ?></p><a class="btn btn-primary" href="<?= site_url('companies/' . $company['id'] . '/edit') ?>">Redaguoti</a></div>
<?= $this->endSection() ?>
