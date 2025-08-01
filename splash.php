<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MONEARY - Splash</title>
  <link rel="stylesheet" href="splash.css" />
</head>
<body>

  <img src="logo.png" alt="MONEARY Logo" />
  <h1>Selamat Datang di MONEARY</h1>
  <h2>Simpan dan Catat uangmu</h2>
  <button onclick="startApp()">Mulai</button>

  <script>
    function startApp() {
      window.location.href = "login.php";
    }

    // Auto start (optional)
    // setTimeout(startApp, 4000);
  </script>
</body>
</html>
