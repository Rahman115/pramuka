<?php
$stmt = $pendampingModel->readAll();
$num = $stmt->rowCount();
?>

<div class="page-header">
    <h2>Data Pendamping/Pembina</h2>
    <div class="header-actions">
        <a href="index.php?action=create&page=pendamping" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pendamping
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Daftar Pendamping/Pembina Gudep</h3>
    </div>
    <div class="card-body">
        <?php if($num > 0): ?>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Gudep</th>
                            <th>Pangkalan</th>
                            <th>Kontak</th>
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
                                <td><?php echo htmlspecialchars($nama); ?></td>
                                <td>
                                    <span class="badge badge-warning"><?php echo ucfirst(str_replace('_', ' ', $jabatan)); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($nomor_gudep); ?></strong><br>
                                    <small><?php echo htmlspecialchars($nama_gudep); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($pangkalan); ?></td>
                                <td><?php echo htmlspecialchars($kontak); ?></td>
                                <td class="actions">
                                    <a href="index.php?action=edit&page=pendamping&id=<?php echo $id_pendamping; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deletePendamping(<?php echo $id_pendamping; ?>)" class="btn btn-danger btn-sm">
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
                <i class="fas fa-chalkboard-teacher fa-3x"></i>
                <h3>Belum ada data pendamping</h3>
                <p>Mulai dengan menambahkan pendamping baru</p>
                <a href="index.php?action=create&page=pendamping" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pendamping
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function deletePendamping(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data pendamping ini?')) {
        window.location.href = 'index.php?action=delete&page=pendamping&id=' + id;
    }
}
</script>
