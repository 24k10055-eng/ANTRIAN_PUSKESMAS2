<?php
include "koneksi.php";

$q = mysqli_query($conn, "SELECT nomor FROM antrian WHERE status='dipanggil' ORDER BY id DESC LIMIT 1");

if (mysqli_num_rows($q) > 0) {
    $row = mysqli_fetch_assoc($q);
    echo json_encode([
        "nomor" => $row['nomor'],
        "status" => "Sedang Dipanggil"
    ]);
} else {
    echo json_encode([
        "nomor" => "--",
        "status" => "Menunggu"
    ]);
}
?>
