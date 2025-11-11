<?php
session_name("PETUGASSESSID");
session_start();
require '../login/config.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'petugas') {
    header("Location: ../login/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // ambil data cover dan pdf
    $sql = "SELECT cover, pdf FROM books WHERE id=$id";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();

        // hapus record dari database
        $del = $mysqli->query("DELETE FROM books WHERE id=$id");

        if ($del) {
            // hapus cover
            $coverPath = __DIR__ . "/../uploads/covers/" . $book['cover'];
            if (file_exists($coverPath)) {
                unlink($coverPath);
            }

            // hapus pdf
            $pdfPath = __DIR__ . "/../uploads/pdf/" . $book['pdf'];
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            header("Location: ../dashboard/dashboard_petugas.php?deleted=1");
            exit;
        } else {
            echo "❌ Gagal hapus buku: " . $mysqli->error;
        }
    } else {
        echo "❌ Buku tidak ditemukan.";
    }
} else {
    echo "❌ ID tidak valid.";
}
