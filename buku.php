<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_nama = $_SESSION['user_nama'];

$sql = "SELECT * FROM catatan WHERE akun_id = ? ORDER BY tanggal_dibuat DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$catatanList = [];
while ($row = $result->fetch_assoc()) {
    $catatanList[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Catatan | MONEARY</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="buku.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<header>
    <a href="home.php" class="back-button">←</a>
    <div class="header-center">
        <h1>Buku Catatan</h1>
    </div>
    <div class="logo-container">
        <img src="logo.png" alt="Logo MONEARY">
    </div>
</header>

<div class="container">
    <?php if (count($catatanList) === 0): ?>
        <div class="no-data-message">
            <p>Belum ada catatan keuangan. Silakan tambahkan catatan baru.</p>
        </div>
    <?php else: ?>
        <?php foreach ($catatanList as $catatan): ?>
            <a class="card" href="detail.php?id=<?= $catatan['id'] ?>">
                <div><?= htmlspecialchars($catatan['nama']) ?></div>
                <div class="card-arrow">→</div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
