<?php
require_once __DIR__ . '/auth.php';

require_admin();
$user = current_user();

$recentUsers = [];
$result = $mysqli->query('SELECT name, email, role, created_at FROM users ORDER BY created_at DESC LIMIT 5');
if ($result) {
    $recentUsers = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="page">
        <section class="card stack">
            <div class="stack">
                <span class="chip">Admin control</span>
                <h1 class="title">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
                <p class="subtitle">Manage users and monitor access below.</p>
            </div>
            <div class="grid two">
                <div class="card stack">
                    <h2 class="title">Admin profile</h2>
                    <p class="note"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p class="note"><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                </div>
                <div class="card stack">
                    <h2 class="title">Recent sign-ups</h2>
                    <?php if ($recentUsers): ?>
                        <div class="stack">
                            <?php foreach ($recentUsers as $recent): ?>
                                <div class="note">
                                    <strong><?php echo htmlspecialchars($recent['name']); ?></strong>
                                    (<?php echo htmlspecialchars($recent['role']); ?>) — <?php echo htmlspecialchars($recent['email']); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="note">No users found yet.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="nav">
                <a class="button secondary" href="index.php">Back to home</a>
                <a class="button secondary" href="logout.php">Log out</a>
            </div>
        </section>
    </main>
</body>
</html>
