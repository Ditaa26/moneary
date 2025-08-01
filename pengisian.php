<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include koneksi ke database
include 'koneksi.php';

// Get user's ID from session
$user_id = $_SESSION['user_id'];

// Cek apakah ini adalah update untuk catatan yang sudah ada
$catatanId = isset($_GET['id']) ? $_GET['id'] : null;
$mode = $catatanId ? 'update' : 'insert';

// Jika ada ID, ambil data catatan tersebut dan verifikasi pemiliknya
if ($mode == 'update') {
    $sqlGetCatatan = "SELECT * FROM catatan WHERE id = ? AND akun_id = ?";
    $stmt = $conn->prepare($sqlGetCatatan);
    $stmt->bind_param("ii", $catatanId, $user_id);
    $stmt->execute();
    $resultCatatan = $stmt->get_result();
    
    if ($resultCatatan->num_rows > 0) {
        $catatanData = $resultCatatan->fetch_assoc();
        $namaCatatanValue = $catatanData['nama'];
        $targetValue = $catatanData['target'];
    } else {
        // Jika catatan tidak ditemukan atau bukan milik pengguna ini, redirect
        header("Location: home.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $namaCatatan = $_POST['namaCatatan'];
    $tanggalCatatan = $_POST['tanggalCatatan'];
    $tipe = $_POST['tipe'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    // Cek target hanya saat insert
    if ($mode == 'insert') {
        $target = $_POST['target'];
    }

    // Validasi data
    if (empty($namaCatatan) || empty($tanggalCatatan) || empty($jumlah)) {
        $message = "Mohon isi semua field yang diperlukan!";
        $messageType = "error";
    } else {
        if ($mode == 'update') {
            // ❌ Jangan update target atau nama catatan
            $sql = "INSERT INTO transaksi (catatan_id, tanggal, tipe, jumlah, keterangan) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issds", $catatanId, $tanggalCatatan, $tipe, $jumlah, $keterangan);
                    
            if ($stmt->execute()) {
                header("Location: detail.php?id=$catatanId");
                exit();
            } else {
                $message = "Terjadi kesalahan: " . $conn->error;
                $messageType = "error";
            }
        } else {
            // Insert catatan baru
            $sql = "INSERT INTO catatan (nama, tanggal_dibuat, target, akun_id) 
                    VALUES (?, NOW(), ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $namaCatatan, $target, $user_id);

            if ($stmt->execute()) {
                $newCatatanId = $conn->insert_id;

                $sqlTransaksi = "INSERT INTO transaksi (catatan_id, tanggal, tipe, jumlah, keterangan) 
                                VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sqlTransaksi);
                $stmt->bind_param("issds", $newCatatanId, $tanggalCatatan, $tipe, $jumlah, $keterangan);

                if ($stmt->execute()) {
                    header("Location: detail.php?id=$newCatatanId");
                    exit();
                } else {
                    $message = "Terjadi kesalahan pada transaksi: " . $conn->error;
                    $messageType = "error";
                }
            } else {
                $message = "Terjadi kesalahan pada catatan: " . $conn->error;
                $messageType = "error";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONEARY - Isi Catatan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="pengisian.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body>
    <header>
        <?php if ($mode == 'update'): ?>
            <a href="detail.php?id=<?php echo $catatanId; ?>" class="back-button">←</a>
        <?php else: ?>
            <a href="home.php" class="back-button">←</a>
        <?php endif; ?>
        
        <div class="header-center">
            <h1><?php echo $mode == 'update' ? 'Edit Catatan Buku' : 'Buat Catatan Buku'; ?></h1>
        </div>
        <div class="logo-container">
            <img src="logo.png" alt="Logo MONEARY">
        </div>
    </header>

    <div class="form-container">
        <?php if (isset($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST" action="<?php echo $mode == 'update' ? "pengisian.php?id=$catatanId" : "pengisian.php"; ?>">
                <div class="form-field">
                    <label for="namaCatatan">Nama Catatan</label>
                    <input type="text" id="namaCatatan" name="namaCatatan" 
                        value="<?php echo isset($namaCatatanValue) ? htmlspecialchars($namaCatatanValue) : ''; ?>" 
                        <?php echo $mode == 'update' ? 'readonly' : ''; ?> required>
                </div>

                <div class="form-field">
                    <label for="tanggalCatatan">Tanggal Transaksi</label>
                    <div class="date-field">
                        <img src="kalender (2).png" alt="Kalender">
                        <input type="date" id="tanggalCatatan" name="tanggalCatatan" 
                            value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>

                <div class="form-field">
                    <label>Tipe Transaksi</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="radio" id="pemasukan" name="tipe" value="pemasukan" checked>
                            <label for="pemasukan" style="display: inline; font-weight: normal;">Pemasukan</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="radio" id="pengeluaran" name="tipe" value="pengeluaran">
                            <label for="pengeluaran" style="display: inline; font-weight: normal;">Pengeluaran</label>
                        </div>
                    </div>
                </div>

                <?php if ($mode == 'update'): ?>
                <div class="form-field">
                    <label>Target Keuangan (Rp)</label>
                    <div style="padding: 10px; background: #FFE3E3; border-radius: 5px;">
                        Rp <?php echo number_format($targetValue, 0, ',', '.'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="form-field">
                    <label for="target">Target Keuangan (Rp)</label>
                    <input type="number" id="target" name="target" min="0"
                        value="<?php echo isset($targetValue) ? htmlspecialchars($targetValue) : '0'; ?>" required>
                </div>
            <?php endif; ?>


                <div class="form-field">
                    <label for="jumlah">Jumlah (Rp)</label>
                    <input type="number" id="jumlah" name="jumlah" min="0" placeholder="Masukkan jumlah" required>
                </div>

                <div class="form-field">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan" placeholder="Masukkan keterangan transaksi">
                </div>

                <button class="save-button" type="submit"><?php echo $mode == 'update' ? 'Tambah' : 'Simpan'; ?></button>
            </form>
        </div>
    </div>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>