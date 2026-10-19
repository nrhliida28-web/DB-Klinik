<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$data = mysqli_query(
    $koneksi,
    "SELECT pemeriksaan.*, pasien.nama_pasien, dokter.nama_dokter 
     FROM pemeriksaan 
     JOIN pasien ON pemeriksaan.id_pasien = pasien.id_pasien 
     JOIN dokter ON pemeriksaan.id_dokter = dokter.id_dokter 
     ORDER BY pemeriksaan.id_pemeriksaan DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemeriksaan - Sistem Informasi Klinik</title>

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
            max-width: 950px;
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
            margin-bottom: 16px;
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

        .header-title {
            margin-bottom: 24px;
        }

        h2 {
            font-size: 22px;
            font-weight: 700;
            color: #2c2c2c;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid #e2d1d6;
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

        tr:last-child td {
            border-bottom: none;
        }

        tr:nth-child(even) {
            background-color: #fffafb;
        }

        tr:hover {
            background-color: #fef0f3;
        }

        .text-center {
            text-align: center;
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

    <a href="index.php" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Dashboard
    </a>

    <div class="header-title">
        <h2>Data Pemeriksaan</h2>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">No</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Tanggal</th>
                    <th>Keluhan</th>
                    <th>Diagnosa</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php while ($pm = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($pm["nama_pasien"]) ?></td>
                    <td><?= htmlspecialchars($pm["nama_dokter"]) ?></td>
                    <td><?= htmlspecialchars($pm["tanggal"]) ?></td>
                    <td><?= htmlspecialchars($pm["keluhan"]) ?></td>
                    <td><?= htmlspecialchars($pm["diagnosa"]) ?></td>
                </tr>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows($data) == 0): ?>
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px; color: #8c7b83;">
                        Belum ada data pemeriksaan.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer-note">
        &copy; <?= date('Y'); ?> Sistem Informasi Klinik • Layanan Medis
    </div>

</div>

</body>

</html>