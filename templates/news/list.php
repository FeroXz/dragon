<h1>News</h1>
<?php if (empty($news)): ?>
    <div class="card muted">Noch keine News vorhanden.</div>
<?php else: ?>
    <div class="card-grid">
        <?php foreach ($news as $item): ?>
            <div class="card stack">
                <strong><?= htmlspecialchars($item['title']) ?></strong>
                <p><?= nl2br(htmlspecialchars($item['teaser'])) ?></p>
                <small class="meta"><?= htmlspecialchars($item['published_at']) ?></small>
                <div>
                    <a class="button button-secondary" href="/?page=news&id=<?= (int) $item['id'] ?>">Zur Detailansicht</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
