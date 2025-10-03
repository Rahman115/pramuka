<?php
$stmt = $kwarcabModel->readAll();
$num = $stmt->rowCount();
?>

<div class="page-header">
    <h2>Data Pengurus Kwarcab</h2>
    <div class="header-actions">
        <a href="index.php?action=create&page=kwarcab" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pengurus
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Daftar Pengurus Kwarcab</h3>
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
                            <th>Periode</th>
                            <th>Jenis Kelamin</th>
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
                                    <span class="badge badge-primary"><?php echo htmlspecialchars($jabatan); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($periode); ?></td>
                                <td>
                                    <span class="badge <?php echo $jenis_kelamin == 'L' ? 'badge-primary' : 'badge-pink'; ?>">
                                        <?php echo $jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($kontak); ?></td>
                                <td class="actions">
                                  <a href="index.php?action=view&page=anggota&id=<?php echo $id_anggota; ?>" class="btn btn-info btn-sm">
    <i class="fas fa-eye"></i>
</a>
                                    <a href="index.php?action=edit&page=kwarcab&id=<?php echo $id_kwarcab; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteKwarcab(<?php echo $id_kwarcab; ?>)" class="btn btn-danger btn-sm">
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
                <i class="fas fa-user-tie fa-3x"></i>
                <h3>Belum ada data pengurus kwarcab</h3>
                <p>Mulai dengan menambahkan pengurus baru</p>
                <a href="index.php?action=create&page=kwarcab" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pengurus
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function deleteKwarcab(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data pengurus ini?')) {
        window.location.href = 'index.php?action=delete&page=kwarcab&id=' + id;
    }
}
</script>
