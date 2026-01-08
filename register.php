<?php
require_once __DIR__ . '/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if ($name === '' || $email === '' || $password === '') {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (!in_array($role, ['user', 'admin'], true)) {
        $error = 'Invalid role selection.';
    } else {
        $stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'Email already exists. Please log in.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $mysqli->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)');
            $insert->bind_param('ssss', $name, $email, $hash, $role);

            if ($insert->execute()) {
                $success = 'Registration successful. You can now log in.';
            } else {
                $error = 'Unable to create account. Please try again.';
            }
            $insert->close();
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="page">
        <section class="card stack">
            <div>
                <h1 class="title">Create your account</h1>
                <p class="note">Register as a user or admin to access your dashboard.</p>
            </div>

            <?php if ($error): ?>
                <div class="alert"><?php echo htmlspecialchars($error); ?></div>
            <?php elseif ($success): ?>
                <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form class="stack" method="POST" action="register.php">
                <div class="grid two">
                    <div class="stack">
                        <label for="name">Full name</label>
                        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                    </div>
                    <div class="stack">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                </div>
                <div class="grid two">
                    <div class="stack">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="stack">
                        <label for="role">Select role</label>
                        <select id="role" name="role" required>
                            <option value="user" <?php echo (($_POST['role'] ?? 'user') === 'user') ? 'selected' : ''; ?>>User</option>
                            <option value="admin" <?php echo (($_POST['role'] ?? '') === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                </div>
                <button class="button" type="submit">Create account</button>
                <p class="note">Already registered? <a class="button secondary" href="login.php">Sign in</a></p>
            </form>
        </section>
    </main>
</body>
</html>
