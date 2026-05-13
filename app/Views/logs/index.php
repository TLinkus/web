<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h1>Veiksmų žurnalas</h1>
<div class="panel table-responsive"><table class="table"><thead><tr><th>Laikas</th><th>Klasė</th><th>Metodas</th><th>Veiksmas</th><th>Žinutė</th></tr></thead><tbody>
<?php foreach ($logs as $log): ?><tr><td><?= esc($log['created_at']) ?></td><td><?= esc($log['class_name']) ?></td><td><?= esc($log['method_name']) ?></td><td><?= esc($log['action']) ?></td><td><?= esc($log['message']) ?></td></tr><?php endforeach; ?>
</tbody></table><?= $pager->links() ?></div>
<?= $this->endSection() ?>
