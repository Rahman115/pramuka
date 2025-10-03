<?php
$stmt = $pesertaDidikModel->readAll();
$num = $stmt->rowCount();
?>

<div class="page-header">
    <h2>Data Peserta Didik</h2>
    <div class="header-actions">
        <a href="index.php?action=create&page=peserta" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Peserta
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Daftar Peserta Didik</h3>
    </div>
    <div class="card-body">
        <?php if($num > 0): ?>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Golongan</th>
                            <th>Gudep</th>
                            <th>Pangkalan</th>
                            <th>Status</th>
                            <th>Tanggal Lahir</th>
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
                                    <span class="badge badge-golongan-<?php echo $golongan; ?>">
                                        <?php echo ucfirst($golongan); ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($nomor_gudep); ?></strong><br>
                                    <small><?php echo htmlspecialchars($nama_gudep); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($pangkalan); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $status == 'aktif' ? 'success' : ($status == 'alumni' ? 'warning' : 'info'); ?>">
                                        <?php echo ucfirst($status); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($tanggal_lahir)); ?></td>
                                <td class="actions">
                                    <a href="index.php?action=edit&page=peserta&id=<?php echo $id_peserta; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deletePeserta(<?php echo $id_peserta; ?>)" class="btn btn-danger btn-sm">
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
                <i class="fas fa-user-graduate fa-3x"></i>
                <h3>Belum ada data peserta didik</h3>
                <p>Mulai dengan menambahkan peserta didik baru</p>
                <a href="index.php?action=create&page=peserta" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Peserta
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function deletePeserta(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data peserta didik ini?')) {
        window.location.href = 'index.php?action=delete&page=peserta&id=' + id;
    }
}
</script>
