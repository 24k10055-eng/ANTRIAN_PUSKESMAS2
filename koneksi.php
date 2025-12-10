<?php
$koneksi = mysqli_connect("localhost", "root", "", "puskesmas182");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Tambahan penting!
// Banyak file memakai variabel $conn, maka kita samakan saja
$conn = $koneksi;
?>
