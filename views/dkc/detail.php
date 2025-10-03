<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$dkc = $dkcModel->readOne($id);

if(!$dkc) {
    echo "<script>alert('Data anggota DKC tidak ditemukan'); window.location.href='index.php?action=list&page=dkc';</script>";
    exit;
}
?>

<div class="page-header">
    <h2>Detail Anggota DKC</h2>
    <div class="header-actions">
        <a href="index.php?action=list&page=dkc" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="index.php?action=edit&page=dkc&id=<?php echo $id; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
</div>

<div class="detail-container">
    <div class="detail-card">
        <div class="detail-header">
            <div class="detail-avatar">
                <i class="fas fa-users-cog fa-3x"></i>
            </div>
            <div class="detail-title">
                <h1><?php echo htmlspecialchars($dkc['nama']); ?></h1>
                <span class="badge badge-category-dkc">Anggota DKC</span>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-section">
                <h3><i class="fas fa-info-circle"></i> Informasi Pribadi</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Nama Lengkap</label>
                        <span><?php echo htmlspecialchars($dkc['nama']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Jenis Kelamin</label>
                        <span>
                            <span class="badge <?php echo $dkc['jenis_kelamin'] == 'L' ? 'badge-primary' : 'badge-pink'; ?>">
                                <?php echo $dkc['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Lahir</label>
                        <span><?php echo $dkc['tanggal_lahir'] ? date('d F Y', strtotime($dkc['tanggal_lahir'])) : '-'; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Kontak</label>
                        <span><?php echo htmlspecialchars($dkc['kontak']) ?: '-'; ?></span>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h3><i class="fas fa-briefcase"></i> Informasi Jabatan</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Jabatan</label>
                        <span class="badge badge-primary"><?php echo htmlspecialchars($dkc['jabatan']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Periode</label>
                        <span><?php echo htmlspecialchars($dkc['periode']); ?></span>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h3><i class="fas fa-history"></i> Informasi Sistem</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>UUID</label>
                        <span class="uuid"><?php echo htmlspecialchars($dkc['uuid_dkc']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Dibuat Pada</label>
                        <span><?php echo date('d F Y H:i', strtotime($dkc['created_at'])); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Diupdate Pada</label>
                        <span><?php echo date('d F Y H:i', strtotime($dkc['updated_at'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
