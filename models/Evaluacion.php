<?php
require_once 'config/Database.php';

class Evaluacion {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM Evaluacion");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    public function getRecent($limit = 10) {
        $stmt = $this->db->prepare("
            SELECT ev.*, u.nombre as estudiante_nombre 
            FROM Evaluacion ev 
            JOIN Estudiante e ON ev.estudiante_id = e.id 
            JOIN Usuario u ON e.usuario_id = u.id 
            ORDER BY ev.fecha DESC LIMIT $limit
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByParentId($padre_id) {
        $stmt = $this->db->prepare("
            SELECT ev.*, u.nombre as estudiante_nombre 
            FROM Evaluacion ev 
            JOIN Estudiante e ON ev.estudiante_id = e.id 
            JOIN Usuario u ON e.usuario_id = u.id
            JOIN Hijo h ON e.id = h.estudiante_id 
            WHERE h.padre_id = ? 
            ORDER BY ev.fecha DESC LIMIT 5
        ");
        $stmt->execute([$padre_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO Evaluacion (titulo, descripcion, fecha, tiempo_limite, puntos_total, estudiante_id, profesor_id) 
            VALUES (?, ?, CURDATE(), ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['titulo'],
            $data['descripcion'],
            $data['duracion'],
            $data['puntos_total'],
            $data['estudiante_id'] ?? null,
            $data['profesor_id'] ?? null
        ]);
    }
}
?>