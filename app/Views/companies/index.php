<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-title"><h1>Įmonės</h1><a class="btn btn-primary" href="<?= site_url('companies/new') ?>">Pridėti</a></div>
<div class="panel table-responsive"><table class="table"><thead><tr><th>Pavadinimas</th><th>Kodas</th><th>Miestas</th><th>Statusas</th><th></th></tr></thead><tbody>
<?php foreach ($companies as $company): ?><tr><td><?= esc($company['name']) ?></td><td><?= esc($company['code']) ?></td><td><?= esc($company['city']) ?></td><td><?= esc(lt_status($company['status'])) ?></td><td class="actions"><a href="<?= site_url('companies/' . $company['id']) ?>">Peržiūrėti</a><a href="<?= site_url('companies/' . $company['id'] . '/edit') ?>">Redaguoti</a></td></tr><?php endforeach; ?>
</tbody></table><?= $pager->links() ?></div>
<?= $this->endSection() ?>
