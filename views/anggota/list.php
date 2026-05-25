<?php
$stmt = $anggotaModel->readAll();
$num = $stmt->rowCount();

// Ambil parameter filter jika ada
$filterStatus = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';
$filterGolongan = isset($_GET['filter_golongan']) ? $_GET['filter_golongan'] : '';
$filterKecamatan = isset($_GET['filter_kecamatan']) ? $_GET['filter_kecamatan'] : '';

// Jika ada filter, gunakan method filter
if($filterStatus || $filterGolongan || $filterKecamatan) {
    $stmt = $anggotaModel->filter($filterStatus, $filterGolongan, $filterKecamatan);
    $num = $stmt->rowCount();
}

// Data untuk dropdown filter
$kecamatanList = [
    'Kulisusu', 'Kulisusu Utara', 'Kulisusu Barat', 
    'Bonegunu', 'Kambowa', 'Wakorumba Utara'
];
?>

<div class="page-header">
    <h2><i class="fas fa-users"></i> Data Anggota</h2>
    <div class="header-actions">
        <a href="index.php?action=create&page=anggota" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Anggota
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Daftar Anggota Pramuka</h3>
    </div>
    <div class="card-body">
        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" class="filter-form">
                <input type="hidden" name="action" value="list">
                <input type="hidden" name="page" value="anggota">
                
                <div class="filter-row">
                    <div class="filter-group">
                        <label><i class="fas fa-filter"></i> Status Anggota</label>
                        <select name="filter_status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="muda" <?php echo $filterStatus == 'muda' ? 'selected' : ''; ?>>Muda</option>
                            <option value="dewasa" <?php echo $filterStatus == 'dewasa' ? 'selected' : ''; ?>>Dewasa</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label><i class="fas fa-star"></i> Golongan Pramuka</label>
                        <select name="filter_golongan" class="form-control">
                            <option value="">Semua Golongan</option>
                            <optgroup label="Golongan Muda">
                                <option value="siaga" <?php echo $filterGolongan == 'siaga' ? 'selected' : ''; ?>>Siaga</option>
                                <option value="penggalang" <?php echo $filterGolongan == 'penggalang' ? 'selected' : ''; ?>>Penggalang</option>
                                <option value="penegak" <?php echo $filterGolongan == 'penegak' ? 'selected' : ''; ?>>Penegak</option>
                                <option value="pandega" <?php echo $filterGolongan == 'pandega' ? 'selected' : ''; ?>>Pandega</option>
                            </optgroup>
                            <optgroup label="Golongan Dewasa">
                                <option value="Andalan" <?php echo $filterGolongan == 'Andalan' ? 'selected' : ''; ?>>Andalan</option>
                                <option value="Pembina" <?php echo $filterGolongan == 'Pembina' ? 'selected' : ''; ?>>Pembina</option>
                                <option value="Mabigus" <?php echo $filterGolongan == 'Mabigus' ? 'selected' : ''; ?>>Mabigus</option>
                                <option value="Mabicab" <?php echo $filterGolongan == 'Mabicab' ? 'selected' : ''; ?>>Mabicab</option>
                                <option value="Instruktur" <?php echo $filterGolongan == 'Instruktur' ? 'selected' : ''; ?>>Instruktur</option>
                            </optgroup>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label><i class="fas fa-map-marker-alt"></i> Kecamatan</label>
                        <select name="filter_kecamatan" class="form-control">
                            <option value="">Semua Kecamatan</option>
                            <?php foreach($kecamatanList as $kec): ?>
                                <option value="<?php echo $kec; ?>" <?php echo $filterKecamatan == $kec ? 'selected' : ''; ?>>
                                    <?php echo $kec; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="index.php?action=list&page=anggota" class="btn btn-secondary btn-sm">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Search Box -->
        <div class="search-box">
            <form method="GET" class="search-form" onsubmit="return false;">
                <input type="hidden" name="action" value="list">
                <input type="hidden" name="page" value="anggota">
                <div class="search-group">
                    <input type="text" id="search_keyword" name="search" class="form-control" 
                           placeholder="Cari berdasarkan Nama, KTA, Email, atau Telepon...">
                    <button type="button" class="btn btn-primary" onclick="searchAnggota()">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Result Count -->
        <div class="result-count">
            <i class="fas fa-database"></i> Ditemukan <strong><?php echo $num; ?></strong> data anggota
        </div>

        <?php if($num > 0): ?>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>KTA</th>
                            <th>Nama Lengkap</th>
                            <th>Status</th>
                            <th>Golongan Pramuka</th>
                            <th>Tempat, Tgl Lahir</th>
                            <th>Kecamatan</th>
                            <th>Kontak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($row['kta']); ?></strong>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($row['nama_lengkap']); ?>
                                </td>
                                <td>
                                    <?php if($row['status_anggota'] == 'muda'): ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-child"></i> Muda
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-primary">
                                            <i class="fas fa-user-tie"></i> Dewasa
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-golongan-<?php echo strtolower($row['golongan_pramuka']); ?>">
                                        <?php 
                                        $golonganIcons = [
                                            'siaga' => '🏕️',
                                            'penggalang' => '🚩',
                                            'penegak' => '⚡',
                                            'pandega' => '🎓',
                                            'Andalan' => '🌟',
                                            'Pembina' => '👨‍🏫',
                                            'Mabigus' => '🏛️',
                                            'Mabicab' => '🏢',
                                            'Instruktur' => '📚'
                                        ];
                                        $icon = isset($golonganIcons[$row['golongan_pramuka']]) ? $golonganIcons[$row['golongan_pramuka']] : '';
                                        echo $icon . ' ' . ucfirst($row['golongan_pramuka']);
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $tempat = htmlspecialchars($row['tempat_lahir']) ?: '-';
                                    $tgl = $row['tanggal_lahir'] ? date('d/m/Y', strtotime($row['tanggal_lahir'])) : '-';
                                    echo $tempat . '<br><small>' . $tgl . '</small>';
                                    ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($row['kecamatan']) ?: '-'; ?>
                                </td>
                                <td>
                                    <?php if($row['nomor_telp']): ?>
                                        <a href="tel:<?php echo htmlspecialchars($row['nomor_telp']); ?>" class="contact-link">
                                            <i class="fas fa-phone"></i> <?php echo htmlspecialchars($row['nomor_telp']); ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if($row['email']): ?>
                                        <br>
                                        <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="contact-link">
                                            <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($row['email']); ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if(!$row['nomor_telp'] && !$row['email']): ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="actions">
                                    <a href="index.php?action=view&page=anggota&id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="index.php?action=edit&page=anggota&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteAnggota(<?php echo $row['id']; ?>)" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-users fa-4x"></i>
                <h3>Belum ada data anggota</h3>
                <p>Mulai dengan menambahkan anggota baru ke sistem</p>
                <a href="index.php?action=create&page=anggota" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Anggota Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function deleteAnggota(id) {
    if(confirm('Apakah Anda yakin ingin menghapus data anggota ini?\n\nData yang dihapus tidak dapat dikembalikan!')) {
        window.location.href = 'index.php?action=delete&page=anggota&id=' + id;
    }
}

function searchAnggota() {
    var keyword = document.getElementById('search_keyword').value;
    if(keyword.trim() !== '') {
        window.location.href = 'index.php?action=list&page=anggota&search=' + encodeURIComponent(keyword);
    }
}

// Support Enter key for search
document.getElementById('search_keyword')?.addEventListener('keypress', function(e) {
    if(e.key === 'Enter') {
        searchAnggota();
    }
});
</script>

<style>
/* Filter Section Styles */
.filter-section {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: flex-end;
}

.filter-group {
    flex: 1;
    min-width: 180px;
}

.filter-group label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--text-light);
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.2rem;
}

/* Search Box Styles */
.search-box {
    margin-bottom: 1.5rem;
}

.search-group {
    display: flex;
    gap: 0.5rem;
}

.search-group .form-control {
    flex: 1;
}

/* Result Count */
.result-count {
    background: #e8f5e9;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    margin-bottom: 1rem;
    font-size: 0.85rem;
    color: var(--primary);
}

.result-count i {
    margin-right: 0.5rem;
}

/* Contact Links */
.contact-link {
    color: var(--primary);
    text-decoration: none;
    font-size: 0.8rem;
}

.contact-link:hover {
    text-decoration: underline;
    color: var(--primary-dark);
}

/* Golongan Badge Styles */
.badge-golongan-siaga { background-color: #4caf50; }
.badge-golongan-penggalang { background-color: #2196f3; }
.badge-golongan-penegak { background-color: #607d8b; }
.badge-golongan-pandega { background-color: #9c27b0; }
.badge-golongan-andalan { background-color: #ff9800; }
.badge-golongan-pembina { background-color: #e91e63; }
.badge-golongan-mabigus { background-color: #3f51b5; }
.badge-golongan-mabicab { background-color: #009688; }
.badge-golongan-instruktur { background-color: #795548; }

/* Table Styles */
.data-table td {
    vertical-align: middle;
}

.data-table small {
    font-size: 0.7rem;
    color: var(--text-light);
}

.text-center {
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-row {
        flex-direction: column;
    }
    
    .filter-group {
        width: 100%;
    }
    
    .filter-actions {
        width: 100%;
        justify-content: flex-end;
    }
    
    .search-group {
        flex-direction: column;
    }
    
    .data-table {
        font-size: 0.75rem;
    }
    
    .data-table td, 
    .data-table th {
        padding: 0.5rem 0.25rem;
    }
    
    .btn-sm {
        padding: 0.2rem 0.4rem;
        font-size: 0.7rem;
    }
}
</style>