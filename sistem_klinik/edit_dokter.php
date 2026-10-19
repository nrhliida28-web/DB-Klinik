<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM dokter WHERE id_dokter = '$id'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $nama_dokter = $_POST['nama_dokter'];
    $spesialis   = $_POST['spesialis'];
    $no_telp     = $_POST['no_telp'];

    $update = mysqli_query($koneksi, "UPDATE dokter SET 
        nama_dokter = '$nama_dokter', 
        spesialis   = '$spesialis', 
        no_telp     = '$no_telp' 
        WHERE id_dokter = '$id'");

    if ($update) {
        header("Location: dokter.php");
        exit;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dokter - Sistem Informasi Klinik</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #faf0f2; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .container { background: #ffffff; border: 1px solid #f0ced6; border-radius: 20px; padding: 36px 32px; width: 100%; max-width: 500px; box-shadow: 0 12px 32px rgba(216, 90, 127, 0.08); }
        h2 { margin-bottom: 20px; color: #2c2c2c; font-size: 20px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
        input { width: 100%; padding: 10px 14px; border: 1px solid #e2d1d6; border-radius: 8px; font-size: 13px; outline: none; }
        input:focus { border-color: #d85a7f; }
        .btn-group { display: flex; gap: 10px; margin-top: 20px; }
        .btn { flex: 1; padding: 10px; border-radius: 8px; border: none; font-size: 13px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; }
        .btn-simpan { background-color: #d85a7f; color: #fff; }
        .btn-batal { background-color: #f2f2f2; color: #555; }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Data Dokter</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label>Nama Dokter</label>
            <input type="text" name="nama_dokter" value="<?= htmlspecialchars($data['nama_dokter']) ?>" required>
        </div>
        <div class="form-group">
            <label>Spesialis</label>
            <input type="text" name="spesialis" value="<?= htmlspecialchars($data['spesialis']) ?>" required>
        </div>
        <div class="form-group">
            <label>No. Telepon</label>
            <input type="text" name="no_telp" value="<?= htmlspecialchars($data['no_telp']) ?>" required>
        </div>
        <div class="btn-group">
            <a href="dokter.php" class="btn btn-batal">Batal</a>
            <button type="submit" name="update" class="btn btn-simpan">Simpan Perubahan</button>
        </div>
    </form>
</div>
</body>
</html>