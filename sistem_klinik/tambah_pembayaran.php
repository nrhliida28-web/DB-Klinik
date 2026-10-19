<?php
session_start();
include 'koneksi.php'; // Panggil sambungan ke database

if (isset($_POST['simpan'])) {
    $id_pemeriksaan = $_POST['id_pemeriksaan'];
    $biaya_pemeriksaan = $_POST['biaya_pemeriksaan'];
    $biaya_obat = $_POST['biaya_obat'];
    
    // Hitung otomatis: Biaya Periksa + Biaya Obat
    $total_bayar = $biaya_pemeriksaan + $biaya_obat; 
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Simpan ke laci database pembayaran
    $simpan = mysqli_query($koneksi, "INSERT INTO pembayaran (id_pemeriksaan, biaya_pemeriksaan, biaya_obat, total_bayar, metode_pembayaran) 
              VALUES ('$id_pemeriksaan', '$biaya_pemeriksaan', '$biaya_obat', '$total_bayar', '$metode_pembayaran')");

    if ($simpan) {
        header("Location: pembayaran.php");
    } else {
        echo "Gagal menyimpan data!";
    }
}

// Ambil daftar pasien yang habis diperiksa
$data_pemeriksaan = mysqli_query($koneksi, "SELECT pemeriksaan.id_pemeriksaan, pasien.nama_pasien FROM pemeriksaan JOIN pasien ON pemeriksaan.id_pasien = pasien.id_pasien");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div style="max-width: 500px; margin: 30px auto; font-family: sans-serif;">
        <a href="index.php">&leftarrow; Kembali ke Dashboard</a>
        <h2>Bayar Kasir Klinik</h2>

        <form action="" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
            <label>Pilih Pasien:</label>
            <select name="id_pemeriksaan" required style="padding: 8px; border-radius: 6px;">
                <option value="">-- Pilih Pasien --</option>
                <?php while ($p = mysqli_fetch_assoc($data_pemeriksaan)) : ?>
                    <option value="<?= $p['id_pemeriksaan']; ?>"><?= $p['nama_pasien']; ?></option>
                <?php endwhile; ?>
            </select>

            <label>Biaya Dokter / Periksa (Rp):</label>
            <input type="number" name="biaya_pemeriksaan" required placeholder="Contoh: 50000" style="padding: 8px; border-radius: 6px;">

            <label>Biaya Obat (Rp):</label>
            <input type="number" name="biaya_obat" value="0" style="padding: 8px; border-radius: 6px;">

            <label>Metode Pembayaran:</label>
            <select name="metode_pembayaran" style="padding: 8px; border-radius: 6px;">
                <option value="Tunai">Tunai</option>
                <option value="Transfer">Transfer</option>
                <option value="QRIS">QRIS</option>
            </select>

            <button type="submit" name="simpan" style="background: #e8505b; color: white; padding: 10px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
                Simpan & Bayar
            </button>
        </form>
    </div>
</body>
</html>