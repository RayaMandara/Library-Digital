<?php
    session_name("ADMINSESSID");
    session_start();
    require '../login/config.php';
    if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../login/login.php");
        exit;
    }
// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Hapus data berdasarkan ID
$delete = "DELETE FROM user WHERE id='$id'";

if (mysqli_query($mysqli, $delete)) {
    echo "<script>alert('Data berhasil dihapus!');window.location='dashboard_admin.php';</script>";
} else {
    echo "Error: " . mysqli_error($mysqli);
}
?>
<a href="dashboard_admin"></a>