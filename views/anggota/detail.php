<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$anggota = $anggotaModel->readOne($id);

if(!$anggota) {
    echo "<script>alert('Data anggota tidak ditemukan'); window.location.href='index.php?action=list&page=anggota';</script>";
    exit;
}

// Hitung umur dari tanggal lahir
function hitungUmur($tanggal_lahir) {
    if(empty($tanggal_lahir)) return '-';
    $lahir = new DateTime($tanggal_lahir);
    $sekarang = new DateTime();
    $umur = $sekarang->diff($lahir);
    return $umur->y . ' tahun';
}
?>

<div class="page-header">
    <h2><i class="fas fa-user-circle"></i> Detail Anggota</h2>
    <div class="header-actions">
        <a href="index.php?action=list&page=anggota" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="index.php?action=edit&page=anggota&id=<?php echo $id; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <button type="button" class="btn btn-info" onclick="window.print();">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>
</div>

<div class="detail-container">
    <div class="detail-card">
        <div class="detail-header">
            <div class="detail-avatar">
                <i class="fas fa-user-circle fa-4x"></i>
            </div>
            <div class="detail-title">
                <h1><?php echo htmlspecialchars($anggota['nama_lengkap']); ?></h1>
                <div class="badge-group">
                    <span class="badge badge-<?php echo $anggota['status_anggota'] == 'muda' ? 'success' : 'primary'; ?>">
                        <i class="fas fa-<?php echo $anggota['status_anggota'] == 'muda' ? 'child' : 'user-tie'; ?>"></i>
                        <?php echo ucfirst($anggota['status_anggota']); ?>
                    </span>
                    <span class="badge badge-category-<?php echo strtolower($anggota['golongan_pramuka']); ?>">
                        <i class="fas fa-star"></i>
                        <?php echo ucfirst($anggota['golongan_pramuka']); ?>
                    </span>
                    <?php if($anggota['golongan_darah']): ?>
                    <span class="badge badge-info">
                        <i class="fas fa-tint"></i>
                        Gol. Darah: <?php echo $anggota['golongan_darah']; ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="detail-grid">
            <!-- Informasi Pribadi -->
            <div class="detail-section">
                <h3><i class="fas fa-id-card"></i> Informasi Pribadi</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Nomor KTA</label>
                        <span><strong><?php echo htmlspecialchars($anggota['kta']); ?></strong></span>
                    </div>
                    <div class="info-item">
                        <label>Nama Lengkap</label>
                        <span><?php echo htmlspecialchars($anggota['nama_lengkap']); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Tempat, Tanggal Lahir</label>
                        <span>
                            <?php 
                            $tempat = htmlspecialchars($anggota['tempat_lahir']) ?: '-';
                            $tgl = $anggota['tanggal_lahir'] ? date('d F Y', strtotime($anggota['tanggal_lahir'])) : '-';
                            echo $tempat . ', ' . $tgl;
                            ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Umur</label>
                        <span><?php echo hitungUmur($anggota['tanggal_lahir']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Informasi Alamat -->
            <div class="detail-section">
                <h3><i class="fas fa-map-marker-alt"></i> Informasi Alamat</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Kecamatan</label>
                        <span><?php echo htmlspecialchars($anggota['kecamatan']) ?: '-'; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Kelurahan/Desa</label>
                        <span><?php echo htmlspecialchars($anggota['kelurahan']) ?: '-'; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Alamat Lengkap</label>
                        <span><?php echo nl2br(htmlspecialchars($anggota['alamat_lengkap'])) ?: '-'; ?></span>
                    </div>
                </div>
            </div>

            <!-- Informasi Kontak -->
            <div class="detail-section">
                <h3><i class="fas fa-address-card"></i> Informasi Kontak</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Email</label>
                        <span>
                            <?php if($anggota['email']): ?>
                                <a href="mailto:<?php echo htmlspecialchars($anggota['email']); ?>">
                                    <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($anggota['email']); ?>
                                </a>
                            <?php else: echo '-'; endif; ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Nomor Telepon</label>
                        <span>
                            <?php if($anggota['nomor_telp']): ?>
                                <a href="tel:<?php echo htmlspecialchars($anggota['nomor_telp']); ?>">
                                    <i class="fas fa-phone"></i> <?php echo htmlspecialchars($anggota['nomor_telp']); ?>
                                </a>
                            <?php else: echo '-'; endif; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informasi Kepramukaan -->
            <div class="detail-section">
                <h3><i class="fas fa-campground"></i> Informasi Kepramukaan</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>Status Anggota</label>
                        <span>
                            <?php if($anggota['status_anggota'] == 'muda'): ?>
                                <span class="badge badge-success">Muda (Peserta Didik)</span>
                            <?php else: ?>
                                <span class="badge badge-primary">Dewasa (Pembina/Pengurus)</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Golongan Pramuka</label>
                        <span>
                            <span class="badge badge-category-<?php echo strtolower($anggota['golongan_pramuka']); ?>">
                                <?php 
                                $golonganLabels = [
                                    'siaga' => '🏕️ Siaga',
                                    'penggalang' => '🚩 Penggalang', 
                                    'penegak' => '⚡ Penegak',
                                    'pandega' => '🎓 Pandega',
                                    'Andalan' => '🌟 Andalan',
                                    'Pembina' => '👨‍🏫 Pembina',
                                    'Mabigus' => '🏛️ Mabigus',
                                    'Mabicab' => '🏢 Mabicab',
                                    'Instruktur' => '📚 Instruktur'
                                ];
                                $label = isset($golonganLabels[$anggota['golongan_pramuka']]) 
                                        ? $golonganLabels[$anggota['golongan_pramuka']] 
                                        : ucfirst($anggota['golongan_pramuka']);
                                echo $label;
                                ?>
                            </span>
                        </span>
                    </div>
                    <?php if($anggota['status_anggota'] == 'dewasa'): ?>
                    <div class="info-item">
                        <label>Peran/Kualifikasi</label>
                        <span>
                            <?php
                            $peranLabels = [
                                'Andalan' => 'Andalan Kwartir',
                                'Pembina' => 'Pembina Gugus Depan',
                                'Mabigus' => 'Majelis Pembimbing Gugus Depan',
                                'Mabicab' => 'Majelis Pembimbing Cabang',
                                'Instruktur' => 'Instruktur Nasional/Daerah'
                            ];
                            echo isset($peranLabels[$anggota['golongan_pramuka']]) 
                                 ? $peranLabels[$anggota['golongan_pramuka']] 
                                 : ucfirst($anggota['golongan_pramuka']);
                            ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Informasi Sistem -->
            <div class="detail-section">
                <h3><i class="fas fa-history"></i> Informasi Sistem</h3>
                <div class="detail-info">
                    <div class="info-item">
                        <label>ID Anggota</label>
                        <span class="uuid">#<?php echo $anggota['id']; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Data Masuk</label>
                        <span><i class="fas fa-calendar-plus"></i> <?php //echo date('d F Y H:i:s', strtotime($anggota['created_at'] ?? date('Y-m-d H:i:s'))); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Terakhir Update</label>
                        <span><i class="fas fa-edit"></i> <?php // echo date('d F Y H:i:s', strtotime($anggota['updated_at'] ?? date('Y-m-d H:i:s'))); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="detail-footer">
            <hr>
            <div class="form-actions" style="justify-content: center;">
                <a href="index.php?action=list&page=anggota" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
                <a href="index.php?action=edit&page=anggota&id=<?php echo $id; ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo $id; ?>)">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if(confirm('Apakah Anda yakin ingin menghapus data anggota ini?\nData yang dihapus tidak dapat dikembalikan!')) {
        window.location.href = 'index.php?action=delete&page=anggota&id=' + id;
    }
}

// Tambahkan CSS untuk tampilan print
@media print {
    .header-actions, .detail-footer, .btn, .form-actions, .navbar, .footer {
        display: none !important;
    }
    .detail-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
    .badge {
        border: 1px solid #000 !important;
        background: white !important;
        color: black !important;
    }
}
</script>

<!-- Tambahan CSS untuk detail page -->
<style>
.detail-footer {
    margin-top: 1rem;
    padding: 1rem 2rem 2rem 2rem;
}

.detail-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.detail-avatar i {
    font-size: 3rem;
    color: white;
}

.badge-group {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-top: 0.75rem;
}

.badge-category-siaga { background-color: #4caf50; }
.badge-category-penggalang { background-color: #2196f3; }
.badge-category-penegak { background-color: #607d8b; }
.badge-category-pandega { background-color: #9c27b0; }
.badge-category-andalan { background-color: #ff9800; }
.badge-category-pembina { background-color: #e91e63; }
.badge-category-mabigus { background-color: #3f51b5; }
.badge-category-mabicab { background-color: #009688; }
.badge-category-instruktur { background-color: #795548; }

.info-item a {
    color: var(--primary);
    text-decoration: none;
}

.info-item a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .badge-group {
        justify-content: center;
    }
    
    .detail-header {
        text-align: center;
    }
    
    .detail-title h1 {
        font-size: 1.3rem;
    }
}
</style>