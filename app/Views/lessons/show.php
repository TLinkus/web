<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="panel">
    <h1><?= esc($lesson['subject']) ?></h1>
    <p><?= esc($lesson['starts_at']) ?> · <?= esc($lesson['duration_minutes']) ?> min. · <?= esc($lesson['location']) ?></p>
    <p>Korepetitorius: <?= esc($lesson['tutor_name']) ?> · Mokinys: <?= esc($lesson['student_name']) ?></p>
    <p>Statusas: <span class="badge text-bg-secondary"><?= esc(lt_status($lesson['status'])) ?></span></p>
    <a class="btn btn-primary" href="<?= site_url('diary/' . $lesson['id'] . '/edit') ?>">Pildyti dienyną</a>
</div>
<?php if ($entry): ?><div class="panel mt-4"><h2 class="h5">Dienynas</h2><p><strong>Tema:</strong> <?= esc($entry['topic']) ?></p><p><strong>Pažanga:</strong> <?= esc($entry['progress']) ?>%</p><p><?= esc($entry['tutor_comment']) ?></p></div><?php endif; ?>
<?= $this->endSection() ?>
