<?php
require '../login/config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  $sql  = "SELECT * FROM user WHERE username = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Tentukan session name sesuai role
        if ($user['role'] === 'users') {
            session_name("USERSESSID");
        } elseif ($user['role'] === 'petugas') {
            session_name("PETUGASSESSID");
        } elseif ($user['role'] === 'admin') {
            session_name("ADMINSESSID");
        } else {
            session_name("GENERICSESSID");
        }

        session_start(); // mulai session setelah menentukan nama

        $_SESSION['id']       = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];

        // Redirect sesuai role
        if ($user['role'] === 'users') {
            header("Location: ../perpustakaan/perpustakaan.php");
        } elseif ($user['role'] === 'petugas') {
            header("Location: ../dashboard/dashboard_petugas.php");
        } elseif ($user['role'] === 'admin') {
            header("Location: ../dashboard/dashboard_admin.php");
        }
        exit;
    } else {
        $error = "Password salah!";
    }
  } else {
    $error = "Username tidak ditemukan!";
  }
}
// Sebagai tampilan (UI) halaman login
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="icon" type="image/png" href="../img/Logo Bulat Griyabaca.id.png">
  <link rel="stylesheet" href="../css/login.css" />
</head>

<body>
  <div class="container">
    <form class="form-box" method="POST" action="">
      <h2>Login</h2>
      <?php if ($error != "") {
        echo "<p style='color:red;'>$error</p>";
      } ?>
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" name="submit" class="btn">Login</button>
      <p class="link-text">
        Belum punya akun?
        <a href="register.php">Register</a>
      </p>
    </form>
  </div>
</body>

</html>