<?php
require_once __DIR__ . '/auth.php';

$errors  = [];
$success = '';
$old     = [
    'name' => '',
    'email' => '',
    'bday' => '',
    'contact' => '',
    'region' => '',
    'state' => '',
    'city' => '',
    'barangay' => '',
    'postal_code' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['name']    = trim($_POST['name'] ?? '');
    $old['email']   = trim($_POST['email'] ?? '');
    $old['bday']    = $_POST['bday'] ?? '';
    $old['contact'] = trim($_POST['contact'] ?? '');
    $old['region'] = trim($_POST['region'] ?? '');
    $old['state'] = trim($_POST['state'] ?? '');
    $old['city'] = trim($_POST['city'] ?? '');
    $old['barangay'] = trim($_POST['barangay'] ?? '');
    $old['postal_code'] = trim($_POST['postal_code'] ?? '');
    $password       = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $regionCode = $old['region'];
    $provinceCode = $old['state'];
    $cityCode = $old['city'];

    if ($old['name'] === '') {
        $errors[] = 'Name is required.';
    }
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email.';
    }
    if ($old['bday'] === '') {
        $errors[] = 'Birthday is required.';
    } else {
        $d = DateTime::createFromFormat('Y-m-d', $old['bday']);
        if (!$d || $d->format('Y-m-d') !== $old['bday'] || $d > new DateTime('today')) {
            $errors[] = 'Please enter a valid birthday.';
        }
    }
    if ($old['contact'] === '') {
        $errors[] = 'Contact number is required.';
    }
    if ($old['barangay'] === '') {
        $errors[] = 'Barangay is required.';
    }
    if ($old['postal_code'] === '') {
        $errors[] = 'Postal code is required.';
    }
    if (!is_string($password) || !is_strong_password($password)) {
        $errors[] = 'Password must be at least 8 characters and include uppercase and lowercase letters, a number, and a symbol.';
    }
    if (!is_string($confirmPassword) || $confirmPassword !== $password) {
        $errors[] = 'Passwords do not match.';
    }

    if ($regionCode === '' || $provinceCode === '' || $cityCode === '') {
        $errors[] = 'Please select a region, province, and city/municipality.';
    } else {
        try {
            $regions = json_decode(file_get_contents(__DIR__ . '/ph-json/region.json'), true, 512, JSON_THROW_ON_ERROR);
            $provinces = json_decode(file_get_contents(__DIR__ . '/ph-json/province.json'), true, 512, JSON_THROW_ON_ERROR);
            $cities = json_decode(file_get_contents(__DIR__ . '/ph-json/city.json'), true, 512, JSON_THROW_ON_ERROR);
            $barangays = json_decode(file_get_contents(__DIR__ . '/ph-json/barangay.json'), true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $exception) {
            error_log('Unable to load Philippine address data: ' . $exception->getMessage());
            $errors[] = 'Address data is temporarily unavailable. Please try again later.';
        }

        if (isset($regions, $provinces, $cities)) {
            $selectedRegion = null;
            foreach ($regions as $region) {
                if (($region['region_code'] ?? null) === $regionCode) {
                    $selectedRegion = $region;
                    break;
                }
            }

            $selectedProvince = null;
            foreach ($provinces as $province) {
                if (($province['province_code'] ?? null) === $provinceCode
                    && ($province['region_code'] ?? null) === $regionCode) {
                    $selectedProvince = $province;
                    break;
                }
            }

            $selectedCity = null;
            foreach ($cities as $city) {
                if (($city['city_code'] ?? null) === $cityCode
                    && ($city['province_code'] ?? null) === $provinceCode) {
                    $selectedCity = $city;
                    break;
                }
            }

            $selectedBarangay = null;
            foreach ($barangays as $barangay) {
                if (($barangay['brgy_code'] ?? null) === $old['barangay']
                    && ($barangay['city_code'] ?? null) === $cityCode) {
                    $selectedBarangay = $barangay;
                    break;
                }
            }

            if ($selectedRegion === null || $selectedProvince === null || $selectedCity === null) {
                $errors[] = 'Please select a valid region, province, and city/municipality.';
            } elseif ($selectedBarangay === null) {
                $errors[] = 'Please select a valid barangay for the selected city/municipality.';
            } else {
                $old['region'] = $selectedRegion['region_name'];
                $old['state'] = $selectedProvince['province_name'];
                $old['city'] = $selectedCity['city_name'];
                $old['barangay'] = $selectedBarangay['brgy_name'];
            }
        }
    }

    if (!$errors) {
        $profile = [
            'name' => $old['name'],
            'email' => $old['email'],
            'bday' => $old['bday'],
            'contact' => $old['contact'],
            'region' => $old['region'],
            'state' => $old['state'],
            'city' => $old['city'],
            'barangay' => $old['barangay'],
            'postal_code' => $old['postal_code'],
        ];
        session_regenerate_id(true);
        $_SESSION['user_email'] = $old['email'];
        $_SESSION['user'] = $profile;
        header('Location: ' . auth_return_url($_POST['return'] ?? null));
        exit;
    }

    $errorMessage = implode("\n", $errors);
    $_SESSION['registration_error'] = $errorMessage;
    header('Location: Registration.php?return=' . rawurlencode(auth_return_url($_POST['return'] ?? null)));
    exit;
}
?>