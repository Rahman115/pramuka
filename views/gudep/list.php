<?php
$stmt = $gudepModel->readAll();
$num = $stmt->rowCount();
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
        <?php if($num > 0): ?>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Gudep</th>
                            <th>Nama Gudep</th>
                            <th>Pangkalan</th>
                            <th>Alamat</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                            extract($row);
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><strong><?php echo htmlspecialchars($nomor_gudep); ?></strong></td>
                                <td><?php echo htmlspecialchars($nama_gudep); ?></td>
                                <td><?php echo htmlspecialchars($pangkalan); ?></td>
                                <td><?php echo htmlspecialchars(substr($alamat, 0, 50)) . (strlen($alamat) > 50 ? '...' : ''); ?></td>
                                <td><?php echo htmlspecialchars(substr($keterangan, 0, 30)) . (strlen($keterangan) > 30 ? '...' : ''); ?></td>
                                <td class="actions">
                                    <a href="index.php?action=view&page=gudep&id=<?php echo $id_gudep; ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="index.php?action=edit&page=gudep&id=<?php echo $id_gudep; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteGudep(<?php echo $id_gudep; ?>)" class="btn btn-danger btn-sm">
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
                <h3>Belum ada data gugus depan</h3>
                <p>Mulai dengan menambahkan gugus depan baru</p>
                <a href="index.php?action=create&page=gudep" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Gudep
                </a>
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
