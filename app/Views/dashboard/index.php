<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-title">
    <div>
        <h1>Valdymo skydelis</h1>
        <p class="text-muted mb-0">Pamokų kalendorius, būsimos pamokos ir nepilni dienynai.</p>
    </div>
    <a class="btn btn-primary" href="<?= site_url('lessons/new') ?>">Nauja pamoka</a>
</div>

<?php if (session('role') === 'system_admin'): ?>
    <section class="mb-4">
        <h2 class="h5">Pasirinkite įmonę redagavimui</h2>
        <div class="company-switcher">
            <?php foreach ($companies as $company): ?>
                <a class="btn <?= session('active_company_id') == $company['id'] ? 'btn-primary' : 'btn-outline-primary' ?> btn-sm" href="<?= site_url('companies/switch/' . $company['id']) ?>"><?= esc($company['name']) ?></a>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<div class="dashboard-grid">
    <section class="panel calendar-panel">
        <div class="calendar-toolbar">
            <a class="btn btn-outline-primary btn-sm" href="<?= site_url('dashboard?month=' . $previousMonth) ?>">Ankstesnis</a>
            <h2 class="h4 mb-0"><?= esc($calendarTitle) ?></h2>
            <a class="btn btn-outline-primary btn-sm" href="<?= site_url('dashboard?month=' . $nextMonth) ?>">Kitas</a>
        </div>

        <div class="calendar-weekdays">
            <span>Pir</span>
            <span>Ant</span>
            <span>Tre</span>
            <span>Ket</span>
            <span>Pen</span>
            <span>Šeš</span>
            <span>Sek</span>
        </div>

        <div class="calendar-month">
            <?php foreach ($calendarWeeks as $week): ?>
                <?php foreach ($week as $day): ?>
                    <div class="calendar-day <?= $day['isCurrentMonth'] ? '' : 'muted' ?> <?= $day['isToday'] ? 'today' : '' ?>">
                        <div class="calendar-day-number"><?= esc($day['day']) ?></div>
                        <div class="calendar-events">
                            <?php foreach (array_slice($day['lessons'], 0, 3) as $lesson): ?>
                                <a class="calendar-event <?= esc($lesson['status']) ?>" href="<?= site_url('lessons/' . $lesson['id']) ?>">
                                    <span><?= esc(date('H:i', strtotime($lesson['starts_at']))) ?></span>
                                    <strong><?= esc($lesson['subject']) ?></strong>
                                    <small><?= esc($lesson['student_name']) ?></small>
                                </a>
                            <?php endforeach; ?>
                            <?php if (count($day['lessons']) > 3): ?>
                                <a class="calendar-more" href="<?= site_url('lessons') ?>">+<?= count($day['lessons']) - 3 ?> daugiau</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <aside class="dashboard-side">
        <section class="panel">
            <h2 class="h5">Būsimos pamokos</h2>
            <?php foreach ($upcoming as $lesson): ?>
                <a class="list-row" href="<?= site_url('lessons/' . $lesson['id']) ?>">
                    <span><?= esc($lesson['subject']) ?></span>
                    <small><?= esc($lesson['starts_at']) ?> · <?= esc($lesson['student_name']) ?></small>
                </a>
            <?php endforeach; ?>
            <?php if (! $upcoming): ?><p class="text-muted">Būsimų pamokų nėra.</p><?php endif; ?>
        </section>

        <section class="panel mt-4">
            <h2 class="h5">Nesupildyti dienynai</h2>
            <?php foreach ($unfinished as $lesson): ?>
                <a class="list-row warning" href="<?= site_url('diary/' . $lesson['id'] . '/edit') ?>">
                    <span><?= esc($lesson['subject']) ?></span>
                    <small><?= esc($lesson['starts_at']) ?> · pildyti dienyną</small>
                </a>
            <?php endforeach; ?>
            <?php if (! $unfinished): ?><p class="text-muted">Visi dienynai supildyti.</p><?php endif; ?>
        </section>
    </aside>
</div>

<?php if (in_array(session('role'), ['system_admin', 'company_admin'], true)): ?>
    <section class="panel mt-4">
        <h2 class="h5">Įmonės rolių grandinė</h2>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Vardas</th><th>Rolė</th><th>El. paštas</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($companyUsers as $item): ?>
                    <tr>
                        <td><?= esc($item['name']) ?></td>
                        <td><span class="badge text-bg-secondary"><?= esc(lt_role($item['role'])) ?></span></td>
                        <td><?= esc($item['email']) ?></td>
                        <td><a class="btn btn-sm btn-outline-primary" href="<?= site_url('users/' . $item['id']) ?>">Atidaryti</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php endif; ?>
<?= $this->endSection() ?>
