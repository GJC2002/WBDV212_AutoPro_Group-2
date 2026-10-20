<?php
require_once __DIR__ . '/auth.php';
$returnUrl = auth_return_url($_GET['return'] ?? null);
$loginError = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Arial, sans-serif;
}

body {
  background-color: #0b1d3a;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.login-container {
  width: 100%;
  max-width: 400px;
  padding: 20px;
}

.login-card {
  background: #ffffff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  text-align: center;
}

.login-card h2 {
  color: #0b1d3a;
  margin-bottom: 5px;
}

.login-card p {
  color: #666;
  font-size: 14px;
  margin-bottom: 20px;
}

.input-group {
  text-align: left;
  margin-bottom: 15px;
}

.input-group label {
  display: block;
  font-size: 14px;
  color: #333;
  margin-bottom: 5px;
  font-weight: bold;
}

.input-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
}

.password-guidance {
  margin: 6px 0 0 !important;
  font-size: 12px !important;
  line-height: 1.4;
}

.show-password {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  margin-top: 8px;
  color: #333;
  font-size: 13px;
  cursor: pointer;
}

.show-password input {
  width: auto;
}

.btn-login {
  width: 100%;
  padding: 12px;
  background-color: #008000;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
}

.btn-login:hover {
  background-color: #006400;
}

.form-footer {
  margin-top: 15px;
  font-size: 14px;
}

.form-footer a {
  color: #0b1d3a;
  text-decoration: none;
  font-weight: bold;
}
</style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2>Login</h2>
            <p>Sign in to continue</p>

            <?php if ($loginError !== ''): ?>
                <p role="alert"><?= htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <form method="post" action="login.php">
                <input type="hidden" name="return" value="<?= htmlspecialchars($returnUrl, ENT_QUOTES, 'UTF-8') ?>">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Type your email" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Type your password"
                           minlength="8" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}"
                           title="Use at least 8 characters with uppercase and lowercase letters, a number, and a symbol." required>
                    <p class="password-guidance">At least 8 characters, including uppercase and lowercase letters, a number, and a symbol.</p>
                    <label class="show-password" for="show-password">
                        <input type="checkbox" id="show-password" aria-controls="password">
                        Show password
                    </label>
                </div>

                <button type="submit" class="btn-login">Log in</button>
            </form>

            <div class="form-footer">
                <p>Don't have an account? <a href="Registration.php?return=<?= rawurlencode($returnUrl) ?>">Sign up</a></p>
            </div>
             
            <div class="form-footer">
                <p><a href="forgot_password.php">Forgot your password?</a></p>
            </div>

            <div class="form-footer">
                <p><a href="index.php">Back to Home</a></p>
            </div>

        </div>
    </div>
    <script>
        document.getElementById('show-password').addEventListener('change', function () {
            document.getElementById('password').type = this.checked ? 'text' : 'password';
        });
    </script>
</body>
</html>