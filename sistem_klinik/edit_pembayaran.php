<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Ambil ID Pembayaran dari parameter URL
$id_pembayaran = $_GET['id'] ?? null;

if (!$id_pembayaran) {
    header("Location: pembayaran.php");
    exit;
}

// Fetch data pembayaran beserta data pasien terkait
$query = mysqli_query($koneksi, "
    SELECT pembayaran.*, pemeriksaan.id_pasien, pasien.nama_pasien 
    FROM pembayaran 
    LEFT JOIN pemeriksaan ON pembayaran.id_pemeriksaan = pemeriksaan.id_pemeriksaan 
    LEFT JOIN pasien ON pemeriksaan.id_pasien = pasien.id_pasien 
    WHERE pembayaran.id_pembayaran = '$id_pembayaran'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>
            alert('Data pembayaran tidak ditemukan!');
            window.location.href = 'pembayaran.php';
          </script>";
    exit;
}

// Proses simpan perubahan
if (isset($_POST['update'])) {
    $biaya_pemeriksaan = mysqli_real_escape_string($koneksi, $_POST['biaya_pemeriksaan']);
    $biaya_obat        = mysqli_real_escape_string($koneksi, $_POST['biaya_obat']);
    $total_bayar       = mysqli_real_escape_string($koneksi, $_POST['total_bayar']);
    $metode_pembayaran = mysqli_real_escape_string($koneksi, $_POST['metode_pembayaran']);
    $tanggal           = mysqli_real_escape_string($koneksi, $_POST['tanggal']);

    // Update query disesuaikan dengan kolom 'biaya_pemeriksaan'
    $update = mysqli_query($koneksi, "UPDATE pembayaran SET 
        biaya_pemeriksaan = '$biaya_pemeriksaan',
        biaya_obat        = '$biaya_obat',
        total_bayar       = '$total_bayar',
        metode_pembayaran = '$metode_pembayaran',
        tanggal_bayar     = '$tanggal' 
        WHERE id_pembayaran = '$id_pembayaran'");

    if ($update) {
        echo "<script>
                alert('Data pembayaran berhasil diperbarui!');
                window.location.href = 'pembayaran.php';
              </script>";
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pembayaran - Sistem Informasi Klinik</title>

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
            max-width: 500px;
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
        select {
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

        input:disabled {
            background-color: #f5f5f5;
            color: #888;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #d85a7f;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(216, 90, 127, 0.15);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .btn-simpan {
            background-color: #d85a7f;
            color: #ffffff;
        }

        .btn-simpan:hover {
            background-color: #c4496e;
        }

        .btn-batal {
            background-color: #f2f2f2;
            color: #666666;
        }

        .btn-batal:hover {
            background-color: #e5e5e5;
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

    <a href="pembayaran.php" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Pembayaran
    </a>

    <h2>Edit Data Pembayaran</h2>

    <form method="POST">

        <div class="form-group">
            <label>Nama Pasien</label>
            <input type="text" value="<?= htmlspecialchars($data['nama_pasien'] ?? 'Pasien') ?>" disabled>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Biaya Periksa (Rp)</label>
                <input type="number" id="biaya_pemeriksaan" name="biaya_pemeriksaan" value="<?= $data['biaya_pemeriksaan'] ?? 0 ?>" oninput="hitungTotal()">
            </div>

            <div class="form-group">
                <label>Biaya Obat (Rp)</label>
                <input type="number" id="biaya_obat" name="biaya_obat" value="<?= $data['biaya_obat'] ?? 0 ?>" oninput="hitungTotal()">
            </div>
        </div>

        <div class="form-group">
            <label>Total Bayar (Rp)</label>
            <input type="number" id="total_bayar" name="total_bayar" value="<?= $data['total_bayar'] ?>" required>
        </div>

        <div class="form-group">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" required>
                <option value="">-- Pilih Metode --</option>
                <option value="Tunai" <?= ($data['metode_pembayaran'] == 'Tunai') ? 'selected' : '' ?>>Tunai</option>
                <option value="Transfer" <?= ($data['metode_pembayaran'] == 'Transfer') ? 'selected' : '' ?>>Transfer</option>
                <option value="QRIS" <?= ($data['metode_pembayaran'] == 'QRIS') ? 'selected' : '' ?>>QRIS</option>
                <option value="BPJS" <?= ($data['metode_pembayaran'] == 'BPJS') ? 'selected' : '' ?>>BPJS</option>
                <option value="Kartu Kredit" <?= ($data['metode_pembayaran'] == 'Kartu Kredit') ? 'selected' : '' ?>>Kartu Kredit</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Pembayaran</label>
            <input type="text" name="tanggal" value="<?= $data['tanggal_bayar'] ?? date('Y-m-d H:i:s') ?>" required>
        </div>

        <div class="btn-group">
            <a href="pembayaran.php" class="btn btn-batal">Batal</a>
            <button type="submit" name="update" class="btn btn-simpan">Simpan Perubahan</button>
        </div>

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