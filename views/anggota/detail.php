<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$anggota = $anggotaModel->readOne($id);

if(!$anggota) {
    echo "<script>alert('Data anggota tidak ditemukan'); window.location.href='index.php?action=list&page=anggota';</script>";
    exit;
}

// Ambil data tambahan berdasarkan kategori
$detailInfo = null;
switch($anggota['kategori']) {
    case 'kwarcab':
        $detailInfo = $kwarcabModel->getByAnggota($id);
        break;
    case 'dkc':
        $detailInfo = $dkcModel->getByAnggota($id);
        break;
    case 'pendamping':
        $detailInfo = $pendampingModel->getByAnggota($id);
        break;
    case 'siaga':
    case 'penggalang':
    case 'penegak':
        $detailInfo = $pesertaDidikModel->getByAnggota($id);
        break;
}
?>

<div class="page-header">
    <h2>Detail Anggota</h2>
    <div class="header-actions">
        <a href="index.php?action=list&page=anggota" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="index.php?action=edit&page=anggota&id=<?php echo $id; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
</div>

<div class="detail-container">
    <div class="detail-card">
        <div class="detail-header">
            <div class="detail-avatar">
                <i class="fas fa-user fa-3x"></i>
            </div>
            <div class="detail-title">
                <h1><?php echo htmlspecialchars($anggota['nama']); ?></h1>
                <span class="badge badge-category-<?php echo strtolower($anggota['kategori']); ?>">
                    <?php echo ucfirst($anggota['kategori']); ?>
                </span>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-section">
                <h3><i class="fas fa-info-circle"></i> Informasi Pribadi</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Nama Lengkap</label>
                        <span><?php echo htmlspecialchars($anggota['nama']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Jenis Kelamin</label>
                        <span>
                            <span class="badge <?php echo $anggota['jenis_kelamin'] == 'L' ? 'badge-primary' : 'badge-pink'; ?>">
                                <?php echo $anggota['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Lahir</label>
                        <span><?php echo $anggota['tanggal_lahir'] ? date('d F Y', strtotime($anggota['tanggal_lahir'])) : '-'; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Kontak</label>
                        <span><?php echo htmlspecialchars($anggota['kontak']) ?: '-'; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Daftar</label>
                        <span><?php echo date('d F Y', strtotime($anggota['tanggal_daftar'])); ?></span>
                    </div>
                </div>
            </div>

            <?php if($detailInfo): ?>
            <div class="detail-section">
                <h3><i class="fas fa-star"></i> Informasi <?php echo ucfirst($anggota['kategori']); ?></h3>
                <div class="detail-info">
                    <?php if($anggota['kategori'] == 'kwarcab' || $anggota['kategori'] == 'dkc'): ?>
                        <div class="info-item">
                            <label>Jabatan</label>
                            <span><?php echo htmlspecialchars($detailInfo['jabatan']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>Periode</label>
                            <span><?php echo htmlspecialchars($detailInfo['periode']); ?></span>
                        </div>
                    <?php elseif($anggota['kategori'] == 'pendamping'): ?>
                        <div class="info-item">
                            <label>Jabatan</label>
                            <span><?php echo ucfirst(str_replace('_', ' ', $detailInfo['jabatan'])); ?></span>
                        </div>
                        <div class="info-item">
                            <label>Gudep</label>
                            <span>
                                <?php 
                                $gudepInfo = $gudepModel->readOne($detailInfo['id_gudep']);
                                echo $gudepInfo ? htmlspecialchars($gudepInfo['nama_gudep']) : '-';
                                ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <label>Keterangan</label>
                            <span><?php echo htmlspecialchars($detailInfo['keterangan']) ?: '-'; ?></span>
                        </div>
                    <?php elseif(in_array($anggota['kategori'], ['siaga', 'penggalang', 'penegak'])): ?>
                        <div class="info-item">
                            <label>Golongan</label>
                            <span class="badge badge-golongan-<?php echo $detailInfo['golongan']; ?>">
                                <?php echo ucfirst($detailInfo['golongan']); ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <label>Gudep</label>
                            <span>
                                <?php 
                                $gudepInfo = $gudepModel->readOne($detailInfo['id_gudep']);
                                echo $gudepInfo ? htmlspecialchars($gudepInfo['nama_gudep']) : '-';
                                ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <label>Status</label>
                            <span class="badge badge-<?php echo $detailInfo['status'] == 'aktif' ? 'success' : ($detailInfo['status'] == 'alumni' ? 'warning' : 'info'); ?>">
                                <?php echo ucfirst($detailInfo['status']); ?>
                            </span>
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
                        <span class="uuid"><?php echo htmlspecialchars($anggota['uuid_anggota']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Dibuat Pada</label>
                        <span><?php echo date('d F Y H:i', strtotime($anggota['created_at'])); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Diupdate Pada</label>
                        <span><?php echo date('d F Y H:i', strtotime($anggota['updated_at'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
