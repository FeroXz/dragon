<h1>News</h1>
<?php if (empty($news)): ?>
    <div class="card">Noch keine News vorhanden.</div>
<?php else: ?>
    <?php foreach ($news as $item): ?>
        <div class="card">
            <strong><?= htmlspecialchars($item['title']) ?></strong>
            <p><?= nl2br(htmlspecialchars($item['teaser'])) ?></p>
            <small><?= htmlspecialchars($item['published_at']) ?></small>
            <div>
                <a href="/?page=news&id=<?= (int) $item['id'] ?>">Zur Detailansicht</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
