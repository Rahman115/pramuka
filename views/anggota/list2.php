<?php
$stmt = $anggotaModel->readAll();
$num = $stmt->rowCount();
?>

<div class="page-header">
    <h2>Data Anggota</h2>
    <div class="header-actions">
        <a href="index.php?action=create&page=anggota" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Anggota
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Daftar Anggota Pramuka</h3>
    </div>
    <div class="card-body">
        <?php if($num > 0): ?>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Kategori</th>
                            <th>Tanggal Lahir</th>
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
                                    <span class="badge <?php echo $jenis_kelamin == 'L' ? 'badge-primary' : 'badge-pink'; ?>">
                                        <?php echo $jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-category-<?php echo strtolower($kategori); ?>">
                                        <?php echo ucfirst($kategori); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($tanggal_lahir)); ?></td>
                                <td><?php echo htmlspecialchars($kontak); ?></td>
                                <td class="actions">
                                    <a href="index.php?action=view&page=anggota&id=<?php echo $id_anggota; ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="index.php?action=edit&page=anggota&id=<?php echo $id_anggota; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteAnggota(<?php echo $id_anggota; ?>)" class="btn btn-danger btn-sm">
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
                <i class="fas fa-users fa-3x"></i>
                <h3>Belum ada data anggota</h3>
                <p>Mulai dengan menambahkan anggota baru</p>
                <a href="index.php?action=create&page=anggota" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Anggota
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
