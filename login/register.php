<?php
session_start();
require 'config.php';

// Ambil pesan flash jika ada
if (isset($_SESSION['flash_msg'])) {
  $error = $_SESSION['flash_msg'];
  unset($_SESSION['flash_msg']); // hapus agar tidak muncul lagi
} else {
  $error = "";
}

if (isset($_POST['submit'])) {
  $username = trim($_POST['username']);
  $name     = trim($_POST['name']);
  $number   = trim($_POST['number']);
  $password = $_POST['password'];

  // Hash password
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  // Cek username
  $check = $mysqli->prepare("SELECT id FROM user WHERE username=?");
  $check->bind_param("s", $username);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    $_SESSION['flash_msg'] = "Username sudah digunakan!";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } else {
    // Insert data
    $stmt = $mysqli->prepare("INSERT INTO user (username, name, number, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $name, $number, $passwordHash);

    if ($stmt->execute()) {
      // Redirect ke login.php jika berhasil
      header("Location: login.php");
      exit;
    } else {
      $_SESSION['flash_msg'] = "Terjadi kesalahan: " . $stmt->error;
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    }
    $stmt->close();
  }

  $check->close();
  $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="icon" type="image/png" href="../img/Logo Bulat Griyabaca.id.png">
  <link rel="stylesheet" href="../css/login.css" />
</head>
<body>
  <div class="container">
    <form class="form-box" action="" method="POST">
      <h2>Register</h2>
      <?php if ($error != ""): ?>
        <p style="color:red;"><?= $error ?></p>
      <?php endif; ?>
      <input type="text" name="username" placeholder="Username" required />
      <input type="text" name="name" placeholder="Nama" required />
      <input type="number" name="number" placeholder="Nomor Telepon" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" name="submit" class="btn">Register</button>
      <p class="link-text">
        Sudah punya akun?
        <a href="login.php">Login</a>
      </p>
    </form>
  </div>
</body>
</html>
