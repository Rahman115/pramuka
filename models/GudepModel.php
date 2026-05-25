<?php
class GudepModel {
    private $conn;
    private $table_name = "gudep";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nomor_gudep, nama_gudep, pangkalan, kecamatan, tingkatan, 
                   npsn, kepala_sekolah, status_kepemilikan, 
                   sk_pendirian_sekolah, tanggal_sk_pendirian, 
                   sk_izin_operasional, tanggal_sk_izin_operasional, 
                   alamat, keterangan) 
                  VALUES 
                  (:nomor_gudep, :nama_gudep, :pangkalan, :kecamatan, :tingkatan,
                   :npsn, :kepala_sekolah, :status_kepemilikan,
                   :sk_pendirian_sekolah, :tanggal_sk_pendirian,
                   :sk_izin_operasional, :tanggal_sk_izin_operasional,
                   :alamat, :keterangan)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nomor_gudep", $data['nomor_gudep']);
        $stmt->bindParam(":nama_gudep", $data['nama_gudep']);
        $stmt->bindParam(":pangkalan", $data['pangkalan']);
        $stmt->bindParam(":kecamatan", $data['kecamatan']);
        $stmt->bindParam(":tingkatan", $data['tingkatan']);
        $stmt->bindParam(":npsn", $data['npsn']);
        $stmt->bindParam(":kepala_sekolah", $data['kepala_sekolah']);
        $stmt->bindParam(":status_kepemilikan", $data['status_kepemilikan']);
        $stmt->bindParam(":sk_pendirian_sekolah", $data['sk_pendirian_sekolah']);
        $stmt->bindParam(":tanggal_sk_pendirian", $data['tanggal_sk_pendirian']);
        $stmt->bindParam(":sk_izin_operasional", $data['sk_izin_operasional']);
        $stmt->bindParam(":tanggal_sk_izin_operasional", $data['tanggal_sk_izin_operasional']);
        $stmt->bindParam(":alamat", $data['alamat']);
        $stmt->bindParam(":keterangan", $data['keterangan']);
        
        return $stmt->execute();
    }

    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_gudep = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                  SET nomor_gudep = :nomor_gudep, 
                      nama_gudep = :nama_gudep, 
                      pangkalan = :pangkalan,
                      kecamatan = :kecamatan,
                      tingkatan = :tingkatan,
                      npsn = :npsn,
                      kepala_sekolah = :kepala_sekolah,
                      status_kepemilikan = :status_kepemilikan,
                      sk_pendirian_sekolah = :sk_pendirian_sekolah,
                      tanggal_sk_pendirian = :tanggal_sk_pendirian,
                      sk_izin_operasional = :sk_izin_operasional,
                      tanggal_sk_izin_operasional = :tanggal_sk_izin_operasional,
                      alamat = :alamat, 
                      keterangan = :keterangan
                  WHERE id_gudep = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nomor_gudep", $data['nomor_gudep']);
        $stmt->bindParam(":nama_gudep", $data['nama_gudep']);
        $stmt->bindParam(":pangkalan", $data['pangkalan']);
        $stmt->bindParam(":kecamatan", $data['kecamatan']);
        $stmt->bindParam(":tingkatan", $data['tingkatan']);
        $stmt->bindParam(":npsn", $data['npsn']);
        $stmt->bindParam(":kepala_sekolah", $data['kepala_sekolah']);
        $stmt->bindParam(":status_kepemilikan", $data['status_kepemilikan']);
        $stmt->bindParam(":sk_pendirian_sekolah", $data['sk_pendirian_sekolah']);
        $stmt->bindParam(":tanggal_sk_pendirian", $data['tanggal_sk_pendirian']);
        $stmt->bindParam(":sk_izin_operasional", $data['sk_izin_operasional']);
        $stmt->bindParam(":tanggal_sk_izin_operasional", $data['tanggal_sk_izin_operasional']);
        $stmt->bindParam(":alamat", $data['alamat']);
        $stmt->bindParam(":keterangan", $data['keterangan']);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_gudep = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function getByNomor($nomor_gudep) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nomor_gudep = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nomor_gudep);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>