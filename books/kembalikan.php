<?php
session_name("USERSESSID");
session_start();
require '../login/config.php';

// cek login
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'users') {
  header("Location: ../login/login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_peminjaman = $_POST['id_peminjaman'];

    // cari dulu data peminjaman untuk tahu id buku
    $sql_pinjam = "SELECT book_id FROM peminjaman WHERE id='$id_peminjaman'";
    $result = $mysqli->query($sql_pinjam);
    $row = $result->fetch_assoc();
    $book_id = $row['book_id'];

    // update status jadi selesai
    $sql = "UPDATE peminjaman SET status='selesai' WHERE id='$id_peminjaman'";
    if ($mysqli->query($sql)) {
        // kembalikan stok buku
        $mysqli->query("UPDATE books SET stok = stok + 1 WHERE id='$book_id'");

        header("Location: ../perpustakaan/dashboard_user.php");
        exit;
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>
