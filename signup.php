<?php
$conn = new mysqli("localhost", "root", "", "moneary");

// Cek koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $nama = trim($_POST['nama']);
  $password_raw = $_POST['password'];

  // Validasi server-side sederhana
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Email tidak valid.";
  } elseif (strlen($password_raw) < 6) {
    $error = "Password minimal 6 karakter.";
  } elseif (empty($nama)) {
    $error = "Nama tidak boleh kosong.";
  }

  if (!$error) {
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Cek apakah email sudah digunakan
    $cek = $conn->prepare("SELECT id FROM akun WHERE email = ?");
    if ($cek) {
      $cek->bind_param("s", $email);
      $cek->execute();
      $cek->store_result();

      if ($cek->num_rows > 0) {
        $error = "Email sudah digunakan.";
      } else {
        $stmt = $conn->prepare("INSERT INTO akun (email, nama, password) VALUES (?, ?, ?)");
        if ($stmt) {
          $stmt->bind_param("sss", $email, $nama, $password);
          if ($stmt->execute()) {
            header("Location: login.php");
            exit;
          } else {
            $error = "Gagal mendaftar.";
          }
        } else {
          $error = "Query insert akun gagal.";
        }
      }
      $cek->close();
    } else {
      $error = "Query cek email gagal.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up</title>
  <link rel="stylesheet" href="login.css" />
</head>
<body class="signup-page">
  <div class="container">
    <div class="logo-box">
      <img src="logo.png" alt="Logo" class="logo" />
    </div>
    <h2 class="title">Sign Up</h2>

    <?php if ($error): ?>
      <p style="color:red; text-align:center;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form class="form-box" method="POST" action="">
      <label for="email">Masukkan Email</label>
      <input type="email" id="email" name="email" required />

      <label for="nama">Masukkan Nama</label>
      <input type="text" id="nama" name="nama" required />

      <label for="password">Masukkan Password</label>
      <input type="password" id="password" name="password" required minlength="6" />

      <button type="submit" class="submit-btn">Daftar</button>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.querySelector('form');
      form.addEventListener('submit', function (e) {
        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.querySelector('input[name="password"]').value.trim();
        const nama = document.querySelector('input[name="nama"]').value.trim();

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        let error = "";

        if (!email || !emailPattern.test(email)) {
          error += "Email tidak valid.\n";
        }

        if (!nama) {
          error += "Nama tidak boleh kosong.\n";
        }

        if (!password || password.length < 6) {
          error += "Password minimal 6 karakter.\n";
        }

        if (error) {
          alert(error);
          e.preventDefault();
        }
      });
    });
  </script>
</body>
</html>
