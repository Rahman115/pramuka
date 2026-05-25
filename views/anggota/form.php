<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$isEdit = ($id > 0);
$anggota = $isEdit ? $anggotaModel->readOne($id) : null;

// Data kecamatan dan kelurahan
$kecamatanList = [
    'Kulisusu' => ['Lipu', 'Wandaka', "Sara'ea"],
    'Kulisusu Utara' => ['Wa Ode Buri', 'Wamboule', 'Lelamo'],
    'Kulisusu Barat' => ['Langkumbe', 'Lambale', 'Laeya'],
    'Bonegunu' => ['Bonegunu', 'Rumbia', 'Lambelu'],
    'Kambowa' => ['Kambowa', 'Lagundi', 'Banggula'],
    'Wakorumba Utara' => ['Labaraga', 'Labuan', 'Labelete']
];

if($_POST) {
    $data = [
        'kta' => $_POST['kta'],
        'nama_lengkap' => $_POST['nama_lengkap'],
        'status_anggota' => $_POST['status_anggota'],
        'tempat_lahir' => $_POST['tempat_lahir'],
        'tanggal_lahir' => $_POST['tanggal_lahir'],
        'kecamatan' => $_POST['kecamatan'],
        'kelurahan' => $_POST['kelurahan'],
        'alamat_lengkap' => $_POST['alamat_lengkap'],
        'golongan_darah' => $_POST['golongan_darah'],
        'email' => $_POST['email'],
        'nomor_telp' => $_POST['nomor_telp'],
        'golongan_pramuka' => $_POST['golongan_pramuka']
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
    <h2><i class="fas fa-user"></i> <?php echo $isEdit ? 'Edit Anggota' : 'Tambah Anggota Baru'; ?></h2>
    <div class="header-actions">
        <a href="index.php?action=list&page=anggota" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-edit"></i> Form Data Anggota Pramuka</h3>
    </div>
    <div class="card-body">
        <form method="POST" class="form" id="anggotaForm">
            <!-- Informasi Dasar -->
            <div class="form-section">
                <h4 class="section-title"><i class="fas fa-id-card"></i> Informasi Dasar</h4>
                <hr>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="kta">Nomor KTA *</label>
                        <input type="text" id="kta" name="kta" class="form-control" 
                               value="<?php echo $isEdit ? $anggota['kta'] : ''; ?>" 
                               placeholder="Masukkan Nomor KTA" required>
                        <small class="form-text text-muted">Nomor Kartu Tanda Anggota</small>
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap *</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" 
                               value="<?php echo $isEdit ? $anggota['nama_lengkap'] : ''; ?>" 
                               placeholder="Masukkan Nama Lengkap" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="status_anggota">Status Anggota *</label>
                        <select id="status_anggota" name="status_anggota" class="form-control" required>
                            <option value="">Pilih Status Anggota</option>
                            <option value="muda" <?php echo ($isEdit && $anggota['status_anggota'] == 'muda') ? 'selected' : ''; ?>>Anggota Muda</option>
                            <option value="dewasa" <?php echo ($isEdit && $anggota['status_anggota'] == 'dewasa') ? 'selected' : ''; ?>>Anggota Dewasa</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="golongan_pramuka">Golongan Pramuka *</label>
                        <select id="golongan_pramuka" name="golongan_pramuka" class="form-control" required>
                            <option value="">Pilih Golongan Pramuka</option>
                            <option value="siaga" class="muda-option" <?php echo ($isEdit && $anggota['golongan_pramuka'] == 'siaga') ? 'selected' : ''; ?>>Siaga</option>
                            <option value="penggalang" class="muda-option" <?php echo ($isEdit && $anggota['golongan_pramuka'] == 'penggalang') ? 'selected' : ''; ?>>Penggalang</option>
                            <option value="penegak" class="muda-option" <?php echo ($isEdit && $anggota['golongan_pramuka'] == 'penegak') ? 'selected' : ''; ?>>Penegak</option>
                            <option value="pandega" class="muda-option" <?php echo ($isEdit && $anggota['golongan_pramuka'] == 'pandega') ? 'selected' : ''; ?>>Pandega</option>
                            <option value="Andalan" class="dewasa-option" <?php echo ($isEdit && $anggota['golongan_pramuka'] == 'Andalan') ? 'selected' : ''; ?>>Andalan</option>
                            <option value="Pembina" class="dewasa-option" <?php echo ($isEdit && $anggota['golongan_pramuka'] == 'Pembina') ? 'selected' : ''; ?>>Pembina</option>
                            <option value="Mabigus" class="dewasa-option" <?php echo ($isEdit && $anggota['golongan_pramuka'] == 'Mabigus') ? 'selected' : ''; ?>>Mabigus</option>
                            <option value="Mabicab" class="dewasa-option" <?php echo ($isEdit && $anggota['golongan_pramuka'] == 'Mabicab') ? 'selected' : ''; ?>>Mabicab</option>
                            <option value="Instruktur" class="dewasa-option" <?php echo ($isEdit && $anggota['golongan_pramuka'] == 'Instruktur') ? 'selected' : ''; ?>>Instruktur</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tempat dan Tanggal Lahir -->
            <div class="form-section">
                <h4 class="section-title"><i class="fas fa-calendar-alt"></i> Tempat dan Tanggal Lahir</h4>
                <hr>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" 
                               value="<?php echo $isEdit ? $anggota['tempat_lahir'] : ''; ?>" 
                               placeholder="Contoh: Jakarta, Surabaya">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" 
                               value="<?php echo $isEdit ? $anggota['tanggal_lahir'] : ''; ?>">
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="form-section">
                <h4 class="section-title"><i class="fas fa-map-marker-alt"></i> Alamat</h4>
                <hr>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan *</label>
                        <select id="kecamatan" name="kecamatan" class="form-control" required>
                            <option value="">Pilih Kecamatan</option>
                            <?php foreach($kecamatanList as $kec => $kelList): ?>
                                <option value="<?php echo $kec; ?>" 
                                    <?php echo ($isEdit && $anggota['kecamatan'] == $kec) ? 'selected' : ''; ?>>
                                    <?php echo $kec; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kelurahan">Kelurahan/Desa *</label>
                        <select id="kelurahan" name="kelurahan" class="form-control" required>
                            <option value="">Pilih Kelurahan</option>
                            <?php if($isEdit && $anggota['kelurahan']): ?>
                                <option value="<?php echo $anggota['kelurahan']; ?>" selected>
                                    <?php echo $anggota['kelurahan']; ?>
                                </option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat_lengkap">Alamat Lengkap</label>
                    <textarea id="alamat_lengkap" name="alamat_lengkap" class="form-control" 
                              rows="3" placeholder="Masukkan alamat lengkap (RT/RW, Nama Jalan, dll)"><?php echo $isEdit ? $anggota['alamat_lengkap'] : ''; ?></textarea>
                </div>
            </div>

            <!-- Informasi Kontak -->
            <div class="form-section">
                <h4 class="section-title"><i class="fas fa-address-card"></i> Informasi Kontak & Lainnya</h4>
                <hr>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="golongan_darah">Golongan Darah</label>
                        <select id="golongan_darah" name="golongan_darah" class="form-control">
                            <option value="">Pilih Golongan Darah</option>
                            <option value="A" <?php echo ($isEdit && $anggota['golongan_darah'] == 'A') ? 'selected' : ''; ?>>A</option>
                            <option value="B" <?php echo ($isEdit && $anggota['golongan_darah'] == 'B') ? 'selected' : ''; ?>>B</option>
                            <option value="AB" <?php echo ($isEdit && $anggota['golongan_darah'] == 'AB') ? 'selected' : ''; ?>>AB</option>
                            <option value="O" <?php echo ($isEdit && $anggota['golongan_darah'] == 'O') ? 'selected' : ''; ?>>O</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="<?php echo $isEdit ? $anggota['email'] : ''; ?>" 
                               placeholder="contoh@email.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nomor_telp">Nomor Telepon</label>
                    <input type="tel" id="nomor_telp" name="nomor_telp" class="form-control" 
                           value="<?php echo $isEdit ? $anggota['nomor_telp'] : ''; ?>" 
                           placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $isEdit ? 'Update Data' : 'Simpan Data'; ?>
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Reset
                </button>
                <a href="index.php?action=list&page=anggota" class="btn btn-danger">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.form-section {
    margin-bottom: 2rem;
}

.section-title {
    color: var(--primary);
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-section hr {
    margin-bottom: 1.5rem;
    border: 0;
    border-top: 2px solid var(--border);
}

.form-text {
    font-size: 0.75rem;
    color: var(--text-light);
    margin-top: 0.25rem;
}
</style>

<script>
// Dependent dropdown untuk kecamatan dan kelurahan
const kelurahanData = {
    'Kulisusu': ['Lipu', 'Wandaka', "Sara'ea"],
    'Kulisusu Utara': ['Wa Ode Buri', 'Wamboule', 'Lelamo'],
    'Kulisusu Barat': ['Langkumbe', 'Lambale', 'Laeya'],
    'Bonegunu': ['Bonegunu', 'Rumbia', 'Lambelu'],
    'Kambowa': ['Kambowa', 'Lagundi', 'Banggula'],
    'Wakorumba Utara': ['Labaraga', 'Labuan', 'Labelete']
};

// Filter golongan pramuka berdasarkan status anggota
function filterGolonganPramuka() {
    const status = document.getElementById('status_anggota').value;
    const golonganSelect = document.getElementById('golongan_pramuka');
    const options = golonganSelect.options;
    
    for(let i = 0; i < options.length; i++) {
        const option = options[i];
        if(option.value === '') continue;
        
        if(status === 'muda') {
            if(option.classList.contains('muda-option')) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        } else if(status === 'dewasa') {
            if(option.classList.contains('dewasa-option')) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        } else {
            option.style.display = '';
        }
    }
    
    // Reset pilihan jika yang dipilih tidak sesuai
    if(golonganSelect.options[golonganSelect.selectedIndex] && 
       golonganSelect.options[golonganSelect.selectedIndex].style.display === 'none') {
        golonganSelect.value = '';
    }
}

// Update dropdown kelurahan berdasarkan kecamatan yang dipilih
function updateKelurahan() {
    const kecamatan = document.getElementById('kecamatan').value;
    const kelurahanSelect = document.getElementById('kelurahan');
    
    // Clear existing options
    kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
    
    if(kecamatan && kelurahanData[kecamatan]) {
        const kelurahans = kelurahanData[kecamatan];
        for(let i = 0; i < kelurahans.length; i++) {
            const option = document.createElement('option');
            option.value = kelurahans[i];
            option.textContent = kelurahans[i];
            kelurahanSelect.appendChild(option);
        }
    }
    
    // Jika edit mode dan ada nilai kelurahan sebelumnya
    <?php if($isEdit && $anggota['kelurahan']): ?>
    const oldKelurahan = "<?php echo $anggota['kelurahan']; ?>";
    for(let i = 0; i < kelurahanSelect.options.length; i++) {
        if(kelurahanSelect.options[i].value === oldKelurahan) {
            kelurahanSelect.selectedIndex = i;
            break;
        }
    }
    <?php endif; ?>
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status_anggota');
    const kecamatanSelect = document.getElementById('kecamatan');
    
    if(statusSelect) {
        statusSelect.addEventListener('change', filterGolonganPramuka);
        filterGolonganPramuka(); // Initial filter
    }
    
    if(kecamatanSelect) {
        kecamatanSelect.addEventListener('change', updateKelurahan);
        
        // If edit mode and kecamatan has value, trigger updateKelurahan
        <?php if($isEdit && $anggota['kecamatan']): ?>
        updateKelurahan();
        <?php endif; ?>
    }
});
</script>