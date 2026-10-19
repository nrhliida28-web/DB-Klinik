<?php

session_start();

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username == "admin" && $password == "12345") {

        $_SESSION["login"] = true;
        $_SESSION["username"] = $username;

        header("Location: index.php");
        exit;

    } else {

        $error = "Username atau password salah!";

    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Klinik</title>

    <!-- Font Google: Plus Jakarta Sans (Profesional & Modern) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #faf0f2;
            background-image: 
                radial-gradient(#f0ced6 1px, transparent 1px);
            background-size: 24px 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333333;
        }

        /* Card Login Modern */
        .login-container {
            background: #ffffff;
            border: 1px solid #f0ced6;
            border-radius: 18px;
            padding: 40px 32px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 12px 32px rgba(216, 90, 127, 0.08);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Header Icon Medis (Stetoskop & Salib Medis) */
        .clinic-brand {
            width: 56px;
            height: 56px;
            background-color: #fde8ed;
            color: #d85a7f;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px auto;
        }

        .clinic-brand svg {
            width: 30px;
            height: 30px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        h2 {
            color: #2c2c2c;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        p.subtitle {
            color: #8c7b83;
            font-size: 13px;
            margin-bottom: 24px;
            font-weight: 500;
        }

        /* Alert Error */
        .error {
            background-color: #fdf2f2;
            color: #9b1c1c;
            border: 1px solid #fbd5d5;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
            text-align: left;
        }

        /* Form Controls */
        form {
            text-align: left;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #555555;
            margin-bottom: 6px;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Kondimen Icon Medis di Input Field */
        .input-icon {
            position: absolute;
            left: 12px;
            color: #d85a7f;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-icon svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1px solid #e2d1d6;
            border-radius: 10px;
            outline: none;
            background-color: #fffafb;
            font-size: 14px;
            color: #333333;
            transition: all 0.2s ease;
        }

        input:focus {
            border-color: #d85a7f;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(216, 90, 127, 0.15);
        }

        /* Tombol Utama */
        button {
            width: 100%;
            padding: 12px;
            background-color: #d85a7f;
            border: none;
            border-radius: 10px;
            color: #ffffff;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            margin-top: 8px;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        button:hover {
            background-color: #c4496e;
        }

        button:active {
            transform: scale(0.99);
        }

        /* Footer Badges Kondimen Medis */
        .clinic-footer {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px dashed #f0ced6;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            color: #8c7b83;
            font-size: 12px;
        }

        .footer-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .footer-item svg {
            width: 15px;
            height: 15px;
            fill: none;
            stroke: #d85a7f;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
    </style>

</head>

<body>

<div class="login-container">

    <!-- Header Kondimen: Logo Stetoskop Klinik Elegan -->
    <div class="clinic-brand">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M4.8 2.3A.3.3 0 0 0 4.5 2.6V10a6 6 0 0 0 12 0V2.6a.3.3 0 0 0-.3-.3h-1.4a.3.3 0 0 0-.3.3V10a4 4 0 1 1-8 0V2.6a.3.3 0 0 0-.3-.3H4.8z"/>
            <path d="M10.5 16v2.5a3.5 3.5 0 0 0 7 0V17"/>
            <circle cx="17.5" cy="15.5" r="1.5"/>
        </svg>
    </div>

    <h2>Login Klinik</h2>

    <p class="subtitle">Sistem Informasi Layanan Kesehatan</p>

    <?php if ($error != ""): ?>

        <div class="error">
            <?= $error ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="input-group">
            <label for="username">Username / ID Medis</label>
            <div class="input-wrapper">
                <!-- Icon Kondimen: Kapsul/Obat -->
                <span class="input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/>
                        <path d="m8.5 8.5 7 7"/>
                    </svg>
                </span>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Masukkan username"
                    required
                    autocomplete="off"
                >
            </div>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
                <!-- Icon Kondimen: Suntikan / Syringe -->
                <span class="input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="m18 2 4 4"/>
                        <path d="m17 7 3-3"/>
                        <path d="M19 9 8.7 19.3c-1 1-2.5 1-3.4 0l-.6-.6c-1-1-1-2.5 0-3.4L15 5"/>
                        <path d="m9 11 4 4"/>
                        <path d="m5 19-3 3"/>
                        <path d="m14 4 6 6"/>
                    </svg>
                </span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
            </div>
        </div>

        <button type="submit" name="login">
            Masuk ke Sistem
        </button>

    </form>

    <!-- Footer Kondimen Medis Profesional -->
    <div class="clinic-footer">
        <div class="footer-item">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            <span>Sistem Terenkripsi</span>
        </div>
        <div class="footer-item">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
            </svg>
            <span>Layanan Medis</span>
        </div>
    </div>

</div>

</body>

</html>