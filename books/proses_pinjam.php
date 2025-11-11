<?php
// Sebagai halaman backend petugas untuk memproses peminjaman buku
session_name("PETUGASSESSID");
session_start();
require '../login/config.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'petugas') {
    header("Location: ../login/login.php");
    exit;
}

$id   = intval($_GET['id']);
$aksi = $_GET['aksi'];

if ($aksi == "terima") {
    $mysqli->query("UPDATE peminjaman SET status='diterima' WHERE id=$id");
} elseif ($aksi == "tolak") {
    $mysqli->query("UPDATE peminjaman SET status='ditolak' WHERE id=$id");
}

header("Location: ../dashboard/dashboard_petugas.php");
exit;
?>
