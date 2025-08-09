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
    
    public function getRecent($page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("
            SELECT ev.*, u.nombre as estudiante_nombre 
            FROM Evaluacion ev 
            JOIN Estudiante e ON ev.estudiante_id = e.id 
            JOIN Usuario u ON e.usuario_id = u.id 
            ORDER BY ev.fecha DESC LIMIT $limit OFFSET $offset
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM Evaluacion");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    public function getByParentId($padre_id, $page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("
            SELECT ev.*, u.nombre as estudiante_nombre 
            FROM Evaluacion ev 
            JOIN Estudiante e ON ev.estudiante_id = e.id 
            JOIN Usuario u ON e.usuario_id = u.id
            JOIN Hijo h ON e.id = h.estudiante_id 
            WHERE h.padre_id = ? 
            ORDER BY ev.fecha DESC LIMIT $limit OFFSET $offset
        ");
        $stmt->execute([$padre_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCountByParent($padre_id) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total 
            FROM Evaluacion ev 
            JOIN Estudiante e ON ev.estudiante_id = e.id 
            JOIN Hijo h ON e.id = h.estudiante_id 
            WHERE h.padre_id = ?
        ");
        $stmt->execute([$padre_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO Evaluacion (titulo, descripcion, fecha, tiempo_limite, puntos_total, estudiante_id, profesor_id, archivo_pdf) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['titulo'],
            $data['descripcion'],
            $data['fecha'] ?? date('Y-m-d'),
            $data['tiempo_limite'] ?? 60,
            $data['puntos_total'] ?? 100,
            $data['estudiante_id'] ?? null,
            $data['profesor_id'] ?? null,
            $data['archivo_pdf'] ?? null
        ]);
    }
}
?>