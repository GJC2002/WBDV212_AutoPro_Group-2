<?php
require_once __DIR__ . '/auth.php';
require_login('account.php');

$user = $_SESSION['user'] ?? ['email' => $_SESSION['user_email']];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Account - Auto Pro</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .account-card { max-width: 680px; margin: 40px auto 80px; padding: 32px; background: #fff; border-radius: 10px; box-shadow: 0 4px 18px rgba(0,0,0,.15); }
        .account-card h1 { margin-bottom: 24px; color: #0b1d3a; }
        .account-details { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; }
        .account-details div { padding: 12px; background: #f4f6f8; border-radius: 6px; }
        .account-details strong { display: block; margin-bottom: 5px; color: #0b1d3a; }
        .account-actions { display: flex; gap: 16px; margin-top: 24px; }
    </style>
</head>
<body class="page-account">
    <div class="nav">
        <img src="./images/companylogo.jpg" alt="Auto Pro Logo" height="100" width="200" style="border-radius: 100%" class="companylogo">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="About.php">About</a></li>
            <li><a href="Products.php">Products</a></li>
            <li><a href="Services.php">Services</a></li>
            <li><a href="Contact.php">Contact</a></li>
            <?php render_auth_link(true); ?>
            <li><a href="cart.php"><i class="fas fa-shopping-cart"></i><span class="cart-badge" id="cart-count" style="font-family: Arial, Helvetica, sans-serif;">0</span></a></li>
        </ul>
        <button class="nav-toggle" id="navToggle" aria-label="Open navigation menu">☰</button>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <aside class="sidebar" id="sidebar">
        <button class="sidebar-close" id="sidebarClose" aria-label="Close navigation menu">×</button>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="About.php">About</a></li>
                <li><a href="Products.php">Products</a></li>
                <li><a href="Services.php">Services</a></li>
                <li><a href="Contact.php">Contact</a></li>
                <?php render_auth_link(); ?>
                <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
            </ul>
        </nav>
    </aside>
    <main class="account-card">
        <h1>My Account</h1>
        <div class="account-details">
            <?php
            $accountFields = [
                'name' => 'Name',
                'email' => 'Email',
                'bday' => 'Birthday',
                'contact' => 'Contact Number',
                'region' => 'Region',
                'state' => 'State / Province',
                'city' => 'City',
                'barangay' => 'Barangay',
                'postal_code' => 'Postal Code',
            ];
            foreach ($accountFields as $field => $label):
                $value = $user[$field] ?? ($field === 'email' ? $_SESSION['user_email'] : '');
                if ($value === '') {
                    continue;
                }
            ?>
                <div><strong><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></strong><?= htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endforeach; ?>
        </div>
        <div class="account-actions">
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </main>
    <script src="https://kit.fontawesome.com/f50125bc94.js" crossorigin="anonymous"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const navToggle = document.getElementById('navToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const cart = JSON.parse(localStorage.getItem('cart')) || {};
        const cartCount = Object.values(cart).reduce((sum, item) => sum + (Number(item.quantity) || 0), 0);
        const cartBadge = document.getElementById('cart-count');

        if (cartCount > 0) {
            cartBadge.textContent = cartCount;
        } else {
            cartBadge.style.display = 'none';
        }

        function closeSidebar() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        }

        navToggle.addEventListener('click', () => {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
        });
        sidebarClose.addEventListener('click', closeSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);
    </script>
</body>
</html>
