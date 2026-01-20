<h1>Login</h1>
<div class="card">
    <form method="post" action="/?page=login">
        <div>
            <label for="username">Benutzername</label><br>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Passwort</label><br>
            <input type="password" id="password" name="password" required>
        </div>
        <?php if (!empty($error)) : ?>
            <p style="color: #b00020;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <button type="submit">Anmelden</button>
    </form>
</div>
<div class="card">
    <p>Standard-Admin: <strong>admin</strong> / <strong>admin123</strong></p>
</div>
