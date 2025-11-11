<?php
session_name("USERSESSID");
session_start();
require '../login/config.php';

// cek login
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'users') {
  header("Location: ../login/login.php");
  exit;
}

$book_id = intval($_GET['book_id']);
$book = $mysqli->query("SELECT * FROM books WHERE id=$book_id")->fetch_assoc();
if (!$book) die("Buku tidak ditemukan.");

// 🔹 Ambil data user
$user_id = $_SESSION['id'];
$user = $mysqli->query("SELECT * FROM user WHERE id = $user_id")->fetch_assoc();

// Tentukan tanggal pinjam & tanggal kembali otomatis
$tgl_pinjam = date('Y-m-d');
$tgl_kembali = date('Y-m-d', strtotime($tgl_pinjam . ' +7 days'));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // cek stok dulu
  if ($book['stok'] > 0) {
    $nama   = $_POST['nama'];
    $telp   = $_POST['no_telp'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];

    // insert peminjaman
    $sql = "INSERT INTO peminjaman (user_id, nama_peminjam, no_telp, book_id, tgl_pinjam, tgl_kembali, status)
                VALUES ('$user_id', '$nama', '$telp', '$book_id', '$tgl_pinjam', '$tgl_kembali', 'pending')";

    if ($mysqli->query($sql)) {
      echo "<script>alert('Peminjaman sedang diproses, tunggu konfirmasi petugas.');window.location='../perpustakaan/dashboard_user.php';</script>";
    } else {
      echo "❌ Error: " . $mysqli->error;
    }
  } else {
    echo "<script>alert('⚠️ Stok buku habis, tidak bisa dipinjam.');window.location='list_buku.php';</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Pinjam Buku</title>
  <link rel="icon" type="image/png" href="../img/Logo Bulat Griyabaca.id.png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/form_pinjam.css">
</head>

<body>

  <!-- NAVBAR -->
  <header class="navbar">
    <div class="container nav-content">
      <nav>
        <ul>
          <li><a href="list_buku.php">⬅ Kembali</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="main-content-wrapper">
    <!-- Kiri -->
    <div class="left-column">
      <div class="book-detail">
        <img src="../uploads/covers/<?= $book['cover'] ?>" alt="<?= htmlspecialchars($book['title']) ?>" width="120">

        <div>
          <p><b><?= htmlspecialchars($book['title']) ?></b></p>
          <p>Penulis: <?= htmlspecialchars($book['author']) ?></p>
        </div>
      </div>
    </div>

    <!-- Kanan -->
    <div class="right-column">
      <form method="POST">
        <label>Username</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($user['username']); ?>" readonly required>

        <label>Nomor Telepon</label>
        <input type="text" name="no_telp" value="<?= htmlspecialchars($user['number']); ?>" required>

        <label>Tanggal Pinjam</label>
        <input type="date" name="tgl_pinjam" value="<?= date('Y-m-d'); ?>" readonly required>

        <label>Tanggal Kembali</label>
        <input type="date" name="tgl_kembali" value="<?= $tgl_kembali; ?>" required>
        <small style="color: gray; margin-top: -10px;">Tanggal pengembalian otomatis +7 hari dari tanggal pinjam.</small>

        <button type="submit">Pinjam</button>
      </form>
    </div>
  </div>
</body>

</html>