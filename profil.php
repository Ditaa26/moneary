<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONEARY - Isi Catatan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="profil.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<header>
    <a href="home.php" class="back-button">←</a>
    <div class="header-center">
        <h1>Profil</h1>
    </div>
    <div class="logo-container">
        <img src="logo.png" alt="Logo MONEARY" />
    </div>
</header>

</header>

<div class="profile-wrapper">
    <div class="profile-icon">
        <span>👤</span>
    </div>

    <div class="profile-section">
        <div class="section-title">Data Diri</div>
        <div class="info">
            <label>Email:<span><?= htmlspecialchars($_SESSION['user_email']) ?></span></label>
            <label>Nama:<span><?= htmlspecialchars($_SESSION['user_nama']) ?></span></label>
            <label>Sandi:<span>*******</span></label>
        </div>

        <form method="POST" action="logout.php">
            <button type="submit" class="logout-button">Log out</button>
        </form>
    </div>
</div>

</body>
</html>
