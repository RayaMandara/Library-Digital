<?php
session_name("USERSESSID");
session_start();
require '../login/config.php';

// cek login
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'users') {
  header("Location: ../login/login.php");
  exit;
}

// ambil data user
$user_id = $_SESSION['id'];
$user = $mysqli->query("SELECT * FROM user WHERE id='$user_id'")->fetch_assoc();

// ambil data peminjaman user
$sql = "SELECT p.*, b.title, b.cover, b.pdf 
        FROM peminjaman p
        JOIN books b ON p.book_id = b.id
        WHERE p.user_id = '$user_id'
        ORDER BY p.id DESC";
$result = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Dashboard User</title>
  <link rel="stylesheet" href="../css/dashboard_user.css">
</head>
<?php include '../navbar.php'; ?>

<body>
  <div class="container">
    <h2>Selamat Datang, <?= htmlspecialchars($user['username']); ?>!</h2>

    <!-- tombol navigasi -->
    <p>
      <a href="perpustakaan.php" class="btn-link">Kembali</a>
      <a href="../books/kategori.php" class="btn-link">Lihat Daftar Buku</a>
      <a href="../logout/logout_user.php" class="btn-logout">Logout</a>
    </p>

    <h3>Riwayat Peminjaman Buku</h3>
    <table>
      <thead>
        <tr>
          <th>Cover Buku</th>
          <th>Judul Buku</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
          <th>Baca Buku</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td data-label="Cover Buku">
                <?php if (!empty($row['cover'])): ?>
                  <?php
                  // cek apakah cover berupa URL atau nama file
                  $coverPath = (filter_var($row['cover'], FILTER_VALIDATE_URL))
                    ? $row['cover']
                    : "../uploads/covers/" . $row['cover'];
                  ?>
                  <img src="<?= htmlspecialchars($coverPath); ?>"
                    alt="Cover Buku"
                    style="width:60px; height:80px; object-fit:cover; border-radius:5px;">
                <?php else: ?>
                  <span style="color:gray;">Tidak ada cover</span>
                <?php endif; ?>
              </td>
              <td data-label="Judul Buku"><?= htmlspecialchars($row['title']); ?></td>
              <td data-label="Tanggal Pinjam"><?= htmlspecialchars($row['tgl_pinjam']); ?></td>
              <td data-label="Tanggal Kembali"><?= htmlspecialchars($row['tgl_kembali']); ?></td>
              <td data-label="Baca Buku">
                <?php
                // Cek apakah status BUKAN 'selesai' dan BUKAN 'ditolak'
                $canRead = in_array($row['status'], ['dipinjam', 'diterima',]);
                ?>
                <?php if (!empty($row['pdf']) && $canRead): ?>
                  <a href="../uploads/pdf/<?= $row['pdf'] ?>" target="_blank" class="btn-baca">Baca Buku</a>
                <?php else: ?>
                  <span class="btn-baca btn-disabled">Baca Buku</span>
                <?php endif; ?>
              </td>
              <td data-label="Status">
                <?php if ($row['status'] === 'pending'): ?>
                  <span class="status pending">Pending</span>

                <?php elseif ($row['status'] === 'dipinjam' || $row['status'] === 'diterima'): ?>
                  <form action="../books/kembalikan.php" method="post" style="display:inline;">
                    <input type="hidden" name="id_peminjaman" value="<?= $row['id']; ?>">
                    <button type="submit" class="btn-kembali"
                      onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                      Kembalikan
                    </button>
                  </form>

                <?php elseif ($row['status'] === 'selesai'): ?>
                  <span class="status selesai">Selesai</span>

                <?php elseif ($row['status'] === 'ditolak'): ?>
                  <span class="status ditolak">Ditolak</span>

                <?php else: ?>
                  <?= htmlspecialchars($row['status']); ?>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" style="text-align:center;">Belum ada data peminjaman</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php include '../footer.php'; ?>
</body>

</html>