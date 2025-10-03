<?php
class PendampingModel {
    private $conn;
    private $table_name = "pendamping";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT p.*, a.nama, a.jenis_kelamin, a.kontak, g.nama_gudep, g.nomor_gudep
                  FROM " . $this->table_name . " p
                  LEFT JOIN anggota a ON p.id_anggota = a.id_anggota 
                  LEFT JOIN gudep g ON p.id_gudep = g.id_gudep
                  ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_anggota, id_gudep, jabatan, keterangan) 
                  VALUES (:id_anggota, :id_gudep, :jabatan, :keterangan)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id_anggota", $data['id_anggota']);
        $stmt->bindParam(":id_gudep", $data['id_gudep']);
        $stmt->bindParam(":jabatan", $data['jabatan']);
        $stmt->bindParam(":keterangan", $data['keterangan']);
        
        return $stmt->execute();
    }

    public function readOne($id) {
        $query = "SELECT p.*, a.nama, a.jenis_kelamin, a.tanggal_lahir, a.kontak, 
                         g.nama_gudep, g.nomor_gudep, g.pangkalan
                  FROM " . $this->table_name . " p
                  LEFT JOIN anggota a ON p.id_anggota = a.id_anggota 
                  LEFT JOIN gudep g ON p.id_gudep = g.id_gudep
                  WHERE p.id_pendamping = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                  SET id_anggota = :id_anggota, id_gudep = :id_gudep, 
                      jabatan = :jabatan, keterangan = :keterangan
                  WHERE id_pendamping = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id_anggota", $data['id_anggota']);
        $stmt->bindParam(":id_gudep", $data['id_gudep']);
        $stmt->bindParam(":jabatan", $data['jabatan']);
        $stmt->bindParam(":keterangan", $data['keterangan']);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_pendamping = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function getByAnggota($id_anggota) {
        $query = "SELECT p.*, g.nama_gudep, g.nomor_gudep 
                  FROM " . $this->table_name . " p
                  LEFT JOIN gudep g ON p.id_gudep = g.id_gudep
                  WHERE p.id_anggota = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_anggota);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByGudep($id_gudep) {
        $query = "SELECT p.*, a.nama, a.jenis_kelamin, a.kontak 
                  FROM " . $this->table_name . " p
                  LEFT JOIN anggota a ON p.id_anggota = a.id_anggota
                  WHERE p.id_gudep = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_gudep);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
