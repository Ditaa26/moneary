<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM catatan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $catatan = $result->fetch_assoc();

    $sqlPemasukan = "SELECT SUM(jumlah) as total FROM transaksi WHERE catatan_id = $id AND tipe = 'pemasukan'";
    $pemasukan = $conn->query($sqlPemasukan)->fetch_assoc()['total'] ?? 0;

    $sqlPengeluaran = "SELECT SUM(jumlah) as total FROM transaksi WHERE catatan_id = $id AND tipe = 'pengeluaran'";
    $pengeluaran = $conn->query($sqlPengeluaran)->fetch_assoc()['total'] ?? 0;

    $target = $catatan['target'];
    $progress = ($target > 0) ? max(0, min(100, ($pemasukan - $pengeluaran) / $target * 100)) : 0;
} else {
    header("Location: home.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah_data'])) {
        header("Location: pengisian.php?id=$id");
        exit();
    }

    if (isset($_POST['hapus_data'])) {
        $stmt1 = $conn->prepare("DELETE FROM transaksi WHERE catatan_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();

        $stmt2 = $conn->prepare("DELETE FROM catatan WHERE id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();

        header("Location: home.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Catatan Buku</title>
    <link rel="stylesheet" href="detail.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<header>
    <a href="home.php" class="back-button">←</a>
    <div class="header-center">
        <h1>Detail Catatan Buku</h1>
    </div>
    <div class="logo-container">
        <img src="logo.png" alt="Logo MONEARY">
    </div>
</header>

<div class="content">
    <div class="detail-card">
        <div class="detail-row">
            <div class="label">Nama catatan:</div>
            <div class="value"><?= htmlspecialchars($catatan['nama']); ?></div>
        </div>
        <div class="detail-row">
            <div class="label">Pemasukan:</div>
            <div class="value">Rp <?= number_format($pemasukan, 0, ',', '.'); ?></div>
        </div>
        <div class="detail-row">
            <div class="label">Pengeluaran:</div>
            <div class="value">Rp <?= number_format($pengeluaran, 0, ',', '.'); ?></div>
        </div>
        <div class="detail-row">
            <div class="label">Saldo:</div>
            <div class="value">Rp <?= number_format($pemasukan - $pengeluaran, 0, ',', '.'); ?></div>
        </div>
        <div class="detail-row">
            <div class="label">Target:</div>
            <div class="value">Rp <?= number_format($target, 0, ',', '.'); ?></div>
        </div>
        <div class="detail-row">
            <div class="label">Progress Target:</div>
            <div class="progress-container">
                <div class="progress-bar" style="width: <?= $progress ?>%;"></div>
            </div>
            <div class="progress-text"><?= round($progress) ?>%</div>
        </div>
        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <form method="POST">
                <button class="edit-button" name="tambah_data">Edit Transaksi</button>
            </form>
            <form method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus seluruh catatan dan transaksinya?')">
                <button class="edit-button" name="hapus_data">Hapus Catatan</button>
            </form>
        </div>
    </div>

    <div class="transactions">
        <h3>Riwayat Transaksi</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultTransaksi = $conn->query("SELECT * FROM transaksi WHERE catatan_id = $id ORDER BY tanggal DESC");
                if ($resultTransaksi && $resultTransaksi->num_rows > 0) {
                    while ($row = $resultTransaksi->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . date('d/m/Y', strtotime($row['tanggal'])) . "</td>";
                        echo "<td>" . htmlspecialchars($row['keterangan']) . "</td>";
                        echo "<td class='" . $row['tipe'] . "'>" . ucfirst($row['tipe']) . "</td>";
                        echo "<td>Rp " . number_format($row['jumlah'], 0, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align: center;'>Belum ada transaksi</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
