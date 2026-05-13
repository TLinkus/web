<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="panel"><h1><?= esc($userItem['name']) ?></h1><p><?= esc($userItem['email']) ?> · <?= esc($userItem['phone']) ?></p><p><span class="badge text-bg-primary"><?= esc(lt_role($userItem['role'])) ?></span></p><a class="btn btn-primary" href="<?= site_url('users/' . $userItem['id'] . '/edit') ?>">Redaguoti</a></div>
<?= $this->endSection() ?>
