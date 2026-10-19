<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Ambil ID Pasien dari parameter URL
$id_pasien = $_GET['id'] ?? null;

if (!$id_pasien) {
    header("Location: pasien.php");
    exit;
}

// Query untuk mengambil data pasien berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM pasien WHERE id_pasien = '$id_pasien'");
$pasien = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$pasien) {
    echo "<script>
            alert('Data pasien tidak ditemukan!');
            window.location.href = 'pasien.php';
          </script>";
    exit;
}

// Proses update data saat form disubmit
if (isset($_POST['update'])) {
    $nama_pasien   = mysqli_real_escape_string($koneksi, $_POST['nama_pasien']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $alamat        = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_telp       = mysqli_real_escape_string($koneksi, $_POST['no_telp']);

    $update = mysqli_query($koneksi, "UPDATE pasien SET 
                nama_pasien   = '$nama_pasien',
                jenis_kelamin = '$jenis_kelamin',
                alamat        = '$alamat',
                no_telp       = '$no_telp'
                WHERE id_pasien = '$id_pasien'");

    if ($update) {
        echo "<script>
                alert('Data pasien berhasil diperbarui!');
                window.location.href = 'pasien.php';
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
    <title>Edit Data Pasien - Sistem Informasi Klinik</title>

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
            max-width: 550px;
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

        /* Header Section */
        h2 {
            font-size: 22px;
            font-weight: 700;
            color: #2c2c2c;
            margin-bottom: 24px;
        }

        /* Styling Form */
        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #555555;
            margin-bottom: 8px;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #e2d1d6;
            border-radius: 10px;
            font-size: 14px;
            color: #333333;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            background-color: #ffffff;
        }

        input[type="text"]:focus,
        select:focus,
        textarea:focus {
            border-color: #d85a7f;
            box-shadow: 0 0 0 3px rgba(216, 90, 127, 0.15);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Tombol Aksi */
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

        .alert-error {
            background-color: #fce4e4;
            color: #cc0000;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 18px;
            border: 1px solid #f7c6c6;
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

    <!-- Tombol Kembali -->
    <a href="pasien.php" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Data Pasien
    </a>

    <h2>Edit Data Pasien</h2>

    <?php if (isset($error)): ?>
        <div class="alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="nama_pasien">Nama Pasien</label>
            <input type="text" id="nama_pasien" name="nama_pasien" value="<?= htmlspecialchars($pasien['nama_pasien']) ?>" required>
        </div>

        <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="Laki-laki" <?= ($pasien['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= ($pasien['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" required><?= htmlspecialchars($pasien['alamat']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="no_telp">No. Telepon</label>
            <input type="text" id="no_telp" name="no_telp" value="<?= htmlspecialchars($pasien['no_telp']) ?>" required>
        </div>

        <div class="btn-group">
            <a href="pasien.php" class="btn btn-batal">Batal</a>
            <button type="submit" name="update" class="btn btn-simpan">Simpan Perubahan</button>
        </div>
    </form>

    <div class="footer-note">
        &copy; <?= date('Y'); ?> Sistem Informasi Klinik • Layanan Medis
    </div>

</div>

</body>

</html>