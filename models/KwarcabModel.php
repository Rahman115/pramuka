<?php
class KwarcabModel {
    private $conn;
    private $table_name = "kwarcab";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT k.*, a.nama, a.jenis_kelamin, a.kontak 
                  FROM " . $this->table_name . " k
                  LEFT JOIN anggota a ON k.id_anggota = a.id_anggota 
                  ORDER BY k.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_anggota, jabatan, periode) 
                  VALUES (:id_anggota, :jabatan, :periode)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id_anggota", $data['id_anggota']);
        $stmt->bindParam(":jabatan", $data['jabatan']);
        $stmt->bindParam(":periode", $data['periode']);
        
        return $stmt->execute();
    }

    public function readOne($id) {
        $query = "SELECT k.*, a.nama, a.jenis_kelamin, a.tanggal_lahir, a.kontak 
                  FROM " . $this->table_name . " k
                  LEFT JOIN anggota a ON k.id_anggota = a.id_anggota 
                  WHERE k.id_kwarcab = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                  SET id_anggota = :id_anggota, jabatan = :jabatan, periode = :periode
                  WHERE id_kwarcab = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id_anggota", $data['id_anggota']);
        $stmt->bindParam(":jabatan", $data['jabatan']);
        $stmt->bindParam(":periode", $data['periode']);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_kwarcab = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function getByAnggota($id_anggota) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_anggota = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_anggota);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
