<?php
session_start();
include "koneksi.php"; // pastikan file ini ada dan mendefinisikan $koneksi

// Proteksi: jika belum login, arahkan ke login_admin.php
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

// proses panggil / selesai
if (isset($_POST['panggil'])) {
    $nomor = mysqli_real_escape_string($koneksi, $_POST['nomor']);
    // set status antrian: ubah pasien dengan nomor ini menjadi dipanggil
    mysqli_query($koneksi, "UPDATE antrian SET status='dipanggil' WHERE nomor='$nomor'");
    // optional: bisa juga menyimpan ke tabel display jika pakai
}

if (isset($_POST['selesai'])) {
    // tandai yang sedang dipanggil selesai (atau bisa tandai berdasarkan nomor)
    mysqli_query($koneksi, "UPDATE antrian SET status='selesai' WHERE status='dipanggil'");
}

// ambil daftar pasien menunggu
$result = mysqli_query($koneksi, "SELECT * FROM antrian WHERE status='menunggu' ORDER BY id ASC");
if ($result === false) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel Admin Antrian</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- HEADER (tetap seperti milikmu) -->
<header>
    <img src="logo.png" alt="Logo Puskesmas">
    <button class="btn-hubungi">Hubungi Kami</button>
</header>

<h2 style="text-align:center; margin-top:20px;">Panel Admin - Panggil Antrian</h2>

<div class="container" style="max-width:900px; margin:20px auto; background:#fff; padding:20px; border-radius:10px;">
    <div style="display:flex; gap:20px; flex-wrap:wrap;">
        <div style="flex:1; min-width:300px;">
            <h3>Daftar Pasien Menunggu</h3>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="text-align:left; padding:8px;">No</th>
                            <th style="text-align:left; padding:8px;">Nomor</th>
                            <th style="text-align:left; padding:8px;">Nama</th>
                            <th style="text-align:left; padding:8px;">HP</th>
                            <th style="padding:8px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; while($row = mysqli_fetch_assoc($result)): ?>
                        <tr style="border-top:1px solid #eee;">
                            <td style="padding:8px;"><?= $i++ ?></td>
                            <td style="padding:8px; font-weight:700;"><?= htmlspecialchars($row['nomor']) ?></td>
                            <td style="padding:8px;"><?= htmlspecialchars($row['nama']) ?></td>
                            <td style="padding:8px;"><?= htmlspecialchars($row['hp']) ?></td>
                            <td style="padding:8px;">
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="nomor" value="<?= htmlspecialchars($row['nomor']) ?>">
                                    <button type="submit" name="panggil" style="padding:8px 12px; background:green; color:#fff; border:none; border-radius:6px; cursor:pointer;">
                                        Panggil
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada pasien menunggu.</p>
            <?php endif; ?>
        </div>

        <div style="width:320px;">
            <h3>Kontrol Panggilan</h3>
            <form method="POST">
                <label>Masukkan nomor (opsional panggil manual)</label>
                <input type="text" name="nomor" placeholder="Contoh: A001" style="width:100%; padding:8px; margin-top:6px;">
                <button type="submit" name="panggil" style="width:100%; margin-top:10px; padding:10px; background:green; color:#fff; border:none; border-radius:8px;">Panggil Nomor</button>
            </form>

            <form method="POST" style="margin-top:12px;">
                <button type="submit" name="selesai" style="width:100%; padding:10px; background:red; color:#fff; border:none; border-radius:8px;">Tandai Selesai (Hentikan Panggilan)</button>
            </form>
        </div>
    </div>
</div>

<!-- FOOTER (tetap seperti milikmu) -->
<footer>
    <p>Tentang Puskesmas Sehat Sentosa</p>
    <div class="tentang">
        <ul class="kami">
            <li> <img src="facebook.png"> <a href="facebook.html">Facebbok</a></li>
            <li> <img src="instagram.png"> <a href="instagram.html">Instagram</a></li>
            <li> <img src="tiktok.png"> <a href="tiktok.html">TikTok</a></li>
            <li> <img src="youtube.png"> <a href="youtube.html">YouTube</a></li>
            <li> <img src="twitter.png"> <a href="twitter.html">Twitter</a></li>
        </ul>
    </div>
    <p>©2025 Website Puskesmas Sehat Sentosa</p>
</footer>

</body>
</html>
