<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

if (isset($_POST["simpan"])) {

    $nama   = mysqli_real_escape_string($koneksi, $_POST["nama"]);
    $jk     = mysqli_real_escape_string($koneksi, $_POST["jk"]);
    $alamat = mysqli_real_escape_string($koneksi, $_POST["alamat"]);
    $telp   = mysqli_real_escape_string($koneksi, $_POST["telp"]);

    mysqli_query(
        $koneksi,
        "INSERT INTO pasien
        (nama_pasien, jenis_kelamin, alamat, no_telp)
        VALUES
        ('$nama', '$jk', '$alamat', '$telp')"
    );

    header("Location: pasien.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pasien - Sistem Informasi Klinik</title>

    <!-- Font Google: Plus Jakarta Sans -->
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
            background-image: radial-gradient(#f0ced6 1px, transparent 1px);
            background-size: 24px 24px;
            min-height: 100vh;
            color: #333333;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Container Utama */
        .container {
            background: #ffffff;
            border: 1px solid #f0ced6;
            border-radius: 20px;
            padding: 36px 32px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 12px 32px rgba(216, 90, 127, 0.08);
        }

        /* Navigasi Kembali */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #8c7b83;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #d85a7f;
        }

        .back-link svg {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Judul Form */
        h2 {
            font-size: 22px;
            font-weight: 700;
            color: #2c2c2c;
            margin-bottom: 24px;
            border-bottom: 1px solid #fce8ec;
            padding-bottom: 12px;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #444444;
            margin-bottom: 8px;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 12px 14px;
            background-color: #fffafb;
            border: 1px solid #e2d1d6;
            border-radius: 10px;
            font-size: 13px;
            color: #333333;
            outline: none;
            transition: all 0.2s ease;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        input[type="text"]:focus,
        select:focus,
        textarea:focus {
            border-color: #d85a7f;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(216, 90, 127, 0.15);
        }

        /* Tombol Simpan */
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #d85a7f;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 8px;
        }

        button[type="submit"]:hover {
            background-color: #c4496e;
        }

        .footer-note {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px dashed #f0ced6;
            text-align: center;
            font-size: 12px;
            color: #a09098;
        }
    </style>

</head>

<body>

<div class="container">

    <!-- Navigasi Kembali ke Data Pasien -->
    <a href="pasien.php" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Data Pasien
    </a>

    <h2>Tambah Data Pasien</h2>

    <form method="POST">

        <div class="form-group">
            <label>Nama Pasien</label>
            <input type="text" name="nama" required placeholder="Masukkan nama pasien" autocomplete="off">
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" placeholder="Masukkan alamat lengkap"></textarea>
        </div>

        <div class="form-group">
            <label>No. Telepon</label>
            <input type="text" name="telp" placeholder="Masukkan nomor telepon" autocomplete="off">
        </div>

        <button type="submit" name="simpan">Simpan</button>

    </form>

    <div class="footer-note">
        &copy; <?= date('Y'); ?> Sistem Informasi Klinik • Layanan Medis
    </div>

</div>

</body>

</html>