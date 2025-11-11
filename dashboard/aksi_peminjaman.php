<?php
session_name("PETUGASSESSID");
session_start();
require '../login/config.php';
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'petugas') {
    header("Location: ../login/login.php");
    exit;
}

// Ambil Data
$id   = intval($_GET['id']);
$aksi = $_GET['aksi'];

// cek peminjaman dulu
$peminjaman = $mysqli->query("SELECT * FROM peminjaman WHERE id=$id")->fetch_assoc();
if (!$peminjaman) {
    die("❌ Data peminjaman tidak ditemukan.");
}

//Id Buku
$book_id = $peminjaman['book_id'];


// Aksi Ketika Petugas Menerima Peminjaman
if ($aksi === 'terima') {
    // update status peminjaman jadi dipinjam
    $mysqli->query("UPDATE peminjaman SET status='dipinjam' WHERE id=$id");
    // kurangi stok buku                                                                                
    $mysqli->query("UPDATE books SET stok = stok - 1 WHERE id=$book_id AND stok > 0");
    echo "<script>alert('✅ Peminjaman diterima!');window.location='data_peminjaman.php';</script>";
} 
// Aksi Ketika Petugas Menolak Peminjaman
elseif ($aksi === 'tolak') {
    $mysqli->query("UPDATE peminjaman SET status='ditolak' WHERE id=$id");
    echo "<script>alert('❌ Peminjaman ditolak!');window.location='data_peminjaman.php';</script>";
} 
// Aksi Ketika Buku Sudah di Kembalikan dan proses seelsai
elseif ($aksi === 'selesai') {
    // Jika Buku Dikembalikan, Status Akan Di Update Menjadi Selesai, Lalu Stok Ditambah 1 lagi
    $mysqli->query("UPDATE peminjaman SET status='selesai' WHERE id=$id");
    $mysqli->query("UPDATE books SET stok = stok + 1 WHERE id=$book_id");
    echo "<script>alert('Buku sudah dikembalikan!');window.location='data_peminjaman.php';</script>";
} 
else {
    echo "<script>alert('Aksi tidak valid!');window.location='data_peminjaman.php';</script>";
}
