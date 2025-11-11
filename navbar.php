<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Griyabaca.ID</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="../img/Logo Bulat Griyabaca.id.png">
</head>
<style>
    /* Reset dasar */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html {
  scroll-behavior: smooth;
}

body {
font-family: 'Poppins';
  line-height: 1.6;
  color: #000;
  background: #f5f5f5;
}
.nav-container {
  width: 90%;
  max-width: 1100px;
  margin: auto;
}

/* NAVBAR */
.navbar {
  background: #fff;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 999;
  border-bottom: 1px solid #ddd;
}
.nav-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 0;
}
.logo {
  color: #4977ff;
  font-size: 1.5rem;
  font-weight: bold;
}
.navbar ul {
  list-style: none;
  display: flex;
  gap: 1.5rem;
}
.navbar a {
  color: #003ff8;
  text-decoration: none;
  font-weight: 600;
}
.navbar a:hover {
  border-bottom: 2px solid #003ff8;
}

/* Responsif */
@media (max-width: 768px) {
  .book-card img {
    height: 200px;
  }
}
/* ========================= */
/* RESPONSIVE DESIGN */
/* ========================= */

/* Tablet */
@media (max-width: 992px) {
  .nav-content {
    flex-direction: column;
    gap: 0.8rem;
  }

  .hero-content {
    flex-direction: column;
    text-align: center;
  }

  .hero-text {
    flex: 1 1 100%;
  }

  .hero-img {
    flex: 1 1 100%;
    max-width: 350px;
    margin: 0 auto;
  }

  .about-content {
    flex-direction: column;
    text-align: center;
  }

  .about-logo {
    margin-bottom: 1.5rem;
  }
}

/* Mobile */
@media (max-width: 576px) {
  .navbar ul {
    flex-wrap: wrap;              /* menu bisa turun ke bawah */
    justify-content: center;
    gap: 1rem;
  }

  .navbar a {
    font-size: 0.9rem;
  }

  .hero-text h2 {
    font-size: 1.5rem;
  }

  .hero-img img {
    width: 100%;
  }

    .book-grid {
    grid-template-columns: 2fr;   /* tetap 1 kolom */
    gap: 1.5rem;
  }

  .book-card {
    max-width: 500px;
    margin: 0 auto;
  }

  .book-card img {
    height: 350px;      /* tingginya diperbesar */
    object-fit: cover;  /* tetap rapi */
  }

  .book-title {
    font-size: 0.95rem;
  }

  .view-all {
    width: 100%;
  }
}

</style>
<body>
  <!-- NAVBAR -->
  <header class="navbar">
    <div class="nav-container nav-content">
      <h1 class="logo">GRIYABACA.ID</h1>
      <nav>
        <ul>
          <li><a href="../perpustakaan/perpustakaan.php">Beranda</a></li>
          <li><a href="../perpustakaan/dashboard_user.php">Dashboard</a></li>
          <li><a href="../perpustakaan/perpustakaan.php#tentang">Tentang Kami</a></li>
          <li><a href="../books/list_buku.php">Buku</a></li>
          <li><a href="../perpustakaan/perpustakaan.php#kontak">Kontak</a></li>
        </ul>
      </nav>
    </div>
  </header>
<body>
  </html>