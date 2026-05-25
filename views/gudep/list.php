<?php
// Ambil parameter filter
$filter_tingkatan = isset($_GET['filter_tingkatan']) ? $_GET['filter_tingkatan'] : '';
$filter_kecamatan = isset($_GET['filter_kecamatan']) ? $_GET['filter_kecamatan'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query dengan filter
$query = "SELECT * FROM " . $gudepModel->table_name . " WHERE 1=1";
$params = [];

if (!empty($filter_tingkatan)) {
    $query .= " AND tingkatan = :tingkatan";
    $params[':tingkatan'] = $filter_tingkatan;
}

if (!empty($filter_kecamatan)) {
    $query .= " AND kecamatan = :kecamatan";
    $params[':kecamatan'] = $filter_kecamatan;
}

if (!empty($search)) {
    $query .= " AND (nomor_gudep LIKE :search 
                    OR nama_gudep LIKE :search 
                    OR pangkalan LIKE :search 
                    OR alamat LIKE :search
                    OR npsn LIKE :search
                    OR kepala_sekolah LIKE :search)";
    $params[':search'] = "%$search%";
}

$query .= " ORDER BY created_at DESC";

$stmt = $gudepModel->conn->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$num = $stmt->rowCount();

// Daftar kecamatan
$kecamatan_list = [
    'Kulisusu',
    'Kulisusu Utara',
    'Kulisusu Barat',
    'Bonegunu',
    'Kambowa',
    'Wakorumba Utara'
];
?>

<div class="page-header">
    <h2>Data Gugus Depan</h2>
    <div class="header-actions">
        <a href="index.php?action=create&page=gudep" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Gudep
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Daftar Gugus Depan</h3>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <div class="filter-section">
            <form method="GET" class="filter-form">
                <input type="hidden" name="page" value="gudep">
                <input type="hidden" name="action" value="list">
                
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="filter_tingkatan">Tingkatan</label>
                        <select name="filter_tingkatan" id="filter_tingkatan" class="form-control">
                            <option value="">Semua Tingkatan</option>
                            <option value="SD" <?php echo $filter_tingkatan == 'SD' ? 'selected' : ''; ?>>SD</option>
                            <option value="SMP" <?php echo $filter_tingkatan == 'SMP' ? 'selected' : ''; ?>>SMP</option>
                            <option value="SMA/SMK" <?php echo $filter_tingkatan == 'SMA/SMK' ? 'selected' : ''; ?>>SMA/SMK</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="filter_kecamatan">Kecamatan</label>
                        <select name="filter_kecamatan" id="filter_kecamatan" class="form-control">
                            <option value="">Semua Kecamatan</option>
                            <?php foreach ($kecamatan_list as $kec): ?>
                                <option value="<?php echo $kec; ?>" <?php echo $filter_kecamatan == $kec ? 'selected' : ''; ?>>
                                    <?php echo $kec; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group search-group">
                        <label for="search">Pencarian</label>
                        <div class="search-input-wrapper">
                            <input type="text" name="search" id="search" class="form-control" 
                                   placeholder="Cari nomor/nama gudep, pangkalan..." 
                                   value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>

                    <div class="filter-group reset-group">
                        <label>&nbsp;</label>
                        <a href="index.php?page=gudep&action=list" class="btn btn-secondary">
                            <i class="fas fa-undo-alt"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Result Info -->
        <div class="result-info">
            <p>Menampilkan <strong><?php echo $num; ?></strong> data gugus depan</p>
            <?php if (!empty($filter_tingkatan) || !empty($filter_kecamatan) || !empty($search)): ?>
                <div class="active-filters">
                    <span>Filter aktif:</span>
                    <?php if (!empty($filter_tingkatan)): ?>
                        <span class="filter-badge">Tingkatan: <?php echo $filter_tingkatan; ?></span>
                    <?php endif; ?>
                    <?php if (!empty($filter_kecamatan)): ?>
                        <span class="filter-badge">Kecamatan: <?php echo $filter_kecamatan; ?></span>
                    <?php endif; ?>
                    <?php if (!empty($search)): ?>
                        <span class="filter-badge">Pencarian: "<?php echo htmlspecialchars($search); ?>"</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if($num > 0): ?>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Gudep</th>
                            <th>Nama Gudep</th>
                            <th>Pangkalan</th>
                            <th>Kecamatan</th>
                            <th>Tingkatan</th>
                            <th>NPSN</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><strong><?php echo htmlspecialchars($row['nomor_gudep']); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['nama_gudep']); ?></td>
                                <td><?php echo htmlspecialchars($row['pangkalan']); ?></td>
                                <td>
                                    <?php 
                                    $kec = htmlspecialchars($row['kecamatan']);
                                    $badge_class = '';
                                    switch($kec) {
                                        case 'Kulisusu': $badge_class = 'badge-info'; break;
                                        case 'Kulisusu Utara': $badge_class = 'badge-primary'; break;
                                        case 'Kulisusu Barat': $badge_class = 'badge-success'; break;
                                        case 'Bonegunu': $badge_class = 'badge-warning'; break;
                                        case 'Kambowa': $badge_class = 'badge-secondary'; break;
                                        case 'Wakorumba Utara': $badge_class = 'badge-pink'; break;
                                        default: $badge_class = 'badge-secondary';
                                    }
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>"><?php echo $kec ?: '-'; ?></span>
                                </td>
                                <td>
                                    <?php 
                                    $tingkat = $row['tingkatan'];
                                    $tingkat_badge = '';
                                    switch($tingkat) {
                                        case 'SD': $tingkat_badge = 'badge-success'; break;
                                        case 'SMP': $tingkat_badge = 'badge-info'; break;
                                        case 'SMA/SMK': $tingkat_badge = 'badge-primary'; break;
                                        default: $tingkat_badge = 'badge-secondary';
                                    }
                                    ?>
                                    <span class="badge <?php echo $tingkat_badge; ?>"><?php echo $tingkat ?: '-'; ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($row['npsn']) ?: '-'; ?></td>
                                <td><?php echo htmlspecialchars(substr($row['alamat'], 0, 40)) . (strlen($row['alamat']) > 40 ? '...' : ''); ?></td>
                                <td class="actions">
                                    <a href="index.php?action=view&page=gudep&id=<?php echo $row['id_gudep']; ?>" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="index.php?action=edit&page=gudep&id=<?php echo $row['id_gudep']; ?>" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteGudep(<?php echo $row['id_gudep']; ?>)" class="btn btn-danger btn-sm" title="Hapus">
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
                <i class="fas fa-flag fa-3x"></i>
                <h3>Tidak ada data gugus depan</h3>
                <p>
                    <?php if (!empty($filter_tingkatan) || !empty($filter_kecamatan) || !empty($search)): ?>
                        Tidak ditemukan data yang sesuai dengan filter yang dipilih.
                        <br>
                        <a href="index.php?page=gudep&action=list">Klik di sini untuk reset filter</a>
                    <?php else: ?>
                        Mulai dengan menambahkan gugus depan baru
                    <?php endif; ?>
                </p>
                <?php if (empty($filter_tingkatan) && empty($filter_kecamatan) && empty($search)): ?>
                    <a href="index.php?action=create&page=gudep" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Gudep
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function deleteGudep(id) {
    if (confirm('Apakah Anda yakin ingin menghapus gudep ini?')) {
        window.location.href = 'index.php?action=delete&page=gudep&id=' + id;
    }
}
</script>

<style>
/* Filter Section Styles */
.filter-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.filter-form {
    width: 100%;
}

.filter-row {
    display: grid;
    grid-template-columns: 200px 200px 1fr auto;
    gap: 1rem;
    align-items: flex-end;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #555;
}

.search-input-wrapper {
    display: flex;
    gap: 0.5rem;
}

.search-input-wrapper input {
    flex: 1;
}

.search-input-wrapper button {
    white-space: nowrap;
}

.reset-group {
    justify-content: flex-end;
}

/* Result Info */
.result-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.result-info p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

.active-filters {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.active-filters span:first-child {
    color: #666;
    font-size: 0.85rem;
}

.filter-badge {
    background: #e0e0e0;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    color: #333;
}

/* Badge Colors Extension */
.badge-pink {
    background-color: #e91e63;
}

/* Responsive */
@media (max-width: 900px) {
    .filter-row {
        grid-template-columns: 1fr 1fr;
    }
    
    .search-group {
        grid-column: span 2;
    }
    
    .reset-group {
        grid-column: span 2;
        align-items: flex-start;
    }
}

@media (max-width: 600px) {
    .filter-row {
        grid-template-columns: 1fr;
    }
    
    .search-group {
        grid-column: span 1;
    }
    
    .reset-group {
        grid-column: span 1;
    }
    
    .search-input-wrapper {
        flex-direction: column;
    }
    
    .result-info {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>