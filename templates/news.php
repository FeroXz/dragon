<h1>News</h1>
<?php if (empty($news)): ?>
    <div class="card">Noch keine News vorhanden.</div>
<?php else: ?>
    <?php foreach ($news as $item): ?>
        <div class="card">
            <strong><?= htmlspecialchars($item['title']) ?></strong>
            <div><?= nl2br(htmlspecialchars($item['body'])) ?></div>
            <small><?= htmlspecialchars($item['published_at']) ?></small>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
