<!doctype html>
<html lang="lt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Korepetitorių sistema') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/app.css') ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="<?= site_url('dashboard') ?>">Pamokų dienynas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <?php if (session('user_id')): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('lessons') ?>">Pamokos</a></li>
                    <?php if (in_array(session('role'), ['system_admin', 'company_admin'], true)): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('users') ?>">Vartotojai</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('logs') ?>">Žurnalas</a></li>
                    <?php endif; ?>
                    <?php if (session('role') === 'system_admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('companies') ?>">Įmonės</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <?php if (session('user_id')): ?>
                    <span class="navbar-text small"><?= esc(session('name')) ?> · <?= esc(lt_role(session('role'))) ?></span>
                    <form method="post" action="<?= site_url('logout') ?>"><?= csrf_field() ?><button class="btn btn-light btn-sm">Atsijungti</button></form>
                <?php else: ?>
                    <a class="btn btn-light btn-sm" href="<?= site_url('login') ?>">Prisijungti</a>
                    <a class="btn btn-outline-light btn-sm" href="<?= site_url('register') ?>">Registruotis</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<main class="container py-4">
    <?php if (session('success')): ?><div class="alert alert-success"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session('error')): ?><div class="alert alert-danger"><?= esc(session('error')) ?></div><?php endif; ?>
    <?php if (session('errors')): ?>
        <div class="alert alert-danger"><strong>Patikrinkite laukus:</strong><ul class="mb-0"><?php foreach (session('errors') as $field => $error): ?><li><?= esc($field) ?>: <?= esc($error) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <?= $this->renderSection('content') ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
