<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $isEdit = (bool) $lesson; $startsValue = old('starts_at', isset($lesson['starts_at']) ? date('Y-m-d\TH:i', strtotime($lesson['starts_at'])) : ''); ?>
<h1><?= esc($title) ?></h1>
<form class="panel form-grid" method="post" action="<?= $isEdit ? site_url('lessons/' . $lesson['id']) : site_url('lessons') ?>">
    <?= csrf_field() ?><?php if ($isEdit): ?><input type="hidden" name="_method" value="PUT"><?php endif; ?>
    <input type="hidden" name="company_id" value="<?= esc($companyId ?: old('company_id', $lesson['company_id'] ?? '')) ?>">
    <div><label class="form-label">Korepetitorius</label><select class="form-select" name="tutor_id"><?php foreach ($tutors as $tutor): ?><option value="<?= $tutor['id'] ?>" <?= old('tutor_id', $lesson['tutor_id'] ?? '') == $tutor['id'] ? 'selected' : '' ?>><?= esc($tutor['name']) ?></option><?php endforeach; ?></select></div>
    <div><label class="form-label">Mokinys</label><select class="form-select" name="student_id"><?php foreach ($students as $student): ?><option value="<?= $student['id'] ?>" <?= old('student_id', $lesson['student_id'] ?? '') == $student['id'] ? 'selected' : '' ?>><?= esc($student['name']) ?></option><?php endforeach; ?></select></div>
    <div><label class="form-label">Dalykas</label><input class="form-control" name="subject" value="<?= old('subject', $lesson['subject'] ?? '') ?>"></div>
    <div><label class="form-label">Pradžia</label><input class="form-control" type="datetime-local" name="starts_at" value="<?= esc($startsValue) ?>"></div>
    <div><label class="form-label">Trukmė minutėmis</label><input class="form-control" type="number" name="duration_minutes" value="<?= old('duration_minutes', $lesson['duration_minutes'] ?? 60) ?>"></div>
    <div><label class="form-label">Kaina</label><input class="form-control" type="number" step="0.01" name="price" value="<?= old('price', $lesson['price'] ?? 25) ?>"></div>
    <div><label class="form-label">Vieta</label><input class="form-control" name="location" value="<?= old('location', $lesson['location'] ?? 'Nuotoliniu būdu') ?>"></div>
    <div><label class="form-label">Statusas</label><select class="form-select" name="status"><?php foreach (['planned' => 'Planuojama', 'completed' => 'Įvyko', 'cancelled' => 'Atšaukta'] as $value => $label): ?><option value="<?= $value ?>" <?= old('status', $lesson['status'] ?? '') === $value ? 'selected' : '' ?>><?= $label ?></option><?php endforeach; ?></select></div>
    <div class="full"><label class="form-label">Namų darbai</label><textarea class="form-control" name="homework"><?= old('homework', $lesson['homework'] ?? '') ?></textarea></div>
    <div class="full"><button class="btn btn-primary">Išsaugoti</button></div>
</form>
<?= $this->endSection() ?>
