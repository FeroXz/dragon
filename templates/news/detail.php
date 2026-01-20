<?php if ($newsItem === null): ?>
    <h1>News nicht gefunden</h1>
    <div class="card">Der angeforderte News-Beitrag ist nicht verfügbar.</div>
    <p><a class="button button-secondary" href="/?page=news">Zurück zur Übersicht</a></p>
<?php else: ?>
    <div class="page-header">
        <h1><?= htmlspecialchars($newsItem['title']) ?></h1>
        <a class="button button-secondary" href="/?page=news">Zurück zur Übersicht</a>
    </div>
    <div class="card stack">
        <small class="meta"><?= htmlspecialchars($newsItem['published_at']) ?></small>
        <p><?= nl2br(htmlspecialchars($newsItem['content'])) ?></p>
    </div>
<?php endif; ?>
