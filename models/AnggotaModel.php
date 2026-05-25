<?php
class AnggotaModel {
    private $conn;
    private $table_name = "anggota";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Read all anggota with optional sorting
    public function readAll($orderBy = "id DESC") {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY " . $orderBy;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create new anggota
    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (kta, nama_lengkap, status_anggota, tempat_lahir, tanggal_lahir, 
                   kecamatan, kelurahan, alamat_lengkap, golongan_darah, email, 
                   nomor_telp, golongan_pramuka) 
                  VALUES 
                  (:kta, :nama_lengkap, :status_anggota, :tempat_lahir, :tanggal_lahir,
                   :kecamatan, :kelurahan, :alamat_lengkap, :golongan_darah, :email,
                   :nomor_telp, :golongan_pramuka)";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind parameters
        $kta = htmlspecialchars(strip_tags($data['kta']));
        $nama_lengkap = htmlspecialchars(strip_tags($data['nama_lengkap']));
        $status_anggota = htmlspecialchars(strip_tags($data['status_anggota']));
        $tempat_lahir = htmlspecialchars(strip_tags($data['tempat_lahir']));
        $tanggal_lahir = $data['tanggal_lahir'];
        $kecamatan = htmlspecialchars(strip_tags($data['kecamatan']));
        $kelurahan = htmlspecialchars(strip_tags($data['kelurahan']));
        $alamat_lengkap = htmlspecialchars(strip_tags($data['alamat_lengkap']));
        $golongan_darah = !empty($data['golongan_darah']) ? htmlspecialchars(strip_tags($data['golongan_darah'])) : null;
        $email = !empty($data['email']) ? htmlspecialchars(strip_tags($data['email'])) : null;
        $nomor_telp = !empty($data['nomor_telp']) ? htmlspecialchars(strip_tags($data['nomor_telp'])) : null;
        $golongan_pramuka = htmlspecialchars(strip_tags($data['golongan_pramuka']));
        
        $stmt->bindParam(":kta", $kta);
        $stmt->bindParam(":nama_lengkap", $nama_lengkap);
        $stmt->bindParam(":status_anggota", $status_anggota);
        $stmt->bindParam(":tempat_lahir", $tempat_lahir);
        $stmt->bindParam(":tanggal_lahir", $tanggal_lahir);
        $stmt->bindParam(":kecamatan", $kecamatan);
        $stmt->bindParam(":kelurahan", $kelurahan);
        $stmt->bindParam(":alamat_lengkap", $alamat_lengkap);
        $stmt->bindParam(":golongan_darah", $golongan_darah);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":nomor_telp", $nomor_telp);
        $stmt->bindParam(":golongan_pramuka", $golongan_pramuka);
        
        return $stmt->execute();
    }

    // Read single anggota by ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // Read single anggota by KTA
    public function readByKTA($kta) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE kta = :kta LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":kta", $kta);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // Update anggota
    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                  SET kta = :kta, 
                      nama_lengkap = :nama_lengkap, 
                      status_anggota = :status_anggota,
                      tempat_lahir = :tempat_lahir,
                      tanggal_lahir = :tanggal_lahir,
                      kecamatan = :kecamatan,
                      kelurahan = :kelurahan,
                      alamat_lengkap = :alamat_lengkap,
                      golongan_darah = :golongan_darah,
                      email = :email,
                      nomor_telp = :nomor_telp,
                      golongan_pramuka = :golongan_pramuka
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind parameters
        $kta = htmlspecialchars(strip_tags($data['kta']));
        $nama_lengkap = htmlspecialchars(strip_tags($data['nama_lengkap']));
        $status_anggota = htmlspecialchars(strip_tags($data['status_anggota']));
        $tempat_lahir = htmlspecialchars(strip_tags($data['tempat_lahir']));
        $tanggal_lahir = $data['tanggal_lahir'];
        $kecamatan = htmlspecialchars(strip_tags($data['kecamatan']));
        $kelurahan = htmlspecialchars(strip_tags($data['kelurahan']));
        $alamat_lengkap = htmlspecialchars(strip_tags($data['alamat_lengkap']));
        $golongan_darah = !empty($data['golongan_darah']) ? htmlspecialchars(strip_tags($data['golongan_darah'])) : null;
        $email = !empty($data['email']) ? htmlspecialchars(strip_tags($data['email'])) : null;
        $nomor_telp = !empty($data['nomor_telp']) ? htmlspecialchars(strip_tags($data['nomor_telp'])) : null;
        $golongan_pramuka = htmlspecialchars(strip_tags($data['golongan_pramuka']));
        
        $stmt->bindParam(":kta", $kta);
        $stmt->bindParam(":nama_lengkap", $nama_lengkap);
        $stmt->bindParam(":status_anggota", $status_anggota);
        $stmt->bindParam(":tempat_lahir", $tempat_lahir);
        $stmt->bindParam(":tanggal_lahir", $tanggal_lahir);
        $stmt->bindParam(":kecamatan", $kecamatan);
        $stmt->bindParam(":kelurahan", $kelurahan);
        $stmt->bindParam(":alamat_lengkap", $alamat_lengkap);
        $stmt->bindParam(":golongan_darah", $golongan_darah);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":nomor_telp", $nomor_telp);
        $stmt->bindParam(":golongan_pramuka", $golongan_pramuka);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }

    // Delete anggota
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Get total count of anggota
    public function getTotalCount() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Get count by status anggota
    public function getCountByStatus($status) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE status_anggota = :status";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Get count by golongan pramuka
    public function getCountByGolongan($golongan) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE golongan_pramuka = :golongan";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":golongan", $golongan);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Get count by kecamatan
    public function getCountByKecamatan($kecamatan) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE kecamatan = :kecamatan";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":kecamatan", $kecamatan);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Search anggota by keyword (nama, kta, email)
    public function search($keyword) {
        $keyword = "%{$keyword}%";
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE nama_lengkap LIKE :keyword 
                     OR kta LIKE :keyword 
                     OR email LIKE :keyword 
                     OR nomor_telp LIKE :keyword
                  ORDER BY nama_lengkap ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        return $stmt;
    }

    // Filter anggota by status and golongan
    public function filter($status = null, $golongan = null, $kecamatan = null) {
        $conditions = [];
        $params = [];
        
        if (!empty($status)) {
            $conditions[] = "status_anggota = :status";
            $params[':status'] = $status;
        }
        
        if (!empty($golongan)) {
            $conditions[] = "golongan_pramuka = :golongan";
            $params[':golongan'] = $golongan;
        }
        
        if (!empty($kecamatan)) {
            $conditions[] = "kecamatan = :kecamatan";
            $params[':kecamatan'] = $kecamatan;
        }
        
        $query = "SELECT * FROM " . $this->table_name;
        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        $query .= " ORDER BY nama_lengkap ASC";
        
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt;
    }

    // Get recent anggota (for dashboard)
    public function getRecent($limit = 5) {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Check if KTA already exists
    public function isKTAExists($kta, $excludeId = null) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE kta = :kta";
        if ($excludeId) {
            $query .= " AND id != :id";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":kta", $kta);
        if ($excludeId) {
            $stmt->bindParam(":id", $excludeId);
        }
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    // Check if email already exists
    public function isEmailExists($email, $excludeId = null) {
        if (empty($email)) return false;
        
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE email = :email";
        if ($excludeId) {
            $query .= " AND id != :id";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        if ($excludeId) {
            $stmt->bindParam(":id", $excludeId);
        }
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    // Get anggota by kecamatan
    public function getByKecamatan($kecamatan) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE kecamatan = :kecamatan ORDER BY nama_lengkap ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":kecamatan", $kecamatan);
        $stmt->execute();
        return $stmt;
    }

    // Get anggota by golongan pramuka
    public function getByGolongan($golongan) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE golongan_pramuka = :golongan ORDER BY nama_lengkap ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":golongan", $golongan);
        $stmt->execute();
        return $stmt;
    }

    // Get statistics for dashboard
    public function getStatistics() {
        $stats = [];
        
        // Total anggota
        $stats['total'] = $this->getTotalCount();
        
        // By status
        $stats['muda'] = $this->getCountByStatus('muda');
        $stats['dewasa'] = $this->getCountByStatus('dewasa');
        
        // By golongan (muda)
        $stats['siaga'] = $this->getCountByGolongan('siaga');
        $stats['penggalang'] = $this->getCountByGolongan('penggalang');
        $stats['penegak'] = $this->getCountByGolongan('penegak');
        $stats['pandega'] = $this->getCountByGolongan('pandega');
        
        // By golongan (dewasa)
        $stats['andalan'] = $this->getCountByGolongan('Andalan');
        $stats['pembina'] = $this->getCountByGolongan('Pembina');
        $stats['mabigus'] = $this->getCountByGolongan('Mabigus');
        $stats['mabicab'] = $this->getCountByGolongan('Mabicab');
        $stats['instruktur'] = $this->getCountByGolongan('Instruktur');
        
        return $stats;
    }
}
?>