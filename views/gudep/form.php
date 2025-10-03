<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$isEdit = ($id > 0);
$gudep = $isEdit ? $gudepModel->readOne($id) : null;

if($_POST) {
    $data = [
        'nomor_gudep' => $_POST['nomor_gudep'],
        'nama_gudep' => $_POST['nama_gudep'],
        'pangkalan' => $_POST['pangkalan'],
        'alamat' => $_POST['alamat'],
        'keterangan' => $_POST['keterangan']
    ];

    if($isEdit) {
        $result = $gudepModel->update($id, $data);
        $message = $result ? "Data gudep berhasil diperbarui" : "Gagal memperbarui data";
    } else {
        $result = $gudepModel->create($data);
        $message = $result ? "Gudep berhasil ditambahkan" : "Gagal menambahkan gudep";
    }

    if($result) {
        echo "<script>alert('$message'); window.location.href='index.php?action=list&page=gudep';</script>";
    } else {
        echo "<script>alert('$message');</script>";
    }
}
?>

<div class="page-header">
    <h2><?php echo $isEdit ? 'Edit Gudep' : 'Tambah Gudep Baru'; ?></h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" class="form">
            <div class="form-group">
                <label for="nomor_gudep">Nomor Gudep *</label>
                <input type="text" id="nomor_gudep" name="nomor_gudep" 
                       value="<?php echo $isEdit ? $gudep['nomor_gudep'] : ''; ?>" 
                       required placeholder="Contoh: 01.001-01.002">
            </div>

            <div class="form-group">
                <label for="nama_gudep">Nama Gudep *</label>
                <input type="text" id="nama_gudep" name="nama_gudep" 
                       value="<?php echo $isEdit ? $gudep['nama_gudep'] : ''; ?>" 
                       required placeholder="Nama lengkap gugus depan">
            </div>

            <div class="form-group">
                <label for="pangkalan">Pangkalan *</label>
                <input type="text" id="pangkalan" name="pangkalan" 
                       value="<?php echo $isEdit ? $gudep['pangkalan'] : ''; ?>" 
                       required placeholder="Nama sekolah/kampus/desa">
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" placeholder="Alamat lengkap pangkalan"><?php echo $isEdit ? $gudep['alamat'] : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="3" placeholder="Keterangan tambahan"><?php echo $isEdit ? $gudep['keterangan'] : ''; ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $isEdit ? 'Update' : 'Simpan'; ?>
                </button>
                <a href="index.php?action=list&page=gudep" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
