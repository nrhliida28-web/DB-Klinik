<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Hitung total data
$total_pasien      = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pasien"));
$total_dokter      = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM dokter"));
$total_pemeriksaan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pemeriksaan"));

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Klinik - Dashboard</title>

    <!-- Font Google: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Latar belakang & warna */
        body {
            background-color: #faf0f2;
            background-image: radial-gradient(#f0ced6 1px, transparent 1px);
            background-size: 24px 24px;
            min-height: 100vh;
            color: #333333;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
        }

        /* Container Utama */
        .container {
            background: #ffffff;
            border: 1px solid #f0ced6;
            border-radius: 20px;
            padding: 32px;
            width: 100%;
            max-width: 920px;
            box-shadow: 0 12px 32px rgba(216, 90, 127, 0.08);
        }

        /* Header / Logo Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 18px;
            border-bottom: 1px solid #fce8ec;
        }

        .brand-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background-color: #fde8ed;
            color: #d85a7f;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            border: 1px solid #f0ced6;
        }

        .brand-text h1 {
            font-size: 18px;
            font-weight: 800;
            color: #2c2c2c;
            line-height: 1.2;
        }

        .brand-text p {
            font-size: 12px;
            color: #8c7b83;
        }

        .user-badge {
            background-color: #fffafb;
            border: 1px solid #f0ced6;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: #d85a7f;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #22c55e;
            border-radius: 50%;
            display: inline-block;
        }

        /* Layout Grid Utama 2 Kolom */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
        }

        /* KARTU STATISTIK */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #fffafb;
            border: 1px solid #f2e4e8;
            border-radius: 14px;
            padding: 16px;
            text-align: center;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(216, 90, 127, 0.08);
            border-color: #f0ced6;
            background: #ffffff;
        }

        .stat-icon {
            color: #d85a7f;
            margin-bottom: 6px;
            display: inline-block;
        }

        .stat-icon svg {
            width: 22px;
            height: 22px;
            stroke-width: 2;
            stroke: currentColor;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 800;
            color: #d85a7f;
            line-height: 1.1;
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 700;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* AKSI UTAMA */
        .action-box {
            background: #fffafb;
            border: 1px solid #f0ced6;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .action-title {
            font-size: 13px;
            font-weight: 700;
            color: #d85a7f;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-tambah-pemeriksaan {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px;
            background-color: #d85a7f;
            border: 1px solid #d85a7f;
            color: #ffffff;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(216, 90, 127, 0.2);
        }

        .btn-tambah-pemeriksaan:hover {
            background-color: #c4496e;
            border-color: #c4496e;
            transform: translateY(-1px);
        }

        .btn-tambah-pembayaran {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px;
            background-color: #ffffff;
            border: 1px solid #d85a7f;
            color: #d85a7f;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-tambah-pembayaran:hover {
            background-color: #fde8ed;
            transform: translateY(-1px);
        }

        /* PANELS DAN SISI KANAN */
        .sidebar-panel {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .section-card {
            background: #ffffff;
            border: 1px solid #f2e4e8;
            border-radius: 14px;
            padding: 18px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #2c2c2c;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .section-title svg {
            width: 16px;
            height: 16px;
            stroke: #d85a7f;
            stroke-width: 2;
            fill: none;
        }

        /* Menu Navigasi Sisi Kanan */
        .nav-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            background-color: #fffafb;
            border: 1px solid #f0ced6;
            color: #444444;
            text-decoration: none;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .nav-link-item:hover {
            background-color: #fde8ed;
            color: #d85a7f;
            border-color: #d85a7f;
            padding-left: 15px;
        }

        /* Info Tambahan Widget */
        .info-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-size: 12px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding-bottom: 6px;
            border-bottom: 1px dashed #f2e4e8;
            color: #666666;
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-item span.val {
            font-weight: 700;
            color: #d85a7f;
        }

        /* Tombol Logout */
        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 12px;
            background-color: #fffafb;
            border: 1px solid #f0ced6;
            color: #d85a7f;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s ease;
            margin-top: 4px;
        }

        .logout-btn:hover {
            background-color: #fde8ed;
            border-color: #d85a7f;
        }

        .footer-note {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px dashed #f0ced6;
            text-align: center;
            font-size: 12px;
            color: #a09098;
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

</head>

<body>

<div class="container">

    <!-- Header & Status Admin -->
    <div class="header">
        <div class="brand-info">
            <div class="brand-icon">U</div>
            <div class="brand-text">
                <h1>Sistem Informasi Klinik</h1>
                <p>Dashboard Pengelolaan Data Medis</p>
            </div>
        </div>
        <div class="user-badge">
            <span class="status-dot"></span>
            Selamat datang, admin!
        </div>
    </div>

    <!-- Layout Grid Utama -->
    <div class="dashboard-grid">

        <!-- Kolom Kiri: Statistik & Tindakan Utama -->
        <div class="main-panel">
            
            <!-- Ringkasan Statistik -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div class="stat-number"><?= $total_pasien ?></div>
                    <div class="stat-label">Pasien</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                    </div>
                    <div class="stat-number"><?= $total_dokter ?></div>
                    <div class="stat-label">Dokter</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                    </div>
                    <div class="stat-number"><?= $total_pemeriksaan ?></div>
                    <div class="stat-label">Pemeriksaan</div>
                </div>
            </div>

            <!-- Panel Tindakan Utama -->
            <div class="action-box">
                <div class="action-title">Layanan Cepat</div>
                <div class="action-buttons">
                    <a href="tambah_pemeriksaan.php" class="btn-tambah-pemeriksaan">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Tambah Rekam Pemeriksaan
                    </a>
                    <a href="tambah_pembayaran.php" class="btn-tambah-pembayaran">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                        Transaksi Pembayaran
                    </a>
                </div>
            </div>

            <!-- Status Operasional Ringkas -->
            <div class="section-card">
                <div class="section-title">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 16 14"></polyline></svg>
                    Informasi Klinik
                </div>
                <div class="info-list">
                    <div class="info-item">
                        <span>Jam Operasional</span>
                        <span class="val">08:00 - 20:00 WIB</span>
                    </div>
                    <div class="info-item">
                        <span>Status Sistem</span>
                        <span class="val">Online / Normal</span>
                    </div>
                    <div class="info-item">
                        <span>Tanggal Sistem</span>
                        <span class="val"><?= date('d M Y'); ?></span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Navigasi & Logout -->
        <div class="sidebar-panel">

            <!-- Navigasi Kelola Data -->
            <div class="section-card">
                <div class="section-title">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    Kelola Data
                </div>
                <div class="nav-list">
                    <a href="pasien.php" class="nav-link-item">
                        <span>Data Pasien</span>
                        <small>&rarr;</small>
                    </a>
                    <a href="dokter.php" class="nav-link-item">
                        <span>Data Dokter</span>
                        <small>&rarr;</small>
                    </a>
                    <a href="pemeriksaan.php" class="nav-link-item">
                        <span>Data Pemeriksaan</span>
                        <small>&rarr;</small>
                    </a>
                    <a href="pembayaran.php" class="nav-link-item">
                        <span>Data Pembayaran</span>
                        <small>&rarr;</small>
                    </a>
                </div>
            </div>

            <!-- Tombol Logout -->
            <a href="logout.php" class="logout-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Logout
            </a>

        </div>

    </div>

    <div class="footer-note">
        &copy; <?= date('Y'); ?> Sistem Informasi Klinik • Layanan Medis
    </div>

</div>

</body>

</html>