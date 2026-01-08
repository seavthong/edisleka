<?php
require_once __DIR__ . '/auth.php';

require_login();
$user = current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="page">
        <section class="card stack">
            <div class="stack">
                <span class="chip">User portal</span>
                <h1 class="title">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
                <p class="subtitle">You are logged in as a standard user.</p>
            </div>
            <div class="grid two">
                <div class="card stack">
                    <h2 class="title">Profile summary</h2>
                    <p class="note"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p class="note"><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                </div>
                <div class="card stack">
                    <h2 class="title">Next steps</h2>
                    <p class="note">This space can contain user-specific features and content.</p>
                    <a class="button secondary" href="index.php">Back to home</a>
                </div>
            </div>
            <div class="nav">
                <?php if ($user['role'] === 'admin'): ?>
                    <a class="button" href="admin.php">Go to admin</a>
                <?php endif; ?>
                <a class="button secondary" href="logout.php">Log out</a>
            </div>
        </section>
    </main>
</body>
</html>
