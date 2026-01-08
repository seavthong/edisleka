<?php
require_once __DIR__ . '/auth.php';

$user = current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Auth Demo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="page">
        <section class="card stack">
            <div class="stack">
                <h1 class="title">Full-stack Login & Register</h1>
                <p class="subtitle">PHP + MySQL starter with user and admin dashboards.</p>
            </div>

            <?php if ($user): ?>
                <div class="alert success">
                    Welcome back, <?php echo htmlspecialchars($user['name']); ?>. You are logged in as
                    <strong><?php echo htmlspecialchars($user['role']); ?></strong>.
                </div>
                <div class="nav">
                    <a class="button" href="<?php echo $user['role'] === 'admin' ? 'admin.php' : 'user.php'; ?>">Go to dashboard</a>
                    <a class="button secondary" href="logout.php">Log out</a>
                </div>
            <?php else: ?>
                <div class="grid two">
                    <div class="card stack">
                        <h2 class="title">New here?</h2>
                        <p class="note">Create an account and choose a role.</p>
                        <a class="button" href="register.php">Create account</a>
                    </div>
                    <div class="card stack">
                        <h2 class="title">Already registered?</h2>
                        <p class="note">Sign in to access your dashboard.</p>
                        <a class="button secondary" href="login.php">Sign in</a>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
