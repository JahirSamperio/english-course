<?php
require_once 'config/Database.php';

class Hijo {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getByParentId($padre_id) {
        $stmt = $this->db->prepare("
            SELECT e.*, u.nombre, p.porcentaje, p.puntos_acumulados, p.racha_dias, p.nivel_actual, p.ejercicios_completados,
                   g.nombre as grupo_nombre, g.nivel as grupo_nivel
            FROM Hijo h
            JOIN Estudiante e ON h.estudiante_id = e.id
            JOIN Usuario u ON e.usuario_id = u.id 
            LEFT JOIN Progreso p ON e.id = p.estudiante_id 
            LEFT JOIN Grupo_Estudiantes ge ON e.id = ge.estudiante_id
            LEFT JOIN Grupo g ON ge.grupo_id = g.id AND g.activo = 1
            WHERE h.padre_id = ?
        ");
        $stmt->execute([$padre_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function create($padre_id, $estudiante_id) {
        $stmt = $this->db->prepare("INSERT INTO Hijo (padre_id, estudiante_id) VALUES (?, ?)");
        return $stmt->execute([$padre_id, $estudiante_id]);
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT h.*, u.nombre as estudiante_nombre, up.nombre as padre_nombre 
            FROM Hijo h 
            JOIN Estudiante e ON h.estudiante_id = e.id 
            JOIN Usuario u ON e.usuario_id = u.id
            JOIN Padre p ON h.padre_id = p.id
            JOIN Usuario up ON p.usuario_id = up.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>