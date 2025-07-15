<?php
require_once 'config/Database.php';

class EstudiantesAsignados {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function assignPlan($estudiante_id, $plan_id) {
        // Verificar si ya está asignado
        $stmt = $this->db->prepare("SELECT id FROM Estudiantes_asignados WHERE estudiante_id = ? AND plan_estudios_id = ?");
        $stmt->execute([$estudiante_id, $plan_id]);
        
        if (!$stmt->fetch()) {
            $stmt = $this->db->prepare("
                INSERT INTO Estudiantes_asignados (estudiante_id, plan_estudios_id, fecha_inicio, fecha_fin_estimada, fecha_asignacion) 
                VALUES (?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL (SELECT duracion_semanas FROM Plan_de_estudios WHERE id = ?) WEEK), NOW())
            ");
            return $stmt->execute([$estudiante_id, $plan_id, $plan_id]);
        }
        return false;
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT ea.*, u.nombre as estudiante_nombre, pe.titulo as plan_titulo, pe.nivel 
            FROM Estudiantes_asignados ea 
            JOIN Estudiante e ON ea.estudiante_id = e.id 
            JOIN Usuario u ON e.usuario_id = u.id 
            JOIN Plan_de_estudios pe ON ea.plan_estudios_id = pe.id 
            ORDER BY ea.fecha_asignacion DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByStudentId($estudiante_id) {
        $stmt = $this->db->prepare("
            SELECT ea.*, pe.titulo, pe.descripcion, pe.nivel 
            FROM Estudiantes_asignados ea 
            JOIN Plan_de_estudios pe ON ea.plan_estudios_id = pe.id 
            WHERE ea.estudiante_id = ?
        ");
        $stmt->execute([$estudiante_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>