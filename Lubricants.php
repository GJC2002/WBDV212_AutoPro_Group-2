<?php require_once __DIR__ . '/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Pro All Terrain & Street Lifestyle - Services</title>
    <link rel="stylesheet" href="style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">



</head>
<body class="page-lubricants">
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
  
  <br>
  <h1 style="text-align: center;">Lubricants</h1>
      <div class="search-container">
          <label for="wheel-search">Search lubricants:</label>
          <input type="search" id="wheel-search" name="wheel-search" placeholder="Search by lubricant name or type" aria-label="Search lubricant products">
      </div>
      <div id="no-results-message" class="no-results-message" hidden>No lubricants found matching your search.</div>

  <div class="flex-product">

    <article class="lubricant-product" data-search="dub pro lube 5w 40 fully synthetic oil">
        <button class="lubricant-image-button" type="button" aria-label="View Dub PRO LUBE 5W-40 specifications"
            onclick="openLubricantDetails(this)" data-product-id="dubprolube5w40"
            data-name="Dub PRO LUBE - 5W 40" data-image="./images/5w-40 lubricant.png"
            data-description="Fully Synthetic Oil 5W-40" data-viscosity="5W-40"
            data-type="Fully Synthetic Oil" data-price="700.00">
            <img src="./images/5w-40 lubricant.png" alt="Dub PRO LUBE 5W-40 fully synthetic oil">
        </button>
        <h2 class="lubricant-name">Dub PRO LUBE - 5W 40</h2>
        <h3 class="lubricant-price">PHP 700.00</h3>
    </article>

    <article class="lubricant-product" data-search="dub pro lube 10w 40 semi synthetic oil">
        <button class="lubricant-image-button" type="button" aria-label="View Dub PRO LUBE 10W-40 specifications"
            onclick="openLubricantDetails(this)" data-product-id="dubprolube10w40"
            data-name="Dub PRO LUBE - 10W 40" data-image="./images/10W-40 lubricant.png"
            data-description="Semi Synthetic Oil 10W-40" data-viscosity="10W-40"
            data-type="Semi Synthetic Oil" data-price="600.00">
            <img src="./images/10W-40 lubricant.png" alt="Dub PRO LUBE 10W-40 semi synthetic oil">
        </button>
        <h2 class="lubricant-name">Dub PRO LUBE - 10W 40</h2>
        <h3 class="lubricant-price">PHP 600.00</h3>
    </article>

    <article class="lubricant-product" data-search="hks 5w 30 super oil">
        <button class="lubricant-image-button" type="button" aria-label="View HKS 5W-30 specifications"
            onclick="openLubricantDetails(this)" data-product-id="hks5w30"
            data-name="HKS - 5W 30" data-image="./images/HKS - lubricant.png"
            data-description="5W-30 Super Oil" data-viscosity="5W-30"
            data-type="Super Oil" data-price="2,400.00">
            <img src="./images/HKS - lubricant.png" alt="HKS 5W-30 Super Oil">
        </button>
        <h2 class="lubricant-name">HKS - 5W 30</h2>
        <h3 class="lubricant-price">PHP 2,400.00</h3>
    </article>

  </div>

  <dialog class="lubricant-dialog" id="lubricant-dialog" aria-labelledby="lubricant-dialog-title">
      <button class="lubricant-dialog-close" type="button" aria-label="Close product details" onclick="closeLubricantDetails()">×</button>
      <div class="lubricant-dialog-content">
          <img class="lubricant-dialog-image" id="lubricant-dialog-image" src="" alt="">
          <div class="lubricant-dialog-info">
              <h2 id="lubricant-dialog-title"></h2>
              <h3 class="lubricant-dialog-price" id="lubricant-dialog-price"></h3>
              <p id="lubricant-dialog-description"></p>
              <p><strong>Viscosity:</strong> <span id="lubricant-dialog-viscosity"></span></p>
              <p><strong>Oil type:</strong> <span id="lubricant-dialog-type"></span></p>
              <label for="lubricant-dialog-quantity">Quantity:</label>
              <input type="number" id="lubricant-dialog-quantity" min="1" max="50" value="1">
              <span id="lubricant-dialog-error" class="error_message" role="alert"></span>
              <button class="lubricant-add-button" type="button" onclick="addLubricantToCart()">Add to Cart</button>
          </div>
      </div>
  </dialog>

   <footer class="footer">

    <div class="footer-left">
        <h2>AUTOPRO</h2>
        <p>All Terrain & Street Lifestyle</p>
    </div>

    <div class="footer-center">
        <a href="index.php">Home</a>
        <a href="About.php">About</a>
        <a href="Products.php">Products</a>
        <a href="Services.php">Services</a>
        <a href="Contact.php">Contact</a>
        <a href="cart.php">Cart</a>
        <a href="faq.php">FAQ</a>
    </div>

    <div class="footer-right" style="display:flex; flex-direction:row !important; justify-content:center; gap:25px; align-items:center;">

        <a href="https://www.facebook.com/autoprolifestyle" target="_blank" class="social-media">
            <i class="fa-brands fa-square-facebook"></i>
        </a>

        <a href="https://www.instagram.com/autopro_lifestyle/" target="_blank" class="social-media">
            <i class="fa-brands fa-instagram"></i>
        </a>

        <a href="https://www.tiktok.com/@autoprolifestyle" target="_blank" class="social-media">
            <i class="fa-brands fa-tiktok"></i>
        </a>

    </div>

</footer>

<div class="footer-bottom">
    © 2024 AUTOPRO ALL TERRAIN & STREET LIFESTYLE
</div>


<script src="https://kit.fontawesome.com/f50125bc94.js" crossorigin="anonymous"></script>


  <script>
    function showNotification(message) {
    let notif = document.getElementById('cart-notification');
    if (!notif) {
        notif = document.createElement('div');
        notif.id = 'cart-notification';
        notif.style.position = 'fixed';
        notif.style.top = '80px';
        notif.style.right = '20px';
        notif.style.padding = '12px 16px';
        notif.style.backgroundColor = '#4CAF50';
        notif.style.color = '#fff';
        notif.style.borderRadius = '8px';
        notif.style.boxShadow = '0 2px 10px rgba(0,0,0,0.15)';
        notif.style.zIndex = '9999';
        notif.style.opacity = '0';
        notif.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
        notif.style.transform = 'translateY(-10px)';
        document.body.appendChild(notif);
    }
    notif.textContent = message;
    notif.style.display = 'block';
    requestAnimationFrame(() => {
        notif.style.opacity = '1';
        notif.style.transform = 'translateY(0)';
    });
    clearTimeout(window._cartNotificationTimeout);
    window._cartNotificationTimeout = setTimeout(() => {
        notif.style.opacity = '0';
        notif.style.transform = 'translateY(-10px)';
        setTimeout(() => notif.style.display = 'none', 250);
    }, 2600);
}
function updateCartBadge() {
    const cart = JSON.parse(localStorage.getItem('cart')) || {};
    const count = Object.values(cart).reduce((sum, item) => sum + (Number(item.quantity) || 0), 0);
    const badge = document.getElementById('cart-count');
    if (!badge) return;
    if (count > 0) {
        badge.textContent = count;
        badge.style.display = 'flex';
    } else {
        badge.style.display = 'none';
    }
}
    let selectedLubricant = null;

    function openLubricantDetails(imageButton) {
        selectedLubricant = {
            productId: imageButton.dataset.productId,
            name: imageButton.dataset.name,
            image: imageButton.dataset.image,
            description: imageButton.dataset.description,
            viscosity: imageButton.dataset.viscosity,
            type: imageButton.dataset.type,
            price: imageButton.dataset.price
        };
        const dialog = document.getElementById('lubricant-dialog');
        document.getElementById('lubricant-dialog-image').src = selectedLubricant.image;
        document.getElementById('lubricant-dialog-image').alt = selectedLubricant.name;
        document.getElementById('lubricant-dialog-title').textContent = selectedLubricant.name;
        document.getElementById('lubricant-dialog-price').textContent = `PHP ${selectedLubricant.price}`;
        document.getElementById('lubricant-dialog-description').textContent = selectedLubricant.description;
        document.getElementById('lubricant-dialog-viscosity').textContent = selectedLubricant.viscosity;
        document.getElementById('lubricant-dialog-type').textContent = selectedLubricant.type;
        document.getElementById('lubricant-dialog-quantity').value = '1';
        document.getElementById('lubricant-dialog-error').textContent = '';
        dialog.showModal();
    }

    function closeLubricantDetails() {
        document.getElementById('lubricant-dialog').close();
    }

    function addLubricantToCart() {
        if (!<?= is_logged_in() ? 'true' : 'false' ?>) {
            window.location.href = 'Sign.php?return=Lubricants.php';
            return;
        }

        const quantityInput = document.getElementById('lubricant-dialog-quantity');
        const quantityError = document.getElementById('lubricant-dialog-error');
        const quantity = Number(quantityInput.value);
        quantityError.textContent = '';

        if (!Number.isInteger(quantity) || quantity < 1 || quantity > 50) {
            quantityError.textContent = 'Quantity must be between 1 and 50.';
            return;
        }

        if (!selectedLubricant) {
            return;
        }

        const cart = JSON.parse(localStorage.getItem('cart')) || {};
        const cartKey = selectedLubricant.productId;
        const item = cart[cartKey] || {
            productId: selectedLubricant.productId,
            quantity: 0,
            color: null,
            size: null,
            model: null,
            brand: null,
            description: null,
            area: null,
            part: null
        };
        item.quantity = (Number(item.quantity) || 0) + quantity;
        cart[cartKey] = item;
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartBadge();
        showNotification('Item added to cart!');
        closeLubricantDetails();
    }

    const sidebar = document.getElementById('sidebar');
    updateCartBadge();
    const searchInput = document.getElementById('wheel-search');

    function filterProducts() {
        const query = (searchInput?.value || '').trim().toLowerCase();
        const cards = document.querySelectorAll('.flex-product .lubricant-product');
        let visibleCount = 0;
        cards.forEach(card => {
            const visible = !query || card.dataset.search.includes(query);
            card.style.display = visible ? '' : 'none';
            if (visible) visibleCount += 1;
        });
        const noResults = document.getElementById('no-results-message');
        if (noResults) {
            noResults.hidden = visibleCount > 0;
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterProducts);
        filterProducts();
    }

    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const navToggle = document.getElementById('navToggle');
    const sidebarClose = document.getElementById('sidebarClose');

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

    document.getElementById('lubricant-dialog').addEventListener('click', event => {
        if (event.target === event.currentTarget) {
            closeLubricantDetails();
        }
    });
  </script>

   
</body>
</html>
