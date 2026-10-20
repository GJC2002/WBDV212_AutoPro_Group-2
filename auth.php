<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function is_logged_in(): bool
{
    return isset($_SESSION['user_email']) && filter_var($_SESSION['user_email'], FILTER_VALIDATE_EMAIL) !== false;
}

function is_strong_password(string $password): bool
{
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $password) === 1;
}

function auth_return_url(mixed $returnUrl): string
{
    if (!is_string($returnUrl) || !preg_match('/^[A-Za-z0-9_-]+\.php$/', $returnUrl)) {
        return 'index.php';
    }

    $reservedPages = ['Sign.php', 'Registration.php', 'login.php', 'logout.php', 'registrationLogic.php'];
    return in_array($returnUrl, $reservedPages, true) ? 'index.php' : $returnUrl;
}

function require_login(string $returnUrl): void
{
    if (!is_logged_in()) {
        header('Location: Sign.php?return=' . rawurlencode(auth_return_url($returnUrl)));
        exit;
    }
}

function render_auth_link(bool $compact = false): void
{
    $label = $compact ? '' : 'Account';
    if (is_logged_in()) {
        echo '<li><a class="auth-link" href="account.php" aria-label="Account"><i class="fas fa-user" aria-hidden="true"></i>'
            . $label . '</a></li>';
        echo '<li><a class="auth-link" href="logout.php">Logout</a></li>';
        return;
    }

    echo '<li><a class="auth-link" href="Sign.php" aria-label="Login" title="Login"><i class="fas fa-user" aria-hidden="true"></i>'
        . ($compact ? '' : 'Login') . '</a></li>';
}
