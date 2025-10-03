<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$isEdit = ($id > 0);
$anggota = $isEdit ? $anggotaModel->readOne($id) : null;

if($_POST) {
    $data = [
        'nama' => $_POST['nama'],
        'jenis_kelamin' => $_POST['jenis_kelamin'],
        'tanggal_lahir' => $_POST['tanggal_lahir'],
        'kontak' => $_POST['kontak'],
        'kategori' => $_POST['kategori']
    ];

    if($isEdit) {
        $result = $anggotaModel->update($id, $data);
        $message = $result ? "Data anggota berhasil diperbarui" : "Gagal memperbarui data";
    } else {
        $result = $anggotaModel->create($data);
        $message = $result ? "Anggota berhasil ditambahkan" : "Gagal menambahkan anggota";
    }

    if($result) {
        echo "<script>alert('$message'); window.location.href='index.php?action=list&page=anggota';</script>";
    } else {
        echo "<script>alert('$message');</script>";
    }
}
?>

<div class="page-header">
    <h2><?php echo $isEdit ? 'Edit Anggota' : 'Tambah Anggota Baru'; ?></h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" class="form">
            <div class="form-group">
                <label for="nama">Nama Lengkap *</label>
                <input type="text" id="nama" name="nama" value="<?php echo $isEdit ? $anggota['nama'] : ''; ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin *</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" <?php echo ($isEdit && $anggota['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?php echo ($isEdit && $anggota['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $isEdit ? $anggota['tanggal_lahir'] : ''; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="kontak">Kontak</label>
                <input type="text" id="kontak" name="kontak" value="<?php echo $isEdit ? $anggota['kontak'] : ''; ?>" placeholder="Nomor HP atau Email">
            </div>

            <div class="form-group">
                <label for="kategori">Kategori *</label>
                <select id="kategori" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <option value="kwarcab" <?php echo ($isEdit && $anggota['kategori'] == 'kwarcab') ? 'selected' : ''; ?>>Kwarcab</option>
                    <option value="dkc" <?php echo ($isEdit && $anggota['kategori'] == 'dkc') ? 'selected' : ''; ?>>DKC</option>
                    <option value="pendamping" <?php echo ($isEdit && $anggota['kategori'] == 'pendamping') ? 'selected' : ''; ?>>Pendamping</option>
                    <option value="siaga" <?php echo ($isEdit && $anggota['kategori'] == 'siaga') ? 'selected' : ''; ?>>Siaga</option>
                    <option value="penggalang" <?php echo ($isEdit && $anggota['kategori'] == 'penggalang') ? 'selected' : ''; ?>>Penggalang</option>
                    <option value="penegak" <?php echo ($isEdit && $anggota['kategori'] == 'penegak') ? 'selected' : ''; ?>>Penegak</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $isEdit ? 'Update' : 'Simpan'; ?>
                </button>
                <a href="index.php?action=list&page=anggota" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
