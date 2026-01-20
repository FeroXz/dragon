<?php if ($newsItem === null): ?>
    <h1>News nicht gefunden</h1>
    <div class="card">Der angeforderte News-Beitrag ist nicht verfügbar.</div>
    <p><a href="/?page=news">Zurück zur Übersicht</a></p>
<?php else: ?>
    <h1><?= htmlspecialchars($newsItem['title']) ?></h1>
    <div class="card">
        <small><?= htmlspecialchars($newsItem['published_at']) ?></small>
        <p><?= nl2br(htmlspecialchars($newsItem['content'])) ?></p>
    </div>
    <p><a href="/?page=news">Zurück zur Übersicht</a></p>
<?php endif; ?>
