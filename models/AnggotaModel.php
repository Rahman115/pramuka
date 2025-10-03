<?php
class AnggotaModel {
    private $conn;
    private $table_name = "anggota";

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
                  (nama, jenis_kelamin, tanggal_lahir, kontak, kategori) 
                  VALUES (:nama, :jenis_kelamin, :tanggal_lahir, :kontak, :kategori)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nama", $data['nama']);
        $stmt->bindParam(":jenis_kelamin", $data['jenis_kelamin']);
        $stmt->bindParam(":tanggal_lahir", $data['tanggal_lahir']);
        $stmt->bindParam(":kontak", $data['kontak']);
        $stmt->bindParam(":kategori", $data['kategori']);
        
        return $stmt->execute();
    }

    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_anggota = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                  SET nama = :nama, jenis_kelamin = :jenis_kelamin, 
                      tanggal_lahir = :tanggal_lahir, kontak = :kontak, 
                      kategori = :kategori 
                  WHERE id_anggota = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nama", $data['nama']);
        $stmt->bindParam(":jenis_kelamin", $data['jenis_kelamin']);
        $stmt->bindParam(":tanggal_lahir", $data['tanggal_lahir']);
        $stmt->bindParam(":kontak", $data['kontak']);
        $stmt->bindParam(":kategori", $data['kategori']);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_anggota = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }
}
?>
