<h1>Login</h1>
<div class="card">
    <form method="post" action="/?page=login">
        <div class="stack">
            <label for="username">Benutzername</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="stack">
            <label for="password">Passwort</label>
            <input type="password" id="password" name="password" required>
        </div>
        <?php if (!empty($error)) : ?>
            <p class="alert"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <div class="form-actions">
            <button type="submit">Anmelden</button>
        </div>
    </form>
</div>
<div class="card notice">
    <p>Standard-Admin: <strong>admin</strong> / <strong>admin123</strong></p>
</div>
