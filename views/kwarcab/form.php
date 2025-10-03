<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$isEdit = ($id > 0);
$kwarcab = $isEdit ? $kwarcabModel->readOne($id) : null;

// Ambil data anggota untuk dropdown
$anggotaStmt = $anggotaModel->readAll();

if($_POST) {
    $data = [
        'id_anggota' => $_POST['id_anggota'],
        'jabatan' => $_POST['jabatan'],
        'periode' => $_POST['periode']
    ];

    if($isEdit) {
        $result = $kwarcabModel->update($id, $data);
        $message = $result ? "Data pengurus berhasil diperbarui" : "Gagal memperbarui data";
    } else {
        $result = $kwarcabModel->create($data);
        $message = $result ? "Pengurus berhasil ditambahkan" : "Gagal menambahkan pengurus";
    }

    if($result) {
        echo "<script>alert('$message'); window.location.href='index.php?action=list&page=kwarcab';</script>";
    } else {
        echo "<script>alert('$message');</script>";
    }
}
?>

<div class="page-header">
    <h2><?php echo $isEdit ? 'Edit Pengurus Kwarcab' : 'Tambah Pengurus Kwarcab'; ?></h2>
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
                            <?php echo ($isEdit && $kwarcab['id_anggota'] == $anggota['id_anggota']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($anggota['nama']); ?> - <?php echo ucfirst($anggota['kategori']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan *</label>
                <input type="text" id="jabatan" name="jabatan" 
                       value="<?php echo $isEdit ? $kwarcab['jabatan'] : ''; ?>" 
                       required placeholder="Contoh: Ketua, Sekretaris, Bendahara">
            </div>

            <div class="form-group">
                <label for="periode">Periode *</label>
                <input type="text" id="periode" name="periode" 
                       value="<?php echo $isEdit ? $kwarcab['periode'] : ''; ?>" 
                       required placeholder="Contoh: 2023-2028">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $isEdit ? 'Update' : 'Simpan'; ?>
                </button>
                <a href="index.php?action=list&page=kwarcab" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
