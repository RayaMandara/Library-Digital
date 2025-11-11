<?php
session_name("USERSESSID");
session_start();
require '../login/config.php';

// Ambil data popular book dari database
$sql = "SELECT b.id, b.title, b.author, b.category, b.cover, 
               COUNT(p.book_id) AS total_pinjam
        FROM peminjaman p
        JOIN books b ON p.book_id = b.id
        WHERE p.status = 'selesai'
        GROUP BY p.book_id
        ORDER BY total_pinjam DESC
        LIMIT 4";

$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Griyabaca.ID</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/perpustakaan.css" />
  <link rel="icon" type="image/png" href="../img/Logo Bulat Griyabaca.id.png">
</head>
<body>
  <!-- NAVBAR -->
  <header class="navbar">
    <div class="container nav-content">
      <h1 class="logo">GRIYABACA.ID</h1>
      <nav>
        <ul>
          <li><a href="#home">Beranda</a></li>
          <li><a href="dashboard_user.php">Dashboard</a></li>
          <li><a href="#tentang">Tentang Kami</a></li>
          <li><a href="../books/list_buku.php">Buku</a></li>
          <li><a href="#kontak">Kontak</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- HERO -->
  <section id="home" class="hero">
    <div class="container hero-content">
      <div class="hero-text">
        <p class="tagline">Rumah Buku Digital, Ilmu Tanpa Batas</p>
        <h2>Temukan Ribuan Buku Digital,<br>Kapan Pun Kamu Mau</h2>
        <p class="sub">Teknologi dan Buku Bersatu, Memberi Pengalaman Membaca Tanpa Batas</p>
        <a href="#tentang" class="btn-primary">Baca Selengkapnya</a>
      </div>
      <div class="hero-img">
        <img src="../img/FOTO TENTANG KAMI.png" alt="Siswa membaca tablet" />
      </div>
    </div>
  </section>

  <!-- TENTANG KAMI -->
  <section id="tentang" class="about">
    <div class="container about-content">
      <div class="about-logo">
        <img src="../img/Logo Bulat Griyabaca.id.png" alt="Logo Griyabaca" />
      </div>
      <div class="about-text">
        <h3>Tentang Kami</h3>
        <h4>Visi</h4>
        <p>Menjadi perpustakaan digital yang menghasilkan pengalaman membaca modern, membuka akses pengetahuan tanpa batas, dan menumbuhkan budaya literasi untuk semua generasi.</p>

        <h4>Misi</h4>
        <ol>
          <li>Menyediakan koleksi buku digital yang beragam dan terus diperbarui.</li>
          <li>Menghadirkan ruang baca virtual yang nyaman dan mudah diakses kapan saja, di mana saja.</li>
          <li>Mendukung kebiasaan membaca dan belajar sepanjang hayat dengan teknologi inovatif.</li>
          <li>Menjadi mitra belajar dan inspirasi bagi masyarakat, pelajar, dan pecinta literasi.</li>
        </ol>

        <p>Griyabaca.ID percaya bahwa setiap buku adalah jendela menuju dunia baru. Perpustakaan digital ini hadir bukan sekadar tempat membaca, melainkan ruang untuk menjelajahi ide, menemukan inspirasi, dan menumbuhkan pengetahuan tanpa batas.</p>

        <a href="#populer" class="btn-primary">Lihat Buku Populer</a>
      </div>
    </div>
  </section>

  <!-- BUKU POPULER -->
  <section class="book-section" id="populer">
    <h1 class="title">Buku Populer</h1>
    <div class="book-grid">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="book-card">
          <img src="../uploads/covers/<?php echo $row['cover']; ?>" alt="<?php echo $row['title']; ?>">
          <div class="info">
            <p class="book-title">
              <?php echo $row['title']; ?><br>
              <span>oleh <?php echo $row['author']; ?></span>
            </p>
            <p class="genre"><?php echo $row['category']; ?></p>
            <p class="borrow-count">Dipinjam: <?php echo $row['total_pinjam']; ?>x</p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
    <div class="btn-view">
      <a href="../books/list_buku.php" class="view-all">Lihat Semua</a>
    </div>
  </section>

  <!-- HERO SECTION -->
  <section class="hero">
    <h1>MULAI PERJALANANMU HARI INI</h1>
    <p>
      <i>Bergabunglah dengan ribuan pembaca dan temukan buku favoritmu berikutnya. 
      Akses seluruh koleksi kami secara gratis.</i>
    </p>
    <div class="hero-buttons">
      <a href="../books/list_buku.php">jelajahi buku</a>
      <a href="../books/kategori.php">jelajahi kategori</a>
    </div>
  </section>
  <?php include '../footer.php'; ?>
</body>
</html>
