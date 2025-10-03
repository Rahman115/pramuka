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
                  (nomor_gudep, nama_gudep, pangkalan, alamat, keterangan) 
                  VALUES (:nomor_gudep, :nama_gudep, :pangkalan, :alamat, :keterangan)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nomor_gudep", $data['nomor_gudep']);
        $stmt->bindParam(":nama_gudep", $data['nama_gudep']);
        $stmt->bindParam(":pangkalan", $data['pangkalan']);
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
                  SET nomor_gudep = :nomor_gudep, nama_gudep = :nama_gudep, 
                      pangkalan = :pangkalan, alamat = :alamat, keterangan = :keterangan
                  WHERE id_gudep = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nomor_gudep", $data['nomor_gudep']);
        $stmt->bindParam(":nama_gudep", $data['nama_gudep']);
        $stmt->bindParam(":pangkalan", $data['pangkalan']);
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
