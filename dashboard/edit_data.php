<?php
session_name("ADMINSESSID");
session_start();
require '../login/config.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.php");
    exit;
}

// Untuk Mengambil Data User Yang Mau Diedit, Lalu Simpan Di Variabel $data
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc(); 

// Ini untuk Proses Menyimpan Data
if (isset($_POST['simpan'])) {
    $username = trim($_POST['username']);
    $name     = trim($_POST['name']);
    $number   = trim($_POST['number']);

    // Untuk Mengecek Apakah Uername Sudah Digunakan Oleh User Lain
    $check = $mysqli->prepare("SELECT id FROM user WHERE username = ? AND id != ?");
    $check->bind_param("si", $username, $id);
    $check->execute();
    $check->store_result();

    // Kalau Username Sudah Di Pakai Orang Lain
    if ($check->num_rows > 0) {
        echo "<script>alert('❌ Username sudah digunakan!');history.back();</script>";
    } else {

    // Jika Update Data Berhasil Dan Akan Di simpan Ke Database
        $update = $mysqli->prepare("UPDATE user SET username=?, name=?, number=? WHERE id=?");
        $update->bind_param("sssi", $username, $name, $number, $id);

        if ($update->execute()) {
            echo "<script>alert('✅ Data berhasil diupdate!');window.location='dashboard_admin.php';</script>";
        } else {
            echo "Error: " . $update->error;
        }
        $update->close();
    }

    $check->close();
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Data Petugas</title>
</head>
<link rel="stylesheet" href="../css/edit_data.css">

<body>
  <div class="container">
    <h2>Edit Data</h2>
    <form method="post">
      <input type="text" name="username" placeholder="Username" value="<?php echo $data['username']; ?>" required>
      <input type="text" name="name" placeholder="Nama" value="<?php echo $data['name']; ?>" required>
      <input type="text" name="number" placeholder="Nomor Telepon" value="<?php echo $data['number']; ?>" required>

      <button type="submit" name="simpan">Simpan</button>
    </form>
    <a href="dashboard_admin.php" class="back">Kembali ke Dashboard</a>
  </div>

</body>

</html>