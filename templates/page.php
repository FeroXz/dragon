<?php if ($page === null): ?>
    <div class="card stack">
        <h1>Seite nicht gefunden</h1>
        <p class="muted">Die angeforderte Seite existiert nicht.</p>
        <a class="button button-secondary" href="/?page=pages">Zur Seitenübersicht</a>
    </div>
<?php else: ?>
    <div class="card stack">
        <h1><?= htmlspecialchars($page['title']) ?></h1>
        <div><?= nl2br(htmlspecialchars($page['content'])) ?></div>
    </div>
<?php endif; ?>
