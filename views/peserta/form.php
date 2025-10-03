<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$isEdit = ($id > 0);
$peserta = $isEdit ? $pesertaDidikModel->readOne($id) : null;

// Ambil data untuk dropdown
$anggotaStmt = $anggotaModel->readAll();
$gudepStmt = $gudepModel->readAll();

if($_POST) {
    $data = [
        'id_anggota' => $_POST['id_anggota'],
        'golongan' => $_POST['golongan'],
        'id_gudep' => $_POST['id_gudep'],
        'status' => $_POST['status']
    ];

    if($isEdit) {
        $result = $pesertaDidikModel->update($id, $data);
        $message = $result ? "Data peserta didik berhasil diperbarui" : "Gagal memperbarui data";
    } else {
        $result = $pesertaDidikModel->create($data);
        $message = $result ? "Peserta didik berhasil ditambahkan" : "Gagal menambahkan peserta didik";
    }

    if($result) {
        echo "<script>alert('$message'); window.location.href='index.php?action=list&page=peserta';</script>";
    } else {
        echo "<script>alert('$message');</script>";
    }
}
?>

<div class="page-header">
    <h2><?php echo $isEdit ? 'Edit Peserta Didik' : 'Tambah Peserta Didik Baru'; ?></h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" class="form">
            <div class="form-group">
                <label for="id_anggota">Anggota *</label>
                <select id="id_anggota" name="id_anggota" required>
                    <option value="">Pilih Anggota</option>
                    <?php while ($anggota = $anggotaStmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $anggota['id_anggota']; ?>" 
                            <?php echo ($isEdit && $peserta['id_anggota'] == $anggota['id_anggota']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($anggota['nama']); ?> - <?php echo ucfirst($anggota['kategori']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="golongan">Golongan *</label>
                <select id="golongan" name="golongan" required>
                    <option value="">Pilih Golongan</option>
                    <option value="siaga" <?php echo ($isEdit && $peserta['golongan'] == 'siaga') ? 'selected' : ''; ?>>Siaga</option>
                    <option value="penggalang" <?php echo ($isEdit && $peserta['golongan'] == 'penggalang') ? 'selected' : ''; ?>>Penggalang</option>
                    <option value="penegak" <?php echo ($isEdit && $peserta['golongan'] == 'penegak') ? 'selected' : ''; ?>>Penegak</option>
                </select>
            </div>

            <div class="form-group">
                <label for="id_gudep">Gugus Depan *</label>
                <select id="id_gudep" name="id_gudep" required>
                    <option value="">Pilih Gudep</option>
                    <?php while ($gudep = $gudepStmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $gudep['id_gudep']; ?>" 
                            <?php echo ($isEdit && $peserta['id_gudep'] == $gudep['id_gudep']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($gudep['nomor_gudep']); ?> - <?php echo htmlspecialchars($gudep['nama_gudep']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="aktif" <?php echo ($isEdit && $peserta['status'] == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                    <option value="alumni" <?php echo ($isEdit && $peserta['status'] == 'alumni') ? 'selected' : ''; ?>>Alumni</option>
                    <option value="pindah" <?php echo ($isEdit && $peserta['status'] == 'pindah') ? 'selected' : ''; ?>>Pindah</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $isEdit ? 'Update' : 'Simpan'; ?>
                </button>
                <a href="index.php?action=list&page=peserta" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
