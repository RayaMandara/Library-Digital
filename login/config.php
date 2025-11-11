<?php 
$host       = "localhost";
$user       = "root";
$password   = "";
$dbname     = "perpustakaan";

$mysqli = new mysqli($host,$user,$password,$dbname); // Untuk membuat Koneksi ke Database

// Untuk mengecek koneksi ke Database apakah berhasil apa tidak
if ($mysqli->connect_error) {
    die("koneksi gagal: " . $mysqli->connect_error);
}
function e($s){return htmlspecialchars($s,ENT_QUOTES);} // Di gunakan untuk mengamankan output html
