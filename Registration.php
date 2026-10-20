<?php
require_once __DIR__ . '/auth.php';
$returnUrl = auth_return_url($_GET['return'] ?? null);
$registrationError = $_SESSION['registration_error'] ?? '';
unset($_SESSION['registration_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
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
            padding: 20px;
        }

        .registration-container {
            width: 100%;
            max-width: 480px;
        }

        .registration-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .registration-card h1 {
            color: #0b1d3a;
            text-align: center;
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

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #0b1d3a;
            box-shadow: 0 0 0 2px rgba(11, 29, 58, 0.12);
        }

        .password-guidance {
            margin-top: 6px;
            color: #666;
            font-size: 12px;
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

        .btn-register {
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

        .btn-register:hover {
            background-color: #006400;
        }

        .msg {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: left;
            font-size: 14px;
        }

        .error { background: #fde8e8; color: #a12020; }
        .success { background: #e6f6ea; color: #1d6b34; }
        .msg p { margin: 0 0 4px; }

        .form-footer {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
            color: #666;
        }

        .form-footer a {
            color: #0b1d3a;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="registration-container">
    <div class="registration-card">
        <h1>Registration</h1>

        <?php if ($registrationError !== ''): ?>
            <div class="msg error" role="alert"><?= nl2br(htmlspecialchars($registrationError, ENT_QUOTES, 'UTF-8')) ?></div>
        <?php endif; ?>

        <form method="post" action="registrationLogic.php">
            <input type="hidden" name="return" value="<?= htmlspecialchars($returnUrl, ENT_QUOTES, 'UTF-8') ?>">
            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Name"required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@email.com" required>
            </div>

            <div class="input-group">
                <label for="bday">Birthday</label>
                <input type="date" id="bday" name="bday" max="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="input-group">
                <label for="contact">Contact Number</label>
                <input type="tel" id="contact" name="contact" placeholder="09xxxxxxxxx" required>
            </div>

            <div class="input-group">
                <label for="region">Region</label>
                <select id="region" name="region" required disabled>
                    <option value="">Loading regions...</option>
                </select>
            </div>

            <div class="input-group">
                <label for="state">State / Province</label>
                <select id="state" name="state" required disabled>
                    <option value="">Select province</option>
                </select>
            </div>

            <div class="input-group">
                <label for="city">City</label>
                <select id="city" name="city" required disabled>
                    <option value="">Select city/municipality</option>
                </select>
            </div>

            <div class="input-group">
                <label for="barangay">Barangay</label>
                <select id="barangay" name="barangay" required disabled>
                    <option value="">Select barangay</option>
                </select>
            </div>
            
            <div class="input-group">
                 <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="Street, Building, House No." required>
            </div>

            <p id="address-data-error" class="msg error" role="alert" hidden>
                Philippine address data could not be loaded. Refresh the page and try again.
            </p>

            <div class="input-group">
                <label for="postal_code">Postal Code</label>
                <input type="text" id="postal_code" name="postal_code" placeholder="e.g. 1000" required>
            </div>

            <div class="input-group">
                <label for="password">Create Password</label>
                <input type="password" id="password" name="password" placeholder="Choose a strong password"
                       minlength="8" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}"
                       title="Use at least 8 characters with uppercase and lowercase letters, a number, and a symbol." required>
                <p class="password-guidance">At least 8 characters, including uppercase and lowercase letters, a number, and a symbol.</p> 
            </div>

            <div class="input-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Re-enter your password"
                       minlength="8" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}"
                       title="Enter the same strong password again." required>
                 <label class="show-password" for="show-password">
                    <input type="checkbox" id="show-password" aria-controls="password">
                    Show password
                </label>
            </div>

            <button type="submit" class="btn-register">Register now</button>
        </form>

        <div class="form-footer">
            <p>Already have an account? <a href="Sign.php?return=<?= rawurlencode($returnUrl) ?>">Go to Login</a></p>
        </div>
    </div>
</div>

<script>
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const showPasswordInput = document.getElementById('show-password');
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');
    const barangaySelect = document.getElementById('barangay');
    const addressDataError = document.getElementById('address-data-error');

    function resetAddressSelect(select, placeholder) {
        select.replaceChildren(new Option(placeholder, ''));
        select.value = '';
        select.disabled = true;
    }

    function fillAddressSelect(select, rows, valueKey, labelKey, placeholder) {
        select.replaceChildren(new Option(placeholder, ''));
        rows.forEach((row) => {
            select.add(new Option(row[labelKey], row[valueKey]));
        });
        select.disabled = false;
    }

    async function loadAddressData(path) {
        const response = await fetch(path);
        if (!response.ok) {
            throw new Error(`Unable to load ${path}`);
        }
        const rows = await response.json();
        if (!Array.isArray(rows)) {
            throw new Error(`Invalid address data in ${path}`);
        }
        return rows;
    }

    let regions = [];
    let provinces = [];
    let cities = [];
    let barangays = [];

    async function loadRegions() {
        try {
            [regions, provinces, cities, barangays] = await Promise.all([
                loadAddressData('ph-json/region.json'),
                loadAddressData('ph-json/province.json'),
                loadAddressData('ph-json/city.json'),
                loadAddressData('ph-json/barangay.json')
            ]);
            regions.sort((a, b) => a.region_name.localeCompare(b.region_name));
            fillAddressSelect(regionSelect, regions, 'region_code', 'region_name', 'Select region');
            addressDataError.hidden = true;
        } catch (error) {
            console.error('Failed to load registration address data:', error);
            addressDataError.hidden = false;
            regionSelect.disabled = true;
        }
    }

    regionSelect.addEventListener('change', function () {
        resetAddressSelect(provinceSelect, 'Select province');
        resetAddressSelect(citySelect, 'Select city/municipality');
        resetAddressSelect(barangaySelect, 'Select barangay');
        if (!this.value) return;

        const matchingProvinces = provinces
            .filter((province) => province.region_code === this.value)
            .sort((a, b) => a.province_name.localeCompare(b.province_name));
        fillAddressSelect(provinceSelect, matchingProvinces, 'province_code', 'province_name', 'Select province');
    });

    provinceSelect.addEventListener('change', function () {
        resetAddressSelect(citySelect, 'Select city/municipality');
        resetAddressSelect(barangaySelect, 'Select barangay');
        if (!this.value) return;

        const matchingCities = cities
            .filter((city) => city.province_code === this.value)
            .sort((a, b) => a.city_name.localeCompare(b.city_name));
        fillAddressSelect(citySelect, matchingCities, 'city_code', 'city_name', 'Select city/municipality');
    });

    citySelect.addEventListener('change', function () {
        resetAddressSelect(barangaySelect, 'Select barangay');
        if (!this.value) return;

        const matchingBarangays = barangays
            .filter((barangay) => barangay.city_code === this.value)
            .sort((a, b) => a.brgy_name.localeCompare(b.brgy_name));
        fillAddressSelect(barangaySelect, matchingBarangays, 'brgy_code', 'brgy_name', 'Select barangay');
    });

    function validatePasswordMatch() {
        confirmPasswordInput.setCustomValidity(
            confirmPasswordInput.value === passwordInput.value ? '' : 'Passwords do not match.'
        );
    }

    passwordInput.addEventListener('input', validatePasswordMatch);
    confirmPasswordInput.addEventListener('input', validatePasswordMatch);
    showPasswordInput.addEventListener('change', function () {
        const inputType = this.checked ? 'text' : 'password';
        passwordInput.type = inputType;
        confirmPasswordInput.type = inputType;
    });

    loadRegions();
</script>
</body>
</html>