<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$query = "SELECT pembayaran.*, pasien.nama_pasien 
          FROM pembayaran 
          JOIN pemeriksaan ON pembayaran.id_pemeriksaan = pemeriksaan.id_pemeriksaan
          JOIN pasien ON pemeriksaan.id_pasien = pasien.id_pasien
          ORDER BY pembayaran.id_pembayaran DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembayaran</title>
    <!-- Font Google: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
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
            padding: 20px;
        }

        .container {
            background: #ffffff;
            border: 1px solid #f0ced6;
            border-radius: 20px;
            padding: 36px 32px;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            box-shadow: 0 12px 32px rgba(216, 90, 127, 0.08);
        }

        .header-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        h2 {
            font-size: 22px;
            font-weight: 700;
            color: #d85a7f;
        }

        .btn-tambah {
            background: #d85a7f;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .btn-tambah:hover {
            background: #c4496e;
        }

        .back-link {
            color: #8c7b83;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-left: 12px;
        }

        .back-link:hover {
            color: #d85a7f;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid #e2d1d6;
            margin-top: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            text-align: left;
        }

        th {
            background-color: #fde8ed;
            color: #d85a7f;
            font-size: 13px;
            font-weight: 700;
            padding: 14px 16px;
            border-bottom: 1px solid #e2d1d6;
        }

        td {
            padding: 14px 16px;
            font-size: 13px;
            color: #444444;
            border-bottom: 1px solid #f2e4e8;
        }

        tr:nth-child(even) {
            background-color: #fffafb;
        }

        tr:hover {
            background-color: #fef0f3;
        }

        .btn-edit {
            display: inline-block;
            background-color: #e1f0ff;
            color: #3182ce;
            border: 1px solid #cce3ff;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-edit:hover {
            background-color: #d0e4ff;
            color: #2b6cb0;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-title">
        <h2>Daftar Pembayaran Pasien</h2>
        <div>
            <a href="tambah_pembayaran.php" class="btn-tambah">+ Tambah Pembayaran Baru</a>
            <a href="index.php" class="back-link">Dashboard</a>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">No</th>
                    <th>Nama Pasien</th>
                    <th>Biaya Periksa</th>
                    <th>Biaya Obat</th>
                    <th>Total Bayar</th>
                    <th>Metode</th>
                    <th>Tanggal</th>
                    <th class="text-center" style="width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                <?php
                    // Penanganan nama kolom biaya
                    $biaya_periksa = $row['biaya_pemeriksaan'] ?? $row['biaya_periksa'] ?? 0;
                    $biaya_obat = $row['biaya_obat'] ?? 0;
                    $tgl_bayar = $row['tanggal_bayar'] ?? $row['tgl_pembayaran'] ?? '-';
                ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_pasien']); ?></td>
                    <td>Rp <?= number_format($biaya_periksa, 0, ',', '.'); ?></td>
                    <td>Rp <?= number_format($biaya_obat, 0, ',', '.'); ?></td>
                    <td><b>Rp <?= number_format($row['total_bayar'], 0, ',', '.'); ?></b></td>
                    <td><?= htmlspecialchars($row['metode_pembayaran'] ?: '-'); ?></td>
                    <td><?= htmlspecialchars($tgl_bayar); ?></td>
                    <td class="text-center">
                        <a href="edit_pembayaran.php?id=<?= $row['id_pembayaran']; ?>" class="btn-edit">Edit</a>
                    </td>
                </tr>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows($result) == 0) : ?>
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px; color: #8c7b83;">
                        Belum ada data pembayaran.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>