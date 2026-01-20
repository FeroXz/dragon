<h1>Seitenliste</h1>
<?php if (empty($pages)): ?>
    <div class="card">Noch keine Seiten vorhanden.</div>
<?php else: ?>
    <?php foreach ($pages as $page): ?>
        <div class="card">
            <strong><?= htmlspecialchars($page['title']) ?></strong>
            <div><?= nl2br(htmlspecialchars($page['content'])) ?></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
