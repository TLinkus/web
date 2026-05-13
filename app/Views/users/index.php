<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-title"><h1>Vartotojai</h1><a class="btn btn-primary" href="<?= site_url('users/new') ?>">Pridėti</a></div>
<div class="panel table-responsive"><table class="table align-middle"><thead><tr><th>Vardas</th><th>El. paštas</th><th>Rolė</th><th>Statusas</th><th></th></tr></thead><tbody>
<?php foreach ($users as $userItem): ?><tr><td><?= esc($userItem['name']) ?></td><td><?= esc($userItem['email']) ?></td><td><span class="badge text-bg-secondary"><?= esc(lt_role($userItem['role'])) ?></span></td><td><?= esc(lt_status($userItem['status'])) ?></td><td class="actions"><a href="<?= site_url('users/' . $userItem['id']) ?>">Peržiūrėti</a><a href="<?= site_url('users/' . $userItem['id'] . '/edit') ?>">Redaguoti</a></td></tr><?php endforeach; ?>
</tbody></table><?= $pager->links() ?></div>
<?= $this->endSection() ?>
