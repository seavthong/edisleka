<?php
require_once __DIR__ . '/db.php';

function require_login(): void
{
    if (empty($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
}

function require_admin(): void
{
    require_login();
    if ($_SESSION['user']['role'] !== 'admin') {
        header('Location: user.php');
        exit;
    }
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}
