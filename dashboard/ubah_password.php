<?php
session_name("PETUGASSESSID");
session_start();
require '../login/config.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'petugas') {
  header("Location: ../login/login.php");
  exit;
}

// Ambil Usernmae Dari Session Login
$username = $_SESSION['username'];
$message = "";

// Proses Ubah Password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $old_pass = $_POST['old_password'];
  $new_pass = $_POST['new_password'];
  $confirm_pass = $_POST['confirm_password'];

  // Konfirmasi Password Lama Apakah Sama Atau Tidak
  if ($new_pass !== $confirm_pass) {
    $message = "❌ Konfirmasi password tidak sama!";
  } else {
    // Ambil Password Lama Dari Data Base
    $sql = "SELECT password FROM user WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verifikasi Password Lama, Jika Cocok, Update Dengan Password Yang Baru
    if ($hashedPassword && password_verify($old_pass, $hashedPassword)) {
      $newHash = password_hash($new_pass, PASSWORD_DEFAULT);

      // Update Password
      $update = $mysqli->prepare("UPDATE user SET password=? WHERE username=?");
      $update->bind_param("ss", $newHash, $username);
      if ($update->execute()) {
        $message = "✅ Password berhasil diubah!";
      } else {
        $message = "❌ Error update: " . $mysqli->error;
      }
      $update->close();
    } else {
      $message = "❌ Password lama salah!";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Ubah Password</title>
  <link rel="stylesheet" href="../css/ubah_password.css">
</head>
<body>
  <div class="card">
    <h2>Ubah Password</h2>
    <?php if ($message): ?>
      <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <input type="text" value="<?= htmlspecialchars($_SESSION['username']); ?>" disabled>
      </div>
      <div class="form-group">
        <input type="password" name="old_password" placeholder="Password Lama" required>
      </div>
      <div class="form-group">
        <input type="password" name="new_password" placeholder="Password Baru" required>
      </div>
      <div class="form-group">
        <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
      </div>
      <button type="submit">Simpan</button>
    </form>
    <a href="dashboard_petugas.php" class="back">Kembali</a>
  </div>
</body>

</html>