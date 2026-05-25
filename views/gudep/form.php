<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$isEdit = ($id > 0);
$gudep = $isEdit ? $gudepModel->readOne($id) : null;

if($_POST) {
    $data = [
        'nomor_gudep' => $_POST['nomor_gudep'],
        'nama_gudep' => $_POST['nama_gudep'],
        'pangkalan' => $_POST['pangkalan'],
        'kecamatan' => $_POST['kecamatan'],
        'tingkatan' => $_POST['tingkatan'],
        'npsn' => $_POST['npsn'],
        'kepala_sekolah' => $_POST['kepala_sekolah'],
        'status_kepemilikan' => $_POST['status_kepemilikan'],
        'sk_pendirian_sekolah' => $_POST['sk_pendirian_sekolah'],
        'tanggal_sk_pendirian' => $_POST['tanggal_sk_pendirian'],
        'sk_izin_operasional' => $_POST['sk_izin_operasional'],
        'tanggal_sk_izin_operasional' => $_POST['tanggal_sk_izin_operasional'],
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
            <!-- Section 1: Informasi Dasar Gudep -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-flag-checkered"></i>
                    <h3>Informasi Dasar Gudep</h3>
                </div>
                <hr>

                <div class="form-group">
                    <label for="nomor_gudep">Nomor Gudep *</label>
                    <input type="text" id="nomor_gudep" name="nomor_gudep" class="form-control"
                           value="<?php echo $isEdit ? htmlspecialchars($gudep['nomor_gudep']) : ''; ?>" 
                           required placeholder="Contoh: 01.001-01.002">
                </div>

                <div class="form-group">
                    <label for="nama_gudep">Nama Gudep *</label>
                    <input type="text" id="nama_gudep" name="nama_gudep" class="form-control"
                           value="<?php echo $isEdit ? htmlspecialchars($gudep['nama_gudep']) : ''; ?>" 
                           required placeholder="Nama lengkap gugus depan">
                </div>

                <div class="form-group">
                    <label for="pangkalan">Pangkalan *</label>
                    <input type="text" id="pangkalan" name="pangkalan" class="form-control"
                           value="<?php echo $isEdit ? htmlspecialchars($gudep['pangkalan']) : ''; ?>" 
                           required placeholder="Nama sekolah/kampus/desa">
                </div>

                <div class="form-group">
                    <label for="kecamatan">Kecamatan</label>
                    <input type="text" id="kecamatan" name="kecamatan" class="form-control"
                           value="<?php echo $isEdit ? htmlspecialchars($gudep['kecamatan']) : ''; ?>" 
                           placeholder="Nama kecamatan">
                </div>

                <div class="form-group">
                    <label for="tingkatan">Tingkatan *</label>
                    <select id="tingkatan" name="tingkatan" class="form-control" required>
                        <option value="">Pilih Tingkatan</option>
                        <option value="SD" <?php echo ($isEdit && $gudep['tingkatan'] == 'SD') ? 'selected' : ''; ?>>SD</option>
                        <option value="SMP" <?php echo ($isEdit && $gudep['tingkatan'] == 'SMP') ? 'selected' : ''; ?>>SMP</option>
                        <option value="SMA/SMK" <?php echo ($isEdit && $gudep['tingkatan'] == 'SMA/SMK') ? 'selected' : ''; ?>>SMA/SMK</option>
                    </select>
                </div>
            </div>

            <!-- Section 2: Informasi Sekolah -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-school"></i>
                    <h3>Informasi Sekolah</h3>
                </div>
                <hr>

                <div class="form-group">
                    <label for="npsn">NPSN</label>
                    <input type="text" id="npsn" name="npsn" class="form-control"
                           value="<?php echo $isEdit ? htmlspecialchars($gudep['npsn']) : ''; ?>" 
                           placeholder="Nomor Pokok Sekolah Nasional" maxlength="20">
                    <small class="form-text">Nomor unik sekolah dari Kemdikbud</small>
                </div>

                <div class="form-group">
                    <label for="kepala_sekolah">Kepala Sekolah</label>
                    <input type="text" id="kepala_sekolah" name="kepala_sekolah" class="form-control"
                           value="<?php echo $isEdit ? htmlspecialchars($gudep['kepala_sekolah']) : ''; ?>" 
                           placeholder="Nama kepala sekolah">
                </div>

                <div class="form-group">
                    <label for="status_kepemilikan">Status Kepemilikan</label>
                    <select id="status_kepemilikan" name="status_kepemilikan" class="form-control">
                        <option value="">Pilih Status Kepemilikan</option>
                        <option value="Negeri" <?php echo ($isEdit && $gudep['status_kepemilikan'] == 'Negeri') ? 'selected' : ''; ?>>Negeri</option>
                        <option value="Swasta" <?php echo ($isEdit && $gudep['status_kepemilikan'] == 'Swasta') ? 'selected' : ''; ?>>Swasta</option>
                    </select>
                </div>
            </div>

            <!-- Section 3: Dokumen Perizinan -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-file-alt"></i>
                    <h3>Dokumen Perizinan Sekolah</h3>
                </div>
                <hr>

                <div class="form-row">
                    <div class="form-group">
                        <label for="sk_pendirian_sekolah">SK Pendirian Sekolah</label>
                        <input type="text" id="sk_pendirian_sekolah" name="sk_pendirian_sekolah" class="form-control"
                               value="<?php echo $isEdit ? htmlspecialchars($gudep['sk_pendirian_sekolah']) : ''; ?>" 
                               placeholder="Nomor SK Pendirian">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_sk_pendirian">Tanggal SK Pendirian</label>
                        <input type="date" id="tanggal_sk_pendirian" name="tanggal_sk_pendirian" class="form-control"
                               value="<?php echo $isEdit ? $gudep['tanggal_sk_pendirian'] : ''; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="sk_izin_operasional">SK Izin Operasional</label>
                        <input type="text" id="sk_izin_operasional" name="sk_izin_operasional" class="form-control"
                               value="<?php echo $isEdit ? htmlspecialchars($gudep['sk_izin_operasional']) : ''; ?>" 
                               placeholder="Nomor SK Izin Operasional">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_sk_izin_operasional">Tanggal SK Izin Operasional</label>
                        <input type="date" id="tanggal_sk_izin_operasional" name="tanggal_sk_izin_operasional" class="form-control"
                               value="<?php echo $isEdit ? $gudep['tanggal_sk_izin_operasional'] : ''; ?>">
                    </div>
                </div>
            </div>

            <!-- Section 4: Informasi Lainnya -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-info-circle"></i>
                    <h3>Informasi Lainnya</h3>
                </div>
                <hr>

                <div class="form-group">
                    <label for="alamat">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" class="form-control" rows="3" 
                              placeholder="Alamat lengkap pangkalan"><?php echo $isEdit ? htmlspecialchars($gudep['alamat']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" class="form-control" rows="3" 
                              placeholder="Keterangan tambahan (opsional)"><?php echo $isEdit ? htmlspecialchars($gudep['keterangan']) : ''; ?></textarea>
                </div>
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