<?php
session_name("USERSESSID");
session_start();
require '../login/config.php';

// cek login
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'users') {
  header("Location: ../login/login.php");
  exit;
}
// Menampilkan halaman "Koleksi Buku" pada website perpustakaan GRIYABACA.ID.
?>

<?php
$judulHalaman = "Koleksi Buku | Perpustakaan GRIYABACA.ID";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $judulHalaman ?></title>
  <link rel="icon" type="image/png" href="../img/Logo Bulat Griyabaca.id.png">
  <link rel="stylesheet" href="../css/kategori.css">
</head>

<body>
  <?php include '../navbar.php'; ?>
  <section class="collection-section" id="koleksi">
    <div class="collection-container">
      <h2 class="collection-title">Koleksi Buku</h2>
      <p class="collection-desc">Berikut adalah beberapa kategori buku yang tersedia di <b>GRIYABACA.ID</b>. Temukan buku favoritmu!</p>

      <div class="collection-grid">
<?php
$koleksi = [
  ["Fiksi", "Novel, cerpen, sastra klasik dan modern dari berbagai genre dan negara.", "buku_fiksi.php", "fiksi"], 
  ["Fantasy", "Sihir. Mitos. Petualangan. Temukan dunia yang tak terbatas di setiap halaman.", "buku_fantasy.php", "fantasy"],
  ["Sejarah", "Buku sejarah, biografi tokoh, dan catatan peristiwa penting.", "buku_sejarah.php", "sejarah"],
  ["Bisnis", "Buku manajemen, ekonomi, investasi, dan kewirausahaan.", "buku_bisnis.php", "bisnis"]
];

foreach ($koleksi as $item) {
  $slug = $item[3]; // class tambahan
  echo "<a href='list_buku.php#$slug' class='collection-item $slug'>";
  echo "<h3>{$item[0]}</h3>";
  echo "<p>{$item[1]}</p>";
  echo "</a>";
}
?>

      </div>
    </div>
  </section>

  <div class="center-link">
    <a href="../perpustakaan/perpustakaan.php">Kembali ke Halaman Utama</a>
  </div>
  <?php include '../footer.php'; ?>
</body>
</html>