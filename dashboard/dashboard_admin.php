<?php
session_name("ADMINSESSID");
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login/login.php");
  exit;
}
require '../login/config.php';
$msg = "";


// PROSES TAMBAH USER
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $name     = trim($_POST['name']);
  $number   = trim($_POST['number']);
  $role     = $_POST['role'];
  $defaultPassword = password_hash("123456", PASSWORD_DEFAULT);


  //Cek Apakah Username Sudah Terpakai/Belum
  $check = $mysqli->prepare("SELECT id FROM user WHERE username=?");
  $check->bind_param("s", $username);
  $check->execute();
  $check->store_result();


//Kalau Username Sudah Ada
  if ($check->num_rows > 0) {
    $_SESSION['flash_msg'] = "Username sudah digunakan!";
  } 
  //Kalau Username Belum Ada
  else {
    $stmt = $mysqli->prepare("INSERT INTO user (username, name, number, role, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $name, $number, $role, $defaultPassword);

    if ($stmt->execute()) {
      $_SESSION['flash_msg'] = "User berhasil ditambahkan! password default : 123456";
    } else {
      $_SESSION['flash_msg'] = "Gagal menambahkan user: " . $stmt->error;
    }
    $stmt->close();
  }
  $check->close();
  header("Location: dashboard_admin.php");
  exit;
}

//Seleksi Role
$admins   = $mysqli->query("SELECT * FROM user WHERE role='admin'");
$petugas  = $mysqli->query("SELECT * FROM user WHERE role='petugas'");
$users    = $mysqli->query("SELECT * FROM user WHERE role='users'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <div class="container">
    <h2>Selamat Datang di Dashboard Admin</h2>

    <!-- Tombol Logout -->
    <div class="back" style="margin-top:20px;">
      <a href="../logout/logout_admin.php">Logout</a>
    </div><br>

<!-- Pesan Notifikasi -->
<?php if (!empty($_SESSION['flash_msg'])): ?>
  <p style="color: red; font-weight: bold;">
    <?= $_SESSION['flash_msg']; ?>
  </p>
  <?php unset($_SESSION['flash_msg']); ?>
<?php endif; ?>

    <!-- Form Tambah Data -->
    <form class="form-tambah" method="POST" action="">
      <input type="text" name="username" placeholder="Username" required>
      <input type="text" name="name" placeholder="Nama" required>
      <input type="text" name="number" placeholder="Nomor Telepon" required>

      <!-- Pilih Role -->
      <select name="role" required>
        <option value="" disabled selected hidden>-- Pilih Role --</option>
        <option value="admin">Admin</option>
        <option value="petugas">Petugas</option>
      </select>
      <button type="submit" class="btn-tambah">Tambah</button>
    </form>

    <!-- Tabel Admin -->
    <h3>👑 Daftar Admin</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="margin-top:10px; width:100%;">
      <thead>
        <tr style="background:#f2f2f2;">
          <th>ID</th>
          <th>Username</th>
          <th>Nama</th>
          <th>Nomor Telepon</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($admins->num_rows > 0): ?>
          <?php while ($row = $admins->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><?= $row['username']; ?></td>
              <td><?= $row['name']; ?></td>
              <td><?= $row['number']; ?></td>
              <td><?= $row['role']; ?></td>
              <td>
                <a href="edit_data.php?id=<?= $row['id']; ?>" class="btn-edit">Edit</a> |
                <a href="hapus_data.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin Hapus Data?')" class="btn-hapus">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align:center;">Tidak ada data Admin.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
    <!-- Tabel Petugas -->
    <h3>🛠️ Daftar Petugas</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="margin-top:10px; width:100%;">
      <thead>
        <tr style="background:#f2f2f2;">
          <th>ID</th>
          <th>Username</th>
          <th>Nama</th>
          <th>Nomor Telepon</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($petugas->num_rows > 0): ?>
          <?php while ($row = $petugas->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><?= $row['username']; ?></td>
              <td><?= $row['name']; ?></td>
              <td><?= $row['number']; ?></td>
              <td><?= $row['role']; ?></td>
              <td>
                <a href="edit_data.php?id=<?= $row['id']; ?>" class="btn-edit">Edit</a> |
                <a href="hapus_data.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin Hapus Data?')" class="btn-hapus">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align:center;">Tidak ada data Petugas.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Tabel Users -->
    <h3>👤 Daftar Users</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="margin-top:10px; width:100%;">
      <thead>
        <tr style="background:#f2f2f2;">
          <th>ID</th>
          <th>Username</th>
          <th>Nama</th>
          <th>Nomor Telepon</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($users->num_rows > 0): ?>
          <?php while ($row = $users->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><?= $row['username']; ?></td>
              <td><?= $row['name']; ?></td>
              <td><?= $row['number']; ?></td>
              <td><?= $row['role']; ?></td>
              <td>
                <a href="edit_data.php?id=<?= $row['id']; ?>" class="btn-edit">Edit</a> |
                <a href="hapus_data.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin Hapus Data?')" class="btn-hapus">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align:center;">Tidak ada data Users.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
</body>

</html>