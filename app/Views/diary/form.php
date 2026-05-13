<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h1>Dienyno pildymas</h1>
<form class="panel form-grid" method="post" action="<?= site_url('diary/' . $lesson['id']) ?>">
    <?= csrf_field() ?>
    <div><label class="form-label">Tema</label><input class="form-control" name="topic" value="<?= old('topic', $entry['topic'] ?? '') ?>"></div>
    <div><label class="form-label">Pažanga (%)</label><input class="form-control" type="number" name="progress" value="<?= old('progress', $entry['progress'] ?? 50) ?>"></div>
    <div><label class="form-label">Namų darbai patikrinti</label><select class="form-select" name="homework_checked"><option value="1" <?= old('homework_checked', $entry['homework_checked'] ?? '') == 1 ? 'selected' : '' ?>>Taip</option><option value="0" <?= old('homework_checked', $entry['homework_checked'] ?? '') == 0 ? 'selected' : '' ?>>Ne</option></select></div>
    <div class="full"><label class="form-label">Mokinio komentaras</label><textarea class="form-control" name="student_comment"><?= old('student_comment', $entry['student_comment'] ?? '') ?></textarea></div>
    <div class="full"><label class="form-label">Korepetitoriaus komentaras</label><textarea class="form-control" name="tutor_comment"><?= old('tutor_comment', $entry['tutor_comment'] ?? '') ?></textarea></div>
    <div class="full"><button class="btn btn-primary">Išsaugoti dienyną</button></div>
</form>
<?= $this->endSection() ?>
