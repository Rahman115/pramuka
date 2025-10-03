<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$isEdit = ($id > 0);
$pendamping = $isEdit ? $pendampingModel->readOne($id) : null;

// Ambil data untuk dropdown
$anggotaStmt = $anggotaModel->readAll();
$gudepStmt = $gudepModel->readAll();

if($_POST) {
    $data = [
        'id_anggota' => $_POST['id_anggota'],
        'id_gudep' => $_POST['id_gudep'],
        'jabatan' => $_POST['jabatan'],
        'keterangan' => $_POST['keterangan']
    ];

    if($isEdit) {
        $result = $pendampingModel->update($id, $data);
        $message = $result ? "Data pendamping berhasil diperbarui" : "Gagal memperbarui data";
    } else {
        $result = $pendampingModel->create($data);
        $message = $result ? "Pendamping berhasil ditambahkan" : "Gagal menambahkan pendamping";
    }

    if($result) {
        echo "<script>alert('$message'); window.location.href='index.php?action=list&page=pendamping';</script>";
    } else {
        echo "<script>alert('$message');</script>";
    }
}
?>

<div class="page-header">
    <h2><?php echo $isEdit ? 'Edit Pendamping' : 'Tambah Pendamping Baru'; ?></h2>
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
                            <?php echo ($isEdit && $pendamping['id_anggota'] == $anggota['id_anggota']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($anggota['nama']); ?> - <?php echo ucfirst($anggota['kategori']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_gudep">Gugus Depan *</label>
                <select id="id_gudep" name="id_gudep" required>
                    <option value="">Pilih Gudep</option>
                    <?php while ($gudep = $gudepStmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $gudep['id_gudep']; ?>" 
                            <?php echo ($isEdit && $pendamping['id_gudep'] == $gudep['id_gudep']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($gudep['nomor_gudep']); ?> - <?php echo htmlspecialchars($gudep['nama_gudep']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan *</label>
                <select id="jabatan" name="jabatan" required>
                    <option value="">Pilih Jabatan</option>
                    <option value="pembina" <?php echo ($isEdit && $pendamping['jabatan'] == 'pembina') ? 'selected' : ''; ?>>Pembina</option>
                    <option value="pembina_pembantu" <?php echo ($isEdit && $pendamping['jabatan'] == 'pembina_pembantu') ? 'selected' : ''; ?>>Pembina Pembantu</option>
                    <option value="pelatih" <?php echo ($isEdit && $pendamping['jabatan'] == 'pelatih') ? 'selected' : ''; ?>>Pelatih</option>
                </select>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="3" placeholder="Keterangan tambahan"><?php echo $isEdit ? $pendamping['keterangan'] : ''; ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $isEdit ? 'Update' : 'Simpan'; ?>
                </button>
                <a href="index.php?action=list&page=pendamping" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
