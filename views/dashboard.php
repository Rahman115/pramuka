<?php
// Hitung statistik
$totalAnggota = $anggotaModel->readAll()->rowCount();
$totalGudep = $gudepModel->countAll();
$totalKwarcab = $kwarcabModel->countAll();
$totalDkc = $dkcModel->countAll();
$totalPendamping = $pendampingModel->countAll();
$totalPeserta = $pesertaDidikModel->countAll();
$totalSiaga = $pesertaDidikModel->countByGolongan('siaga');
$totalPenggalang = $pesertaDidikModel->countByGolongan('penggalang');
$totalPenegak = $pesertaDidikModel->countByGolongan('penegak');
?>

<div class="dashboard">
    <div class="page-header">
        <h2>Dashboard</h2>
        <p>Selamat datang di Sistem Manajemen Keanggotaan Pramuka</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon anggota">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Total Anggota</h3>
                <span class="stat-number"><?php echo $totalAnggota; ?></span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon gudep">
                <i class="fas fa-flag"></i>
            </div>
            <div class="stat-info">
                <h3>Gugus Depan</h3>
                <span class="stat-number"><?php echo $totalGudep; ?></span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon siaga">
                <i class="fas fa-child"></i>
            </div>
            <div class="stat-info">
                <h3>Siaga</h3>
                <span class="stat-number"><?php echo $totalSiaga; ?></span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon penggalang">
                <i class="fas fa-hiking"></i>
            </div>
            <div class="stat-info">
                <h3>Penggalang</h3>
                <span class="stat-number"><?php echo $totalPenggalang; ?></span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon penegak">
                <i class="fas fa-mountain"></i>
            </div>
            <div class="stat-info">
                <h3>Penegak</h3>
                <span class="stat-number"><?php echo $totalPenegak; ?></span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon pembina">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-info">
                <h3>Pembina</h3>
                <span class="stat-number"><?php echo $totalPendamping; ?></span>
            </div>
        </div>
    </div>

    <div class="recent-activities">
        <h3>Aktivitas Terbaru</h3>
        <div class="activity-list">
            <?php
            // Ambil data terbaru dari berbagai tabel
            $recentAnggota = $anggotaModel->readAll();
            $count = 0;
            while ($row = $recentAnggota->fetch(PDO::FETCH_ASSOC) && $count < 3) {
                echo '<div class="activity-item">';
                echo '<i class="fas fa-user-plus"></i>';
                echo '<div class="activity-content">';
                echo '<p>Anggota baru: <strong>' . htmlspecialchars($row['nama']) . '</strong> terdaftar sebagai ' . ucfirst($row['kategori']) . '</p>';
                echo '<span class="activity-time">' . date('d M Y', strtotime($row['created_at'])) . '</span>';
                echo '</div>';
                echo '</div>';
                $count++;
            }
            ?>
        </div>
    </div>
</div>