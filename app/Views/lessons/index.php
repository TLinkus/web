<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-title"><h1>Pamokos</h1><a class="btn btn-primary" href="<?= site_url('lessons/new') ?>">Pridėti</a></div>
<div class="panel table-responsive"><table class="table align-middle"><thead><tr><th>Data</th><th>Dalykas</th><th>Korepetitorius</th><th>Mokinys</th><th>Statusas</th><th></th></tr></thead><tbody>
<?php foreach ($lessons as $lesson): ?><tr><td><?= esc($lesson['starts_at']) ?></td><td><?= esc($lesson['subject']) ?></td><td><?= esc($lesson['tutor_name']) ?></td><td><?= esc($lesson['student_name']) ?></td><td><?= esc(lt_status($lesson['status'])) ?></td><td class="actions"><a href="<?= site_url('lessons/' . $lesson['id']) ?>">Peržiūrėti</a><a href="<?= site_url('lessons/' . $lesson['id'] . '/edit') ?>">Redaguoti</a><a href="<?= site_url('diary/' . $lesson['id'] . '/edit') ?>">Dienynas</a></td></tr><?php endforeach; ?>
</tbody></table><?= $pager->links() ?></div>
<?= $this->endSection() ?>
