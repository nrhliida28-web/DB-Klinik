<?php
$koneksi = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_klinik"
);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());

}
?>