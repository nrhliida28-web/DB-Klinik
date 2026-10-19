<?php

session_start();

// Cek status login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Ambil ID dokter dari URL
$id_dokter = $_GET['id'] ?? null;

if ($id_dokter) {
    // Sanitasi input ID untuk keamanan
    $id_dokter = mysqli_real_escape_string($koneksi, $id_dokter);

    // Query untuk menghapus data dokter
    $hapus = mysqli_query($koneksi, "DELETE FROM dokter WHERE id_dokter = '$id_dokter'");

    if ($hapus) {
        echo "<script>
                alert('Data dokter berhasil dihapus!');
                window.location.href = 'dokter.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data dokter: " . mysqli_error($koneksi) . "');
                window.location.href = 'dokter.php';
              </script>";
    }
} else {
    // Jika tidak ada parameter ID, kembalikan ke halaman dokter
    header("Location: dokter.php");
    exit;
}

?>