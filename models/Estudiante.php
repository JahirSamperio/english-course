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
    
    public function getAll($page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("
            SELECT e.*, u.nombre, u.email, p.ejercicios_completados, p.porcentaje, p.nivel_actual, p.puntos_acumulados,
                   g.nombre as grupo_nombre, g.nivel as grupo_nivel
            FROM Estudiante e 
            JOIN Usuario u ON e.usuario_id = u.id 
            LEFT JOIN Progreso p ON e.id = p.estudiante_id 
            LEFT JOIN Grupo_Estudiantes ge ON e.id = ge.estudiante_id
            LEFT JOIN Grupo g ON ge.grupo_id = g.id AND g.activo = 1
            ORDER BY u.nombre, e.grado
            LIMIT $limit OFFSET $offset
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM Estudiante");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    public function getAllSimple() {
        $stmt = $this->db->query("
            SELECT e.*, u.nombre, u.email, p.ejercicios_completados, p.porcentaje, p.nivel_actual, p.puntos_acumulados,
                   g.nombre as grupo_nombre, g.nivel as grupo_nivel
            FROM Estudiante e 
            JOIN Usuario u ON e.usuario_id = u.id 
            LEFT JOIN Progreso p ON e.id = p.estudiante_id 
            LEFT JOIN Grupo_Estudiantes ge ON e.id = ge.estudiante_id
            LEFT JOIN Grupo g ON ge.grupo_id = g.id AND g.activo = 1
            ORDER BY u.nombre, e.grado
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>