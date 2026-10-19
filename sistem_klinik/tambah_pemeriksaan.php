<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Atur zona waktu sesuai lokasi (WITA / WIB / WIT)
date_default_timezone_set('Asia/Makassar'); // Ganti 'Asia/Jakarta' jika menggunakan WIB

// Ambil data pasien & dokter untuk dropdown
$data_pasien = mysqli_query($koneksi, "SELECT * FROM pasien ORDER BY nama_pasien ASC");
$data_dokter = mysqli_query($koneksi, "SELECT * FROM dokter ORDER BY nama_dokter ASC");

if (isset($_POST["simpan"])) {

    $id_pasien         = mysqli_real_escape_string($koneksi, $_POST["id_pasien"]);
    $id_dokter         = mysqli_real_escape_string($koneksi, $_POST["id_dokter"]);
    $keluhan           = mysqli_real_escape_string($koneksi, $_POST["keluhan"]);
    $diagnosa          = mysqli_real_escape_string($koneksi, $_POST["diagnosa"]);
    $biaya_pemeriksaan = mysqli_real_escape_string($koneksi, $_POST["biaya_pemeriksaan"]);
    $biaya_obat        = mysqli_real_escape_string($koneksi, $_POST["biaya_obat"]);
    $total_bayar       = mysqli_real_escape_string($koneksi, $_POST["total_bayar"]);
    $metode_pembayaran = mysqli_real_escape_string($koneksi, $_POST["metode_pembayaran"]);

    // Mengambil tanggal dan jam saat ini (real-time)
    $waktu_sekarang    = date('Y-m-d H:i:s');

    // 1. Simpan data pemeriksaan
    $query_pemeriksaan = "INSERT INTO pemeriksaan (id_pasien, id_dokter, tanggal, keluhan, diagnosa)
                          VALUES ('$id_pasien', '$id_dokter', '$waktu_sekarang', '$keluhan', '$diagnosa')";

    if (mysqli_query($koneksi, $query_pemeriksaan)) {
        // Ambil ID pemeriksaan yang baru diinput
        $id_pemeriksaan = mysqli_insert_id($koneksi);

        // 2. Simpan data pembayaran dengan waktu real-time
        $query_pembayaran = "INSERT INTO pembayaran (id_pemeriksaan, biaya_pemeriksaan, biaya_obat, total_bayar, metode_pembayaran, tanggal_bayar)
                             VALUES ('$id_pemeriksaan', '$biaya_pemeriksaan', '$biaya_obat', '$total_bayar', '$metode_pembayaran', '$waktu_sekarang')";
        
        mysqli_query($koneksi, $query_pembayaran);

        header("Location: pemeriksaan.php");
        exit;
    } else {
        echo "Gagal menyimpan data pemeriksaan: " . mysqli_error($koneksi);
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemeriksaan - Sistem Informasi Klinik</title>

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

        .container {
            background: #ffffff;
            border: 1px solid #f0ced6;
            border-radius: 20px;
            padding: 36px 32px;
            width: 100%;
            max-width: 550px;
            box-shadow: 0 12px 32px rgba(216, 90, 127, 0.08);
        }

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

        h2 {
            font-size: 22px;
            font-weight: 700;
            color: #2c2c2c;
            margin-bottom: 24px;
            border-bottom: 1px solid #fce8ec;
            padding-bottom: 12px;
        }

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
        input[type="number"],
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

        input[readonly] {
            background-color: #f5f5f5;
            color: #666666;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            border-color: #d85a7f;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(216, 90, 127, 0.15);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #d85a7f;
            margin: 20px 0 12px 0;
            padding-top: 12px;
            border-top: 1px dashed #f0ced6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

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
            margin-top: 12px;
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

    <a href="pemeriksaan.php" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Pemeriksaan
    </a>

    <h2>Tambah Data Pemeriksaan</h2>

    <form method="POST">

        <div class="form-group">
            <label>Pasien</label>
            <select name="id_pasien" required>
                <option value="">-- Pilih Pasien --</option>
                <?php while ($p = mysqli_fetch_assoc($data_pasien)): ?>
                    <option value="<?= $p["id_pasien"] ?>"><?= htmlspecialchars($p["nama_pasien"]) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Dokter</label>
            <select name="id_dokter" required>
                <option value="">-- Pilih Dokter --</option>
                <?php while ($d = mysqli_fetch_assoc($data_dokter)): ?>
                    <option value="<?= $d["id_dokter"] ?>"><?= htmlspecialchars($d["nama_dokter"]) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Keluhan</label>
            <textarea name="keluhan" placeholder="Masukkan keluhan pasien" required></textarea>
        </div>

        <div class="form-group">
            <label>Diagnosa</label>
            <input type="text" name="diagnosa" placeholder="Masukkan diagnosa" required autocomplete="off">
        </div>

        <!-- Bagian Pembayaran -->
        <div class="section-title">Informasi Pembayaran</div>

        <div class="form-row">
            <div class="form-group">
                <label>Biaya Dokter / Periksa (Rp)</label>
                <input type="number" id="biaya_pemeriksaan" name="biaya_pemeriksaan" placeholder="Contoh: 50000" oninput="hitungTotal()" required>
            </div>

            <div class="form-group">
                <label>Biaya Obat (Rp)</label>
                <input type="number" id="biaya_obat" name="biaya_obat" placeholder="Contoh: 25000" value="0" oninput="hitungTotal()" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Total Biaya (Rp)</label>
                <input type="number" id="total_bayar" name="total_bayar" placeholder="0" readonly required>
            </div>

            <div class="form-group">
                <label>Metode Pembayaran</label>
                <select name="metode_pembayaran" required>
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer">Transfer</option>
                    <option value="QRIS">QRIS</option>
                    <option value="BPJS">BPJS</option>
                    <option value="Kartu Kredit">Kartu Kredit</option>
                </select>
            </div>
        </div>

        <button type="submit" name="simpan">Simpan</button>

    </form>

    <div class="footer-note">
        &copy; <?= date('Y'); ?> Sistem Informasi Klinik • Layanan Medis
    </div>

</div>

<script>
function hitungTotal() {
    let periksa = parseFloat(document.getElementById('biaya_pemeriksaan').value) || 0;
    let obat = parseFloat(document.getElementById('biaya_obat').value) || 0;
    document.getElementById('total_bayar').value = periksa + obat;
}
</script>

</body>

</html>