<?php
session_name("PETUGASSESSID");
session_start();
require '../login/config.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'petugas') {
  header("Location: ../login/login.php");
  exit;
}

// Ambil data peminjaman,* = ambil semua kolom dari p = table peminjaman, b = table books
$sql_pinjam = "SELECT p.*, b.title 
  FROM peminjaman p 
  JOIN books b ON p.book_id = b.id 
  ORDER BY p.id DESC"; // Id akan Diurutkan Dari Yang Terbaru 
$result_pinjam = $mysqli->query($sql_pinjam);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Peminjaman</title>
  <link rel="stylesheet" href="../css/data_peminjam.css">

</head>

<body>
  <div class="container">
    <h2>Data Peminjaman Buku</h2>
    <a href="dashboard_petugas.php" class="back-link">Kembali ke Dashboard</a>

    <?php if ($result_pinjam && $result_pinjam->num_rows > 0): ?>
      <table>
        <tr>
          <th>ID</th>
          <th>Nama Peminjam</th>
          <th>No. Telp</th>
          <th>Judul Buku</th>
          <th>Tgl Pinjam</th>
          <th>Tgl Kembali</th>
          <th>Status</th>
          <th>Aksi</th>
          <th>Cetak</th>
        </tr>

        <!-- Untuk Menampilkan Data Peminjam -->
        <?php while ($row = $result_pinjam->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nama_peminjam']) ?></td>
            <td><?= htmlspecialchars($row['no_telp']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= $row['tgl_pinjam'] ?></td>
            <td><?= $row['tgl_kembali'] ?></td>

            <!-- Status Peminjaman -->
            <td>
              <?php if ($row['status'] === 'pending'): ?>
                <span class="status-tag status-pending">Pending</span>
              <?php elseif ($row['status'] === 'dipinjam'): ?>
                <span class="status-tag status-dipinjam">Dipinjam</span>
              <?php elseif ($row['status'] === 'selesai'): ?>
                <span class="status-tag status-selesai">Dikembalikan</span> 
              <?php elseif ($row['status'] === 'ditolak'): ?>
                <span class="status-tag status-ditolak">Ditolak</span>
              <?php endif; ?>
            </td>


            <!-- Tombol Aksi, Di gunakan Untuk Menerima/Menolak Peminjaman Buku -->
            <td>
              <?php if ($row['status'] === "pending"): ?>
                <a href="aksi_peminjaman.php?id=<?= $row['id'] ?>&aksi=terima"
                  class="btn btn-terima"
                  onclick="return confirm('Terima peminjaman ini?')">Terima</a>
                <a href="aksi_peminjaman.php?id=<?= $row['id'] ?>&aksi=tolak"
                  class="btn btn-tolak"
                  onclick="return confirm('Tolak peminjaman ini?')">Tolak</a>

              <?php elseif ($row['status'] === "dipinjam"): ?>
                <a href="aksi_peminjaman.php?id=<?= $row['id'] ?>&aksi=selesai"
                  class="btn btn-selesai"
                  onclick="return confirm('Tandai buku ini sudah dikembalikan?')">Selesai</a>
              <?php else: ?>
                <span style="color:#777; font-weight: bold;">Selesai</span>
              <?php endif; ?>
            </td>

            <!-- Tombol Untuk Mencetak Bukti Peminjaman -->
            <td>
              <?php if ($row['status'] === "dipinjam" || $row['status'] === "selesai" || $row['status'] === 'ditolak'): ?>
                <a href="cetak_peminjaman.php?id=<?= $row['id'] ?>" target="_blank"
                  class="btn btn-cetak">
                  Cetak Bukti
                </a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p style="color:#777;">Belum ada data peminjaman.</p>
    <?php endif; ?>
  </div>
</body>

</html>