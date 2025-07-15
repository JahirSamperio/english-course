<?php
require_once 'config/Database.php';

class Estudiante {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getWithProgress($estudiante_id) {
        $stmt = $this->db->prepare("
            SELECT e.*, u.nombre, u.email, 
                   p.ejercicios_completados, p.ejercicios_correctos, p.porcentaje, 
                   p.nivel_actual, p.puntos_acumulados, p.racha_dias,
                   pe.titulo as plan_titulo, pe.nivel as plan_nivel
            FROM Estudiante e 
            JOIN Usuario u ON e.usuario_id = u.id 
            LEFT JOIN Progreso p ON e.id = p.estudiante_id 
            LEFT JOIN Estudiantes_asignados ea ON e.id = ea.estudiante_id
            LEFT JOIN Plan_de_estudios pe ON ea.plan_estudios_id = pe.id
            WHERE e.id = ?
            ORDER BY ea.fecha_asignacion DESC
            LIMIT 1
        ");
        $stmt->execute([$estudiante_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAssignedPlan($estudiante_id) {
        $stmt = $this->db->prepare("
            SELECT pe.*, ea.fecha_inicio, ea.fecha_fin_estimada
            FROM Estudiantes_asignados ea
            JOIN Plan_de_estudios pe ON ea.plan_estudios_id = pe.id
            WHERE ea.estudiante_id = ?
            ORDER BY ea.fecha_asignacion DESC
            LIMIT 1
        ");
        $stmt->execute([$estudiante_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT e.*, u.nombre, u.email, p.ejercicios_completados, p.porcentaje, p.nivel_actual, p.puntos_acumulados 
            FROM Estudiante e 
            JOIN Usuario u ON e.usuario_id = u.id 
            LEFT JOIN Progreso p ON e.id = p.estudiante_id 
            ORDER BY e.grado, u.nombre
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>