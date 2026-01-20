<h1>Seitenliste</h1>
<?php if (empty($pages)): ?>
    <div class="card muted">Noch keine Seiten vorhanden.</div>
<?php else: ?>
    <div class="card-grid">
        <?php foreach ($pages as $page): ?>
            <div class="card stack">
                <strong><?= htmlspecialchars($page['title']) ?></strong>
                <a href="/?page=page&slug=<?= htmlspecialchars($page['slug']) ?>">Seite öffnen</a>
                <div class="muted"><?= nl2br(htmlspecialchars($page['content'])) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
