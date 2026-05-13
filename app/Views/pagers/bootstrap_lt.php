<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<nav class="pager-nav" aria-label="Puslapiu navigacija">
    <ul class="pagination pagination-sm mb-0">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="Ankstesnis puslapis">Ankstesnis</a>
            </li>
        <?php else : ?>
            <li class="page-item disabled"><span class="page-link">Ankstesnis</span></li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>" <?= $link['active'] ? 'aria-current="page"' : '' ?>>
                    <?= esc($link['title']) ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="Kitas puslapis">Kitas</a>
            </li>
        <?php else : ?>
            <li class="page-item disabled"><span class="page-link">Kitas</span></li>
        <?php endif ?>
    </ul>
</nav>
