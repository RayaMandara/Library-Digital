<?php
session_name("USERSESSID");
session_start();
require '../login/config.php';

// cek login
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'users') {
  header("Location: ../login/login.php");
  exit;
}

$category = ["Fiksi", "Fantasy", "Sejarah", "Bisnis"];
// Menampilkan halaman daftar lengkap buku (List Buku) dari berbagai kategori
?>

<!DOCTYPE html>
<html lang="id"></html>

<head>
  <meta charset="UTF-8">
  <title>List Buku</title>
  <link rel="icon" type="image/png" href="../img/Logo Bulat Griyabaca.id.png">
  <link rel="stylesheet" href="../css/list_buku.css">
</head>

<body>
  <?php include '../navbar.php'; ?>
  <div class="book-container">
    <h2>📚 Daftar Buku Kami</h2>
    <?php if (isset($_GET['pinjam_success'])): ?>
      <p style="color:green;">✅ Buku berhasil dipinjam!</p>
      <script>
        setTimeout(() => {
          window.location.href = 'list_buku.php';
        }, 2000);
      </script>
    <?php endif; ?>
    
    <?php foreach ($category as $cat): ?>
      <?php $catSlug = strtolower(str_replace(" ", "_", $cat)); ?>
      <h3 id="<?= $catSlug ?>" class="category-title"><?= $cat ?></h3> 
      <div class="book-list">
        <?php
        $sql = "SELECT * FROM books WHERE category='$cat' ORDER BY title ASC";
        $result = $mysqli->query($sql);
        if ($result && $result->num_rows > 0):
          while ($row = $result->fetch_assoc()):
        ?>
        <div class="book-card">
          <img src="../uploads/covers/<?= $row['cover'] ?>" alt="<?= $row['title']; ?>">
          
          <div class="book-details-wrapper"> 
            <div class="book-info">
              <h3 class="book-title"><?= $row['title']; ?></h3>
              <p class="book-author">✍️ <?= $row['author']; ?></p>
              <p class="book-year">📅 <?= $row['year']; ?></p>
              <p class="book-stock">Stok Buku : <?= $row['stok'] ?></p> 
            </div>
            
            <div class="btn-group">
              <?php if (isset($_SESSION['id'])): ?>
                <a href="form_pinjam.php?book_id=<?= $row['id']; ?>" class="btn btn-pinjam">Pinjam Buku</a>
              <?php else: ?>
                <a href="../login/login.php" class="btn btn-pinjam">Pinjam Buku</a>
              <?php endif; ?> 
            </div>
          </div>
        </div>
        <?php
          endwhile;
        else:
          echo "<p class='empty'>Belum ada buku di kategori ini.</p>";
        endif;
        ?>
      </div>
      <hr>
    <?php endforeach; ?>
  </div>
  <?php include '../footer.php'; ?>
</body>
</html>
