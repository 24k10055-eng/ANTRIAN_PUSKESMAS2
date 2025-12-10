<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>DIFLAI — Menunggu & Upload</title>
<style>
@media (max-width:620px){ .top{flex-direction:column;align-items:flex-start} .controls{flex-direction:row;width:100%;justify-content:space-between} }
</style>
</head>
<body>
<div class="container" id="app">
<div class="top">
<div class="logo">DIF</div>
<div>
<h1>DIFLAI — Menunggu & Upload</h1>
<p class="sub">Splash screen + uploader. File yang diterima: dokumen (.docx, .pdf..) & video (.mp4, .mov..).</p>
</div>
</div>

<div class="splash" role="status" aria-live="polite">
<div class="progress">
<div class="progress-bar" aria-hidden="true"><div class="bar" id="bar"></div></div>
<div class="progress-info"><span id="phase">Inisialisasi</span><span id="percent">0%</span></div>
</div>
<div class="controls">
<button class="btn" id="details">Detail</button>
<button class="btn primary" id="skip">Skip</button>
</div>
</div>

<form id="uploadForm" method="post" enctype="multipart/form-data" novalidate>
<label id="dropZone" class="upload-area">
<strong>Seret & lepas file di sini</strong><br>
atau klik untuk pilih file<br>
<span class="note">Accepted: .doc .docx .epub .gdoc .odt .oth .ott .pdf .rtf & video (.3gp .mp4 .mov .avi .webm ...)</span>
<input type="file" name="file" id="fileInput" />
</label>
<div style="display:flex;gap:8px;margin-top:10px;">
<button type="submit" class="btn primary">Upload</button>
<button type="button" class="btn" id="clearBtn">Batal</button>
</div>
</form>

<?php if ($serverMessage): ?>
<div class="msg <?php echo (strpos($serverMessage,'gagal')!==false || strpos($serverMessage,'tidak didukung')!==false || strpos($serverMessage,'terlalu besar')!==false) ? 'err' : ''; ?>">
<?php echo htmlspecialchars($serverMessage); ?>
</div>
<?php endif; ?>

<div style="margin-top:14px;color:var(--muted);font-size:13px">
<strong>Catatan server:</strong> file disimpan ke folder <code>uploads/</code>. Ubah $maxFileSize di file PHP bila perlu.
</div>
</div>

<script>
const phases = [
{name:'Memeriksa', ms:700},
{name:'Memuat aset', ms:900},
{name:'Cek koneksi', ms:500},
{name:'Sinkronisasi', ms:1000},
{name:'Siap', ms:400}
];
</script>
</body>
</html>
