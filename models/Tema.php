<?php
require_once 'config/Database.php';

class Tema {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("SELECT * FROM Tema ORDER BY nivel_requerido, nombre LIMIT $limit OFFSET $offset");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM Tema");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    public function getAllSimple() {
        $stmt = $this->db->query("SELECT * FROM Tema ORDER BY nivel_requerido, nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByLevel($nivel) {
        $stmt = $this->db->prepare("SELECT * FROM Tema WHERE nivel_requerido = ? ORDER BY nombre");
        $stmt->execute([$nivel]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAssignedToStudent($estudiante_id) {
        $stmt = $this->db->prepare("
            SELECT DISTINCT t.*
            FROM Tema t
            LEFT JOIN Estudiantes_asignados ea ON ea.estudiante_id = ?
            LEFT JOIN Plan_de_estudios pe ON ea.plan_estudios_id = pe.id
            WHERE pe.id IS NULL OR t.nivel_requerido <= pe.nivel
            ORDER BY t.nivel_requerido, t.nombre
        ");
        $stmt->execute([$estudiante_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO Tema (nombre, descripcion, nivel_requerido, contenidos, duracion_estimada) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['nivel_requerido'],
            $data['contenidos'],
            $data['duracion_estimada']
        ]);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Tema WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE Tema SET nombre = ?, descripcion = ?, nivel_requerido = ?, contenidos = ?, duracion_estimada = ? WHERE id = ?");
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['nivel_requerido'],
            $data['contenidos'],
            $data['duracion_estimada'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Tema WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getByFilters($nivel = null, $duracion_min = null, $duracion_max = null) {
        $sql = "SELECT * FROM Tema WHERE 1=1";
        $params = [];
        
        if ($nivel) {
            $sql .= " AND nivel_requerido = ?";
            $params[] = $nivel;
        }
        if ($duracion_min) {
            $sql .= " AND duracion_estimada >= ?";
            $params[] = $duracion_min;
        }
        if ($duracion_max) {
            $sql .= " AND duracion_estimada <= ?";
            $params[] = $duracion_max;
        }
        
        $sql .= " ORDER BY nivel_requerido, nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>