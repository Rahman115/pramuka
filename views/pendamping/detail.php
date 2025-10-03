<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$pendamping = $pendampingModel->readOne($id);

if(!$pendamping) {
    echo "<script>alert('Data pendamping tidak ditemukan'); window.location.href='index.php?action=list&page=pendamping';</script>";
    exit;
}

// Ambil data gudep
$gudep = $gudepModel->readOne($pendamping['id_gudep']);
// Ambil data anggota
$anggota = $anggotaModel->readOne($pendamping['id_anggota']);
?>

<div class="page-header">
    <h2>Detail Pendamping/Pembina</h2>
    <div class="header-actions">
        <a href="index.php?action=list&page=pendamping" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembai
        </a>
        <a href="index.php?action=edit&page=pendamping&id=<?php echo $id; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
</div>

<div class="detail-container">
    <div class="detail-card">
        <div class="detail-header">
            <div class="detail-avatar">
                <i class="fas fa-chalkboard-teacher fa-3x"></i>
            </div>
            <div class="detail-title">
                <h1><?php echo htmlspecialchars($pendamping['nama']); ?></h1>
                <span class="badge badge-category-pendamping">
                    <?php echo ucfirst(str_replace('_', ' ', $pendamping['jabatan'])); ?>
                </span>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-section">
                <h3><i class="fas fa-info-circle"></i> Informasi Pribadi</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Nama Lengkap</label>
                        <span><?php echo htmlspecialchars($pendamping['nama']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Jenis Kelamin</label>
                        <span>
                            <span class="badge <?php echo $pendamping['jenis_kelamin'] == 'L' ? 'badge-primary' : 'badge-pink'; ?>">
                                <?php echo $pendamping['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Lahir</label>
                        <span><?php echo $pendamping['tanggal_lahir'] ? date('d F Y', strtotime($pendamping['tanggal_lahir'])) : '-'; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Kontak</label>
                        <span><?php echo htmlspecialchars($pendamping['kontak']) ?: '-'; ?></span>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h3><i class="fas fa-briefcase"></i> Informasi Jabatan</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Jabatan</label>
                        <span class="badge badge-warning">
                            <?php echo ucfirst(str_replace('_', ' ', $pendamping['jabatan'])); ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Gugus Depan</label>
                        <span>
                            <strong><?php echo htmlspecialchars($gudep['nomor_gudep']); ?></strong> - 
                            <?php echo htmlspecialchars($gudep['nama_gudep']); ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Pangkalan</label>
                        <span><?php echo htmlspecialchars($gudep['pangkalan']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Alamat Gudep</label>
                        <span><?php echo nl2br(htmlspecialchars($gudep['alamat'])); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Keterangan</label>
                        <span><?php echo nl2br(htmlspecialchars($pendamping['keterangan'])) ?: '-'; ?></span>
                    </div>
                </div>
            </div>

            <?php
            // Ambil data peserta didik di gudep ini
            $pesertaList = $pesertaDidikModel->getByGudep($pendamping['id_gudep']);
            if(!empty($pesertaList)):
            ?>
            <div class="detail-section">
                <h3><i class="fas fa-user-graduate"></i> Peserta Didik di Gudep Ini</h3>
                <div class="stats-row">
                    <div class="stat-mini">
                        <span class="stat-number"><?php echo count(array_filter($pesertaList, fn($p) => $p['golongan'] == 'siaga' && $p['status'] == 'aktif')); ?></span>
                        <span class="stat-label">Siaga Aktif</span>
                    </div>
                    <div class="stat-mini">
                        <span class="stat-number"><?php echo count(array_filter($pesertaList, fn($p) => $p['golongan'] == 'penggalang' && $p['status'] == 'aktif')); ?></span>
                        <span class="stat-label">Penggalang Aktif</span>
                    </div>
                    <div class="stat-mini">
                        <span class="stat-number"><?php echo count(array_filter($pesertaList, fn($p) => $p['golongan'] == 'penegak' && $p['status'] == 'aktif')); ?></span>
                        <span class="stat-label">Penegak Aktif</span>
                    </div>
                </div>
                <div class="detail-list">
                    <?php 
                    $count = 0;
                    foreach($pesertaList as $peserta): 
                        if($count >= 5) break; // Tampilkan maksimal 5
                    ?>
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
                                    <span class="text-muted">• <?php echo date('d M Y', strtotime($peserta['tanggal_lahir'])); ?></span>
                                </p>
                            </div>
                        </div>
                    <?php 
                        $count++;
                    endforeach; 
                    ?>
                    <?php if(count($pesertaList) > 5): ?>
                        <div class="text-center">
                            <small class="text-muted">
                                Dan <?php echo count($pesertaList) - 5; ?> peserta didik lainnya...
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="detail-section">
                <h3><i class="fas fa-history"></i> Informasi Sistem</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>UUID</label>
                        <span class="uuid"><?php echo htmlspecialchars($pendamping['uuid_pendamping']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Dibuat Pada</label>
                        <span><?php echo date('d F Y H:i', strtotime($pendamping['created_at'])); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Diupdate Pada</label>
                        <span><?php echo date('d F Y H:i', strtotime($pendamping['updated_at'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
