<?php
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (!is_strong_password($password)) {
        $error = 'Password must be at least 8 characters and include uppercase and lowercase letters, a number, and a symbol.';
    } else {
        session_regenerate_id(true);
        $_SESSION['user_email'] = $email;
        if (!isset($_SESSION['user']) || strcasecmp($_SESSION['user']['email'] ?? '', $email) !== 0) {
            $_SESSION['user'] = ['email' => $email];
        }
        header('Location: ' . auth_return_url($_POST['return'] ?? null));
        exit;
    }

    $_SESSION['login_error'] = $error;
    header('Location: Sign.php?return=' . rawurlencode(auth_return_url($_POST['return'] ?? null)));
    exit;
}

header('Location: Sign.php');
exit;

?>