<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$peserta = $pesertaDidikModel->readOne($id);

if(!$peserta) {
    echo "<script>alert('Data peserta didik tidak ditemukan'); window.location.href='index.php?action=list&page=peserta';</script>";
    exit;
}

// Ambil data gudep
$gudep = $gudepModel->readOne($peserta['id_gudep']);
// Ambil data pendamping di gudep ini
$pendampingList = $pendampingModel->getByGudep($peserta['id_gudep']);
// Hitung usia
$usia = $peserta['tanggal_lahir'] ? date_diff(date_create($peserta['tanggal_lahir']), date_create('today'))->y : null;
?>

<div class="page-header">
    <h2>Detail Peserta Didik</h2>
    <div class="header-actions">
        <a href="index.php?action=list&page=peserta" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="index.php?action=edit&page=peserta&id=<?php echo $id; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
</div>

<div class="detail-container">
    <div class="detail-card">
        <div class="detail-header">
            <div class="detail-avatar">
                <i class="fas fa-user-graduate fa-3x"></i>
            </div>
            <div class="detail-title">
                <h1><?php echo htmlspecialchars($peserta['nama']); ?></h1>
                <div class="badge-group">
                    <span class="badge badge-golongan-<?php echo $peserta['golongan']; ?>">
                        <?php echo ucfirst($peserta['golongan']); ?>
                    </span>
                    <span class="badge badge-<?php echo $peserta['status'] == 'aktif' ? 'success' : ($peserta['status'] == 'alumni' ? 'warning' : 'info'); ?>">
                        <?php echo ucfirst($peserta['status']); ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-section">
                <h3><i class="fas fa-info-circle"></i> Informasi Pribadi</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Nama Lengkap</label>
                        <span><?php echo htmlspecialchars($peserta['nama']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Jenis Kelamin</label>
                        <span>
                            <span class="badge <?php echo $peserta['jenis_kelamin'] == 'L' ? 'badge-primary' : 'badge-pink'; ?>">
                                <?php echo $peserta['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Lahir</label>
                        <span>
                            <?php echo $peserta['tanggal_lahir'] ? date('d F Y', strtotime($peserta['tanggal_lahir'])) : '-'; ?>
                            <?php if($usia): ?>
                                <small class="text-muted">(<?php echo $usia; ?> tahun)</small>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Usia Golongan</label>
                        <span>
                            <?php 
                            if($usia) {
                                if($usia >= 7 && $usia <= 10) {
                                    echo '<span class="badge badge-golongan-siaga">Siaga (7-10 tahun)</span>';
                                } elseif($usia >= 11 && $usia <= 15) {
                                    echo '<span class="badge badge-golongan-penggalang">Penggalang (11-15 tahun)</span>';
                                } elseif($usia >= 16 && $usia <= 20) {
                                    echo '<span class="badge badge-golongan-penegak">Penegak (16-20 tahun)</span>';
                                } else {
                                    echo '<span class="badge badge-secondary">Di luar rentang usia</span>';
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Kontak</label>
                        <span><?php echo htmlspecialchars($peserta['kontak']) ?: '-'; ?></span>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h3><i class="fas fa-flag"></i> Informasi Keanggotaan</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Golongan</label>
                        <span class="badge badge-golongan-<?php echo $peserta['golongan']; ?>">
                            <?php echo ucfirst($peserta['golongan']); ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Status</label>
                        <span class="badge badge-<?php echo $peserta['status'] == 'aktif' ? 'success' : ($peserta['status'] == 'alumni' ? 'warning' : 'info'); ?>">
                            <?php echo ucfirst($peserta['status']); ?>
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

            <div class="detail-section">
                <h3><i class="fas fa-history"></i> Informasi Sistem</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>UUID</label>
                        <span class="uuid"><?php echo htmlspecialchars($peserta['uuid_peserta']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Dibuat Pada</label>
                        <span><?php echo date('d F Y H:i', strtotime($peserta['created_at'])); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Diupdate Pada</label>
                        <span><?php echo date('d F Y H:i', strtotime($peserta['updated_at'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
