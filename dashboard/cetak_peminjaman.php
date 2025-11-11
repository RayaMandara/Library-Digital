<?php
session_name("PETUGASSESSID");
session_start();
require '../login/config.php';
date_default_timezone_set("Asia/Makassar"); // waktu bali
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'petugas') {
  header("Location: ../login/login.php");
  exit;
}

// Cek Id Peminjaman

if (!isset($_GET['id'])) {
  die("ID peminjaman tidak ditemukan.");
}


// Ambil Data Peminjaman Dari Database
$id = intval($_GET['id']);
//Ambil Dari * = Ambil Semua Kolom Dari p = Table Peminjaman, b = table books
$sql = "SELECT p.*, b.title, b.author, b.year,b.cover 
        FROM peminjaman p 
        JOIN books b ON p.book_id = b.id 
        WHERE p.id = $id";
$result = $mysqli->query($sql);
if (!$result || $result->num_rows === 0) {
  die("Data tidak ditemukan.");
}
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Peminjaman Buku</title>
  <style>
    body { 
      font-family: Arial, sans-serif; 
      margin: 40px; 
      color: #333; 
      background: #fff;
    }
    .wrapper { 
      border: 1px solid #ccc; 
      padding: 30px; 
      border-radius: 8px; 
      max-width: 700px; 
      margin: auto; 
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .header {
      text-align: center;
      margin-bottom: 15px;
    }
    .header img {
      width: 80px;
      height: auto;
      margin-bottom: 8px;
    }
    h2 { 
      color: #3f72af; 
      margin: 0; 
    }
    hr { 
      border: 0; 
      border-top: 2px solid #3f72af; 
      margin: 10px 0 20px;
    }
    table { 
      width: 100%; 
      border-collapse: collapse; 
      margin-top: 10px; 
    }
    td { 
      padding: 8px; 
      vertical-align: top; 
    }
    .label { 
      width: 40%; 
      font-weight: bold; 
      color: #222;
    }
    .footer { 
      text-align: center; 
      margin-top: 40px; 
      font-size: 14px; 
      color: #555; 
    }
    @media print {
      body { margin: 0; }
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="header">
      <img src="../img/Logo Bulat Griyabaca.id.png" alt="Logo Perpustakaan">
      <h2>BUKTI PEMINJAMAN BUKU</h2>
      <p style="margin:0;color:#555;">Perpustakaan GRIYABACA.ID</p>
    </div>
    <hr>

    <table>
      <tr>
        <td class="label">ID Peminjaman</td>
        <td>: <?= $data['id'] ?></td>
      </tr>
      <tr>
        <td class="label">Nama Peminjam</td>
        <td>: <?= htmlspecialchars($data['nama_peminjam']) ?></td>
      </tr>
      <tr>
        <td class="label">No. Telepon</td>
        <td>: <?= htmlspecialchars($data['no_telp']) ?></td>
      </tr>
      <tr>
        <td class="label">Judul Buku</td>
        <td>: <?= htmlspecialchars($data['title']) ?></td>
      </tr>
      <tr>
        <td class="label">Cover Buku</td>
        <td>  <img style="width: 100px;" src="../uploads/covers/<?= htmlspecialchars($data['cover']) ?>" alt="Cover Buku"></td>
      </tr>
      <tr>
        <td class="label">Penulis</td>
        <td>: <?= htmlspecialchars($data['author']) ?></td>
      </tr>
      <tr>
        <td class="label">Tahun Terbit</td>
        <td>: <?= htmlspecialchars($data['year']) ?></td>
      </tr>
      <tr>
        <td class="label">Tanggal Pinjam</td>
        <td>: <?= $data['tgl_pinjam'] ?></td>
      </tr>
      <tr>
        <td class="label">Tanggal Kembali</td>
        <td>: <?= $data['tgl_kembali'] ?></td>
      </tr>
      <tr>
        <td class="label">Status</td>
        <td>: <?= ucfirst($data['status']) ?></td>
      </tr>
    </table>

    <div class="footer">
      <p>Dicetak oleh: <?= htmlspecialchars($_SESSION['username']) ?></p>
      <p>Tanggal Cetak: <?= date("d-m-Y H:i") ?></p>
    </div>
  </div>

  <script>
    window.print();
  </script>
</body>
</html>
