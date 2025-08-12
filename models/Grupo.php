<?php
require_once 'config/Database.php';

class Grupo {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll($page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("
            SELECT g.*, u.nombre as profesor_nombre,
                   COUNT(ge.estudiante_id) as total_estudiantes
            FROM Grupo g 
            LEFT JOIN Profesor p ON g.profesor_id = p.id
            LEFT JOIN Usuario u ON p.usuario_id = u.id
            LEFT JOIN Grupo_Estudiantes ge ON g.id = ge.grupo_id
            WHERE g.activo = 1
            GROUP BY g.id
            ORDER BY g.fecha_creacion DESC
            LIMIT $limit OFFSET $offset
        ");
        $stmt->execute([]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllSimple() {
        $stmt = $this->db->prepare("SELECT id, nombre, nivel FROM Grupo WHERE activo = 1 ORDER BY nombre");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Grupo WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO Grupo (nombre, descripcion, nivel, profesor_id) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['nivel'],
            $data['profesor_id']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE Grupo 
            SET nombre = ?, descripcion = ?, nivel = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['nivel'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("UPDATE Grupo SET activo = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Grupo WHERE activo = 1");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    public function addStudent($grupo_id, $estudiante_id) {
        $stmt = $this->db->prepare("
            INSERT IGNORE INTO Grupo_Estudiantes (grupo_id, estudiante_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$grupo_id, $estudiante_id]);
    }
    
    public function removeStudent($grupo_id, $estudiante_id) {
        $stmt = $this->db->prepare("
            DELETE FROM Grupo_Estudiantes 
            WHERE grupo_id = ? AND estudiante_id = ?
        ");
        return $stmt->execute([$grupo_id, $estudiante_id]);
    }
    
    public function getStudents($grupo_id) {
        $stmt = $this->db->prepare("
            SELECT e.id, u.nombre, e.nivel_actual
            FROM Grupo_Estudiantes ge
            JOIN Estudiante e ON ge.estudiante_id = e.id
            JOIN Usuario u ON e.usuario_id = u.id
            WHERE ge.grupo_id = ?
        ");
        $stmt->execute([$grupo_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>