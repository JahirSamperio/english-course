<?php
require_once 'config/Database.php';

class PlanEstudios {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("SELECT * FROM Plan_de_estudios ORDER BY nivel, titulo LIMIT $limit OFFSET $offset");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM Plan_de_estudios");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    public function getAllSimple() {
        $stmt = $this->db->query("SELECT * FROM Plan_de_estudios ORDER BY nivel, titulo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Plan_de_estudios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO Plan_de_estudios (titulo, descripcion, nivel, duracion_semanas, unidades) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['titulo'],
            $data['descripcion'],
            $data['nivel'],
            $data['duracion_semanas'],
            $data['unidades'] ?? ''
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE Plan_de_estudios SET titulo = ?, descripcion = ?, nivel = ?, duracion_semanas = ? WHERE id = ?");
        return $stmt->execute([
            $data['titulo'],
            $data['descripcion'],
            $data['nivel'],
            $data['duracion_semanas'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Plan_de_estudios WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getAssignedToStudent($estudiante_id) {
        $stmt = $this->db->prepare("
            SELECT pe.*, ea.fecha_inicio, ea.fecha_fin_estimada 
            FROM Plan_de_estudios pe 
            JOIN Estudiantes_asignados ea ON pe.id = ea.plan_estudios_id 
            WHERE ea.estudiante_id = ?
        ");
        $stmt->execute([$estudiante_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>