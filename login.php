<?php
require_once __DIR__ . '/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter your email and password.';
    } else {
        $stmt = $mysqli->prepare('SELECT id, name, email, password_hash, role FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
            ];

            header('Location: ' . ($user['role'] === 'admin' ? 'admin.php' : 'user.php'));
            exit;
        }

        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="page">
        <section class="card stack">
            <div>
                <h1 class="title">Sign in</h1>
                <p class="note">Access your user or admin dashboard.</p>
            </div>

            <?php if ($error): ?>
                <div class="alert"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form class="stack" method="POST" action="login.php">
                <div class="stack">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                <div class="stack">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button class="button" type="submit">Sign in</button>
                <p class="note">Need an account? <a class="button secondary" href="register.php">Register</a></p>
            </form>
        </section>
    </main>
</body>
</html>
