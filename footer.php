<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Footer Rapi</title>
  <link rel="icon" type="image/png" href="../img/Logo Bulat Griyabaca.id.png">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f9f9f9;
    }

    /* ===== FOOTER ===== */
    .main-footer {
      border-top: 1px solid #ddd;
      background: #fff;
      color: #003ff8;
      padding: 40px 20px;
    }

    .footer-container {
      display: grid;
      grid-template-columns: 1fr auto 1fr; /* kiri - logo - kanan */
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      gap: 80px; /* jarak antar kolom */
    }

    /* Kolom kiri */
    .footer-column h4 {
      font-weight: bold;
      margin-bottom: 10px;
      font-size: 1.1rem;
    }

    .footer-column ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-column ul li {
      margin: 6px 0;
      font-size: 0.95rem;
    }

    .footer-column ul li a {
      text-decoration: none;
      color: #003ff8;
      transition: color 0.3s;
    }

    .footer-column ul li a:hover {
      color: #0030c2;
    }

    /* Logo tengah */
    .footer-logo {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .footer-logo img {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      object-fit: cover;
    }

    /* Kolom kanan */
    .footer-column.right {
      text-align: right;
    }

    .social-icons {
      display: flex;
      justify-content: flex-end;
      gap: 12px;
      margin-bottom: 10px;
    }

    .social-icons svg {
      width: 28px;
      height: 28px;
      fill: #003ff8;
      transition: transform 0.3s, fill 0.3s;
    }

    .social-icons svg:hover {
      transform: scale(1.1);
      fill: #0030c2;
    }

    .footer-contact {
      font-size: 14px;
      color: #003ff8;
    }

    .footer-contact p {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 8px;
      margin: 5px 0;
    }

    .footer-contact svg {
      flex-shrink: 0;
      fill: #003ff8;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .footer-container {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 30px;
      }

      .footer-column.right,
      .footer-contact p {
        justify-content: center;
        text-align: center;
      }

      .social-icons {
        justify-content: center;
      }
    }
  </style>
</head>

<body>
  <footer class="main-footer" id="kontak">
    <div class="footer-container">
      <!-- Kiri -->
      <div class="footer-column">
        <h4>PERPUSTAKAAN</h4>
        <ul>
          <li><a href="../books/list_buku.php">Jelajahi Buku</a></li>
          <li><a href="#populer">Buku Populer</a></li>
          <li><a href="#kontak">Kontak</a></li>
        </ul>
      </div>

      <!-- Logo Tengah -->
      <div class="footer-logo">
        <img src="../img/Logo Bulat Griyabaca.id.png" alt="Logo Perpustakaan">
      </div>

      <!-- Kanan -->
      <div class="footer-column right">
        <h4>Media Sosial</h4>
        <div class="social-icons">
          <a href="https://instagram.com/griyabacaidn" target="_blank" aria-label="Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.75 2C4.68 2 2 4.68 2 7.75v8.5C2 19.32 4.68 22 7.75 22h8.5C19.32 22 22 19.32 22 16.25v-8.5C22 4.68 19.32 2 16.25 2h-8.5zM17.5 5.75A1.25 1.25 0 1 1 16.25 7a1.25 1.25 0 0 1 1.25-1.25zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10z"/></svg>
          </a>
          <a href="https://facebook.com/grcaindo" target="_blank" aria-label="Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 12a10 10 0 1 0-11.5 9.88v-7H8v-3h2.5V9.5a3.5 3.5 0 0 1 3.75-3.86c1.09 0 2.23.2 2.23.2v2.45h-1.26c-1.24 0-1.62.77-1.62 1.55V12H16l-.4 3h-2.47v7A10 10 0 0 0 22 12z"/></svg>
          </a>
          <a href="https://tiktok.com/@gricaidn" target="_blank" aria-label="TikTok">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.002 2.001c1.171 0 2.248.342 3.162.927a6.5 6.5 0 004.836 2.07v3.478a9.97 9.97 0 01-4.207-.902v7.997a6.571 6.571 0 01-6.572 6.572A6.571 6.571 0 012.648 14.57a6.571 6.571 0 016.573-6.572c.23 0 .456.017.678.046v3.544a3.1 3.1 0 00-.678-.073 3.028 3.028 0 00-3.028 3.028 3.028 3.028 0 003.028 3.027 3.028 3.028 0 003.028-3.027V2.001z"/></svg>
          </a>
        </div>
        <div class="footer-contact">
          <h4>Kontak Kami</h4>
          <p>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18"><path d="M20 4H4C2.9 4 2 4.9 2 6v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
            griyabacaid@gmail.com
          </p>
          <p>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18"><path d="M6.62 10.79C8.06 13.62 10.38 15.94 13.21 17.38l2.2-2.2c.28-.28.7-.36 1.06-.23 1.05.39 2.18.6 3.37.6.55 0 1 .45 1 1v3.9c0 .55-.45 1-1 1C10.61 21.45 3 13.84 3 4.61 3 4.06 3.45 3.61 4 3.61h3.9c.55 0 1 .45 1 1 0 1.19.21 2.32.6 3.37.13.36.05.78-.23 1.06l-2.2 2.2z"/></svg>
            +62 812-3456-7890
          </p>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
