<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$gudep = $gudepModel->readOne($id);

if(!$gudep) {
    echo "<script>alert('Data gudep tidak ditemukan'); window.location.href='index.php?action=list&page=gudep';</script>";
    exit;
}

// Ambil data pendamping gudep
$pendampingList = $pendampingModel->getByGudep($id);
// Ambil data peserta didik gudep
$pesertaList = $pesertaDidikModel->getByGudep($id);
?>

<div class="page-header">
    <h2>Detail Gugus Depan</h2>
    <div class="header-actions">
        <a href="index.php?action=list&page=gudep" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="index.php?action=edit&page=gudep&id=<?php echo $id; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
</div>

<div class="detail-container">
    <div class="detail-card">
        <div class="detail-header">
            <div class="detail-avatar">
                <i class="fas fa-flag fa-3x"></i>
            </div>
            <div class="detail-title">
                <h1><?php echo htmlspecialchars($gudep['nama_gudep']); ?></h1>
                <span class="badge badge-primary"><?php echo htmlspecialchars($gudep['nomor_gudep']); ?></span>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-section">
                <h3><i class="fas fa-info-circle"></i> Informasi Gudep</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Nomor Gudep</label>
                        <span><?php echo htmlspecialchars($gudep['nomor_gudep']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Nama Gudep</label>
                        <span><?php echo htmlspecialchars($gudep['nama_gudep']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Pangkalan</label>
                        <span><?php echo htmlspecialchars($gudep['pangkalan']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Alamat</label>
                        <span><?php echo nl2br(htmlspecialchars($gudep['alamat'])); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Keterangan</label>
                        <span><?php echo nl2br(htmlspecialchars($gudep['keterangan'])) ?: '-'; ?></span>
                    </div>
                </div>
            </div>

            <?php if(!empty($pendampingList)): ?>
            <div class="detail-section">
                <h3><i class="fas fa-chalkboard-teacher"></i> Pendamping/Pembina</h3>
                <div class="detail-list">
                    <?php foreach($pendampingList as $pendamping): ?>
                        <div class="list-item">
                            <div class="list-item-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="list-item-content">
                                <h4><?php echo htmlspecialchars($pendamping['nama']); ?></h4>
                                <p>
                                    <span class="badge badge-warning"><?php echo ucfirst(str_replace('_', ' ', $pendamping['jabatan'])); ?></span>
                                    <span class="text-muted">• <?php echo htmlspecialchars($pendamping['kontak']); ?></span>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if(!empty($pesertaList)): ?>
            <div class="detail-section">
                <h3><i class="fas fa-users"></i> Peserta Didik</h3>
                <div class="stats-row">
                    <div class="stat-mini">
                        <span class="stat-number"><?php echo count(array_filter($pesertaList, fn($p) => $p['golongan'] == 'siaga')); ?></span>
                        <span class="stat-label">Siaga</span>
                    </div>
                    <div class="stat-mini">
                        <span class="stat-number"><?php echo count(array_filter($pesertaList, fn($p) => $p['golongan'] == 'penggalang')); ?></span>
                        <span class="stat-label">Penggalang</span>
                    </div>
                    <div class="stat-mini">
                        <span class="stat-number"><?php echo count(array_filter($pesertaList, fn($p) => $p['golongan'] == 'penegak')); ?></span>
                        <span class="stat-label">Penegak</span>
                    </div>
                </div>
                <div class="detail-list">
                    <?php foreach($pesertaList as $peserta): ?>
                        <div class="list-item">
                            <div class="list-item-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="list-item-content">
                                <h4><?php echo htmlspecialchars($peserta['nama']); ?></h4>
                                <p>
                                    <span class="badge badge-golongan-<?php echo $peserta['golongan']; ?>">
                                        <?php echo ucfirst($peserta['golongan']); ?>
                                    </span>
                                    <span class="badge badge-<?php echo $peserta['status'] == 'aktif' ? 'success' : 'warning'; ?>">
                                        <?php echo ucfirst($peserta['status']); ?>
                                    </span>
                                    <span class="text-muted">• Lahir: <?php echo date('d M Y', strtotime($peserta['tanggal_lahir'])); ?></span>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="detail-section">
                <h3><i class="fas fa-history"></i> Informasi Sistem</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>UUID</label>
                        <span class="uuid"><?php echo htmlspecialchars($gudep['uuid_gudep']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Dibuat Pada</label>
                        <span><?php echo date('d F Y H:i', strtotime($gudep['created_at'])); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Diupdate Pada</label>
                        <span><?php echo date('d F Y H:i', strtotime($gudep['updated_at'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
