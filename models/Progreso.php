<?php
require_once 'config/Database.php';

class Progreso {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getByStudentId($estudiante_id) {
        $stmt = $this->db->prepare("SELECT * FROM Progreso WHERE estudiante_id = ?");
        $stmt->execute([$estudiante_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateProgress($estudiante_id, $data) {
        $stmt = $this->db->prepare("
            INSERT INTO Progreso (estudiante_id, ejercicios_completados, ejercicios_correctos, porcentaje, puntos_acumulados, racha_dias, nivel_actual) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            ejercicios_completados = VALUES(ejercicios_completados),
            ejercicios_correctos = VALUES(ejercicios_correctos),
            porcentaje = VALUES(porcentaje),
            puntos_acumulados = VALUES(puntos_acumulados),
            racha_dias = VALUES(racha_dias),
            nivel_actual = VALUES(nivel_actual),
            ultima_actividad = CURRENT_TIMESTAMP
        ");
        return $stmt->execute([
            $estudiante_id,
            $data['ejercicios_completados'],
            $data['ejercicios_correctos'],
            $data['porcentaje'],
            $data['puntos_acumulados'],
            $data['racha_dias'],
            $data['nivel_actual']
        ]);
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT p.*, u.nombre, e.grado FROM Progreso p JOIN Estudiante e ON p.estudiante_id = e.id JOIN Usuario u ON e.usuario_id = u.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByFilters($nivel = null, $grado = null, $min_progreso = null) {
        $sql = "SELECT p.*, u.nombre, e.grado FROM Progreso p JOIN Estudiante e ON p.estudiante_id = e.id JOIN Usuario u ON e.usuario_id = u.id WHERE 1=1";
        $params = [];
        
        if ($nivel) {
            $sql .= " AND p.nivel_actual = ?";
            $params[] = $nivel;
        }
        if ($grado) {
            $sql .= " AND e.grado = ?";
            $params[] = $grado;
        }
        if ($min_progreso) {
            $sql .= " AND p.porcentaje >= ?";
            $params[] = $min_progreso;
        }
        
        $sql .= " ORDER BY u.nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>