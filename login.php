<?php
session_start();
$conn = new mysqli("localhost", "root", "", "moneary");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, nama, password FROM akun WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['catatan_id'] = $row['id'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_nama'] = $row['nama'];
            $_SESSION['user_email'] = $email;

            header("Location: home.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Email tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link rel="stylesheet" href="login.css" />
</head>
<body class="login-page">
  <div class="container">
    <div class="logo-box">
      <img src="logo.png" alt="Logo" class="logo" />
    </div>
    <h2 class="title">Login</h2>

    <?php if (isset($error)): ?>
      <p style="color:red; text-align:center;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form class="form-box" method="POST" action="">
      <label for="email">Masukkan Email</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Masukkan Password</label>
      <input type="password" id="password" name="password" required />

      <button type="submit" class="submit-btn">Masuk</button>
    </form>

    <div class="link">
      <a href="signup.php">Belum memiliki akun? Daftar</a>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.querySelector('form');
      form.addEventListener('submit', function (e) {
        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.querySelector('input[name="password"]').value.trim();

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        let error = "";

        if (!email || !emailPattern.test(email)) {
          error += "Email tidak valid.\n";
        }

        if (!password || password.length < 2) {
          error += "Password minimal 2 karakter.\n";
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
