<?php
session_name("PETUGASSESSID");
session_start();
require '../login/config.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'petugas') {
    header("Location: ../login/login.php");
    exit;
}

// Proses Tambah Data Buku
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['simpan'])) {
    $title    = $_POST['title'];
    $author   = $_POST['author'];
    $year     = $_POST['year'];
    $category = $_POST['category'];
    $stok     = $_POST['stok'];

    //Untuk Menyimpan File Covers (Cover Buku) Dan PDF (Isi Buku)
    $cover_dir = __DIR__ . "/../uploads/covers/";
    $pdf_dir   = __DIR__ . "/../uploads/pdf/";

    // Buat folder jika belum ada
    if (!is_dir($cover_dir)) mkdir($cover_dir, 0777, true); // 0777 -> Folder Bisa Di Baca,Gunakan, Dan Dijalankan Oleh semua User
    if (!is_dir($pdf_dir)) mkdir($pdf_dir, 0777, true);

    // Upload Cover Buku
    $coverName = "";
    if (!empty($_FILES["cover"]["name"])) {
        $coverName = basename($_FILES["cover"]["name"]);
        move_uploaded_file($_FILES["cover"]["tmp_name"], $cover_dir . $coverName);
    }

    // Upload PDF
    $pdfName = "";
    if (!empty($_FILES["pdf"]["name"])) {
        $pdfName = basename($_FILES["pdf"]["name"]);
        move_uploaded_file($_FILES["pdf"]["tmp_name"], $pdf_dir . $pdfName);
    }

    // Simpan ke database
    $sql = "INSERT INTO books (title, author, year, category, cover, pdf, status, stok)
            VALUES ('$title', '$author', '$year', '$category', '$coverName', '$pdfName', 'tersedia', '$stok')";
    if ($mysqli->query($sql)) {
        header("Location: dashboard_petugas.php?success=1");
        exit;
    } else {
        echo '❌ Error: ' . $mysqli->error;
    }
}

// Digunakan Untuk Mengambil Data Buku yang Akan Di Tampilkan Di Halaman Ini
$sql = "SELECT * FROM books ORDER BY id DESC";
$result = $mysqli->query($sql);
if (!$result) die("Query gagal: " . $mysqli->error);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas</title>
    <link rel="stylesheet" href="../css/petugas.css">
</head>
<body>
    <div class="container">
        <h2>Selamat datang, <?= htmlspecialchars($_SESSION['username']); ?></h2>
        <h2 style="color: #3f72af;">Kelola Buku</h2>
        <div>
            <div class="back" style="margin-bottom:20px;">
                <a href="../logout/logout_petugas.php">Logout</a>
            </div>
            <a href="ubah_password.php" class="ubah-password">🔑 Ubah Password</a>
            <a href="data_peminjaman.php" class="ubah-password">📑 Data Peminjaman</a>
        </div><br>

        <!-- Notifikasi Buku Berhasil Di Tambahkan Dan Berhasil Di Hapus -->

        <!-- Buku Berhasil Di Tambahkan -->
        <?php if (isset($_GET['success'])): ?>
            <p style="color: green;">✅ Buku berhasil ditambahkan!</p>
            <!-- Buku Berhasil Di Hapus -->
        <?php elseif (isset($_GET['deleted'])): ?>
            <p style="color:red;">🗑️ Buku berhasil dihapus!</p>
        <?php endif; ?>


        <!-- FORM TAMBAH BUKU -->
        <form method="post" enctype="multipart/form-data" class="form-tambah">
            <label>Judul Buku</label>
            <input type="text" name="title" placeholder="Judul" required>

            <label>Penulis</label>
            <input type="text" name="author" placeholder="Penulis" required>

            <label>Tahun</label>
            <input type="number" name="year" placeholder="Tahun" required>

            <label>Kategori</label>
            <select name="category" required>
                <option value="" disabled selected hidden>-- Pilih Kategori --</option>
                <option value="Fiksi">Fiksi</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Sejarah">Sejarah</option>
                <option value="Bisnis">Bisnis</option>
            </select>

            <label>Upload PDF</label>
            <input type="file" name="pdf" accept=".pdf">

            <label>Upload Cover Buku</label>
            <input type="file" name="cover" required>

            <label>Stok</label>
            <input type="number" name="stok" placeholder="Stok Buku" min="0" required>

            <button type="submit" name="simpan">Tambah Buku</button>
        </form>

        <!-- Bagian Ini Untuk Mengurutkan Urutan Buku Yang Ada Di table, Dimulai Dari Kategori Fiksi Dst -->
        <?php
        $categories = ["Fiksi", "Fantasy", "Sejarah", "Bisnis"];
        foreach ($categories as $cat):
            $books = $mysqli->query("SELECT * FROM books WHERE category='$cat' ORDER BY id DESC");
            if ($books && $books->num_rows > 0):
        ?>
                <h3 style="margin-top:30px;"><?= $cat ?></h3>
                <table border="1" cellpadding="8" style="margin-top:10px;width:100%;text-align:center;">
                    <tr style="background:#f2f2f2;">
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th>Kategori</th>
                        <th>Cover</th>
                        <th>PDF</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                    <!-- Digunakan Untuk Menanmpilkan Data Buku Yang Diambil Dari Database -->
                    <?php while ($row = $books->fetch_assoc()): ?>
                        <tr>

                            <!-- Table Data Buku -->
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['title'] ?></td>
                            <td><?= $row['author'] ?></td>
                            <td><?= $row['year'] ?></td>
                            <td><?= $row['category'] ?></td>
                            <td><img src="../uploads/covers/<?= $row['cover'] ?>" width="60"></td>
                            <td>
                                <!-- Link PDF Untuk Melihat Isi Buku -->
                                <?php if (!empty($row['pdf'])): ?>
                                    <a href="../uploads/pdf/<?= $row['pdf'] ?>" target="_blank">Lihat PDF</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?= $row['stok'] ?></td>
                            <td>
                                <a href="../books/edit_buku.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a> |
                                <a href="../books/hapus_buku.php?id=<?= $row['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
        <?php
            endif;
        endforeach;
        ?>
    </div>
</body>

</html>