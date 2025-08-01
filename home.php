<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'koneksi.php';

// Get user's ID from session
$user_id = $_SESSION['user_id'];
$user_nama = $_SESSION['user_nama'];

// Get selected catatan_id from session or POST
$selected_catatan_id = isset($_POST['catatan_id']) ? $_POST['catatan_id'] : 
                      (isset($_SESSION['selected_catatan_id']) ? $_SESSION['selected_catatan_id'] : 'all');

// Save the selection to session
$_SESSION['selected_catatan_id'] = $selected_catatan_id;

// Calculate total pemasukan, pengeluaran and saldo based on selection
if ($selected_catatan_id == 'all') {
    // Show all transactions
    $sqlTotalPemasukan = "SELECT SUM(t.jumlah) as total FROM transaksi t 
                          JOIN catatan c ON t.catatan_id = c.id 
                          WHERE c.akun_id = ? AND t.tipe = 'pemasukan'";
    $stmtPemasukan = $conn->prepare($sqlTotalPemasukan);
    $stmtPemasukan->bind_param("i", $user_id);
    $stmtPemasukan->execute();
    $resultPemasukan = $stmtPemasukan->get_result();
    $totalPemasukan = $resultPemasukan->fetch_assoc()['total'] ?? 0;

    $sqlTotalPengeluaran = "SELECT SUM(t.jumlah) as total FROM transaksi t 
                           JOIN catatan c ON t.catatan_id = c.id 
                           WHERE c.akun_id = ? AND t.tipe = 'pengeluaran'";
    $stmtPengeluaran = $conn->prepare($sqlTotalPengeluaran);
    $stmtPengeluaran->bind_param("i", $user_id);
    $stmtPengeluaran->execute();
    $resultPengeluaran = $stmtPengeluaran->get_result();
    $totalPengeluaran = $resultPengeluaran->fetch_assoc()['total'] ?? 0;
} else {
    // Show only transactions for selected catatan
    $sqlTotalPemasukan = "SELECT SUM(jumlah) as total FROM transaksi 
                          WHERE catatan_id = ? AND tipe = 'pemasukan'";
    $stmtPemasukan = $conn->prepare($sqlTotalPemasukan);
    $stmtPemasukan->bind_param("i", $selected_catatan_id);
    $stmtPemasukan->execute();
    $resultPemasukan = $stmtPemasukan->get_result();
    $totalPemasukan = $resultPemasukan->fetch_assoc()['total'] ?? 0;

    $sqlTotalPengeluaran = "SELECT SUM(jumlah) as total FROM transaksi 
                           WHERE catatan_id = ? AND tipe = 'pengeluaran'";
    $stmtPengeluaran = $conn->prepare($sqlTotalPengeluaran);
    $stmtPengeluaran->bind_param("i", $selected_catatan_id);
    $stmtPengeluaran->execute();
    $resultPengeluaran = $stmtPengeluaran->get_result();
    $totalPengeluaran = $resultPengeluaran->fetch_assoc()['total'] ?? 0;

    // Get selected catatan name
    $sqlCatatanName = "SELECT nama FROM catatan WHERE id = ?";
    $stmtCatatanName = $conn->prepare($sqlCatatanName);
    $stmtCatatanName->bind_param("i", $selected_catatan_id);
    $stmtCatatanName->execute();
    $resultCatatanName = $stmtCatatanName->get_result();
    $catatanName = $resultCatatanName->fetch_assoc()['nama'] ?? '';
}

// Calculate saldo
$saldo = $totalPemasukan - $totalPengeluaran;

// Query to get catatan belonging to the logged-in user (for dropdown only)
$sql = "SELECT * FROM catatan WHERE akun_id = ? ORDER BY tanggal_dibuat DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Get list of all catatan for dropdown
$catatanList = [];
while ($row = $result->fetch_assoc()) {
    $catatanList[] = $row;
}

// Auto-select the only available catatan and refresh the page
if (count($catatanList) == 1 && $_SESSION['selected_catatan_id'] == 'all') {
    $_SESSION['selected_catatan_id'] = $catatanList[0]['id'];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONEARY - Halaman Utama</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="home.css" />
</head>
<body>
    
    <div class="header">
        <a href="profil.php" class="profile-icon">
            <span>👤</span>
        </a>
        <div class="title-container">
            <h1 class="title">MONEARY</h1>
            <p class="subtitle">Your Quiet Financial Space</p>
        </div>
        <div class="logo">
            <img src="logo.png" alt="Logo MONEARY">
        </div>
    </div>
    
    <div class="page-content">
        <!-- Welcome card moved to top -->
        <div class="welcome-card">
            <div class="welcome-title">
                Selamat Datang, <?php echo htmlspecialchars($user_nama); ?>!
                <?php if ($selected_catatan_id != 'all' && isset($catatanName)): ?>
                    <div style="font-size: 13px; margin-top: 5px; color: #A15363; font-style: italic;">Menampilkan: <?php echo htmlspecialchars($catatanName); ?></div>
                <?php endif; ?>
            </div>
            <div class="summary-section">
                <div class="summary-item">
                    Pemasukan:<br>Rp <?php echo number_format($totalPemasukan, 0, ',', '.'); ?>
                </div>
                <div class="summary-item">
                    Pengeluaran:<br>Rp <?php echo number_format($totalPengeluaran, 0, ',', '.'); ?>
                </div>
                <div class="summary-item">
                    Saldo:<br>Rp <?php echo number_format($saldo, 0, ',', '.'); ?>
                </div>
            </div>
        </div>
        
        <!-- Catatan selector dropdown moved below welcome card -->
        <div class="catatan-selector">
            <form method="POST" action="">
                <label for="catatan_id">Pilih catatan:</label>
                <select name="catatan_id" id="catatan_id" onchange="this.form.submit()">
                    <option value="all" <?php echo $selected_catatan_id == 'all' ? 'selected' : ''; ?>>Semua Catatan</option>
                    <?php foreach ($catatanList as $catatan): ?>
                        <option value="<?php echo $catatan['id']; ?>" <?php echo $selected_catatan_id == $catatan['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($catatan['nama']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="update_view">Pilih</button>
            </form>
        </div>
        
        <div class="action-buttons">
            <a href="buku.php" class="action-button">
                <div class="button-icon">📖</div>
                <div>buku</div>
            </a>
            
            <a href="pengisian.php" class="action-button">
                <div class="button-icon">+</div>
                <div>Tambah</div>
            </a>
        </div>
    </div>
    
    <script>
        lucide.createIcons();
    </script>
</body>
</html>