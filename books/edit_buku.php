<?php          
session_name("PETUGASSESSID");
session_start();
require '../login/config.php';

// cek login admin/petugas
if (!isset($_SESSION['id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas')) {
    header("Location: ../login/login.php");
    exit;
}
// mengambil data buku berdasarkan id
$id = $_GET['id'];
$data = $mysqli->query("SELECT * FROM books WHERE id='$id'")->fetch_assoc();

// menyimpan perubahan 
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $category = $_POST['category'];
    $stok = $_POST['stok'];
    $cover = $data['cover'];
    $pdf = $data['pdf'];

    // jika ganti cover
    if (!empty($_FILES['cover']['name'])) {
        $cover = time() . "_" . $_FILES['cover']['name'];
        $tmp = $_FILES['cover']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/covers/" . $cover);
    }

    // jika ganti pdf
    if (!empty($_FILES['pdf']['name'])) {
        $pdf = time() . "_" . $_FILES['pdf']['name'];
        $tmp_pdf = $_FILES['pdf']['tmp_name'];
        move_uploaded_file($tmp_pdf, "../uploads/pdf/" . $pdf);
    }

    // update data ke database
    $sql = "UPDATE books 
            SET title='$title', author='$author', year='$year', category='$category', stok='$stok', cover='$cover', pdf='$pdf'
            WHERE id='$id'";

// mengarahkan ke dashboard
    if ($mysqli->query($sql)) {
        echo "<script>alert('Data buku berhasil diperbarui!'); window.location='../dashboard/dashboard_petugas.php';</script>";
    } else {
        echo "❌ Error: " . $mysqli->error;
    }
}
// untuk melihat dan mengubah data buku yang sudah ada di database dan mengirimkan perubahan tersebut kembali ke server untuk diperbarui.
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Buku</title>
    <link rel="stylesheet" href="../css/edit_buku.css">
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <h2>Edit Data Buku</h2>

        <label>Judul Buku:</label>
        <input type="text" name="title" value="<?= $data['title'] ?>" required>

        <label>Penulis:</label>
        <input type="text" name="author" value="<?= $data['author'] ?>" required>

        <label>Tahun:</label>
        <input type="number" name="year" value="<?= $data['year'] ?>" required>

        <label>Kategori:</label>
        <select name="category" required>
            <option value="" disabled hidden>-- Pilih Kategori --</option>
            <option value="Fiksi" <?= $data['category'] === 'Fiksi' ? 'selected' : '' ?>>Fiksi</option>
            <option value="Fantasy" <?= $data['category'] === 'Fantasy' ? 'selected' : '' ?>>Fantasy</option>
            <option value="Sejarah" <?= $data['category'] === 'Sejarah' ? 'selected' : '' ?>>Sejarah</option>
            <option value="Bisnis" <?= $data['category'] === 'Bisnis' ? 'selected' : '' ?>>Bisnis</option>
        </select>

        <label>Stok:</label>
        <input type="number" name="stok" value="<?= $data['stok'] ?>" min="0" required>

        <label>Cover Buku (opsional):</label>
        <input type="file" name="cover" accept="image/*">
        <small class="note">Biarkan kosong jika tidak ingin ganti cover</small>

        <label>File PDF Buku (opsional):</label>
        <input type="file" name="pdf" accept="application/pdf">
        <small class="note">Biarkan kosong jika tidak ingin ganti file PDF</small>

        <?php if (!empty($data['pdf'])): ?>
            <p>PDF saat ini:
                <a href="../uploads/pdf/<?= $data['pdf'] ?>" target="_blank">Lihat PDF</a>
            </p>
        <?php endif; ?>

        <div class="button-group">
            <button type="submit" name="update">Simpan</button>
            <a href="../dashboard/dashboard_petugas.php" class="btn-kembali">Kembali</a>
        </div>
    </form>
</body>

</html>