<?php
require_once 'config/Database.php';

class Ejercicio {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getByTemaAndLevel($tema_id, $nivel) {
        $stmt = $this->db->prepare("SELECT * FROM Ejercicio WHERE tema_id = ? AND nivel = ? ORDER BY titulo");
        $stmt->execute([$tema_id, $nivel]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAssignedToStudent($estudiante_id, $nivel = null, $tema_id = null) {
        $sql = "SELECT e.*, t.nombre as tema_nombre 
                FROM Ejercicio e
                LEFT JOIN Tema t ON e.tema_id = t.id
                LEFT JOIN Estudiantes_asignados ea ON ea.estudiante_id = ?
                LEFT JOIN Plan_de_estudios pe ON ea.plan_estudios_id = pe.id
                WHERE pe.id IS NULL OR e.nivel <= pe.nivel";
        
        $params = [$estudiante_id];
        
        if ($nivel) {
            $sql .= " AND e.nivel = ?";
            $params[] = $nivel;
        }
        
        if ($tema_id) {
            $sql .= " AND e.tema_id = ?";
            $params[] = $tema_id;
        }
        
        $sql .= " ORDER BY RAND() LIMIT 10";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Ejercicio WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getByLevel($nivel) {
        $stmt = $this->db->prepare("SELECT * FROM Ejercicio WHERE nivel = ? ORDER BY titulo");
        $stmt->execute([$nivel]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByLevels($niveles) {
        if (empty($niveles)) {
            return [];
        }
        $placeholders = str_repeat('?,', count($niveles) - 1) . '?';
        $stmt = $this->db->prepare("SELECT * FROM Ejercicio WHERE nivel IN ($placeholders) ORDER BY nivel, titulo");
        $stmt->execute($niveles);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByTopic($tema_id) {
        $stmt = $this->db->prepare("SELECT * FROM Ejercicio WHERE tema_id = ? ORDER BY nivel, titulo");
        $stmt->execute([$tema_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByTemaId($tema_id) {
        $stmt = $this->db->prepare("SELECT * FROM Ejercicio WHERE tema_id = ? ORDER BY titulo");
        $stmt->execute([$tema_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAll($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("SELECT * FROM Ejercicio ORDER BY nivel, titulo LIMIT $limit OFFSET $offset");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM Ejercicio");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    public function getAllSimple() {
        $stmt = $this->db->query("SELECT * FROM Ejercicio ORDER BY nivel, titulo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $tema_id = empty($data['tema_id']) ? null : $data['tema_id'];
        $stmt = $this->db->prepare("INSERT INTO Ejercicio (titulo, contenido, tipo, nivel, puntos, respuesta_correcta, tema_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['titulo'],
            $data['contenido'],
            $data['tipo'],
            $data['nivel'],
            $data['puntos'],
            $data['respuesta_correcta'],
            $tema_id
        ]);
    }
    
    public function update($id, $data) {
        $tema_id = empty($data['tema_id']) ? null : $data['tema_id'];
        $stmt = $this->db->prepare("UPDATE Ejercicio SET titulo = ?, contenido = ?, tipo = ?, nivel = ?, puntos = ?, respuesta_correcta = ?, tema_id = ? WHERE id = ?");
        return $stmt->execute([
            $data['titulo'],
            $data['contenido'],
            $data['tipo'],
            $data['nivel'],
            $data['puntos'],
            $data['respuesta_correcta'],
            $tema_id,
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Ejercicio WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getByFilters($nivel = null, $tema_id = null, $tipo = null) {
        $sql = "SELECT * FROM Ejercicio WHERE 1=1";
        $params = [];
        
        if ($nivel) {
            $sql .= " AND nivel = ?";
            $params[] = $nivel;
        }
        if ($tema_id) {
            $sql .= " AND tema_id = ?";
            $params[] = $tema_id;
        }
        if ($tipo) {
            $sql .= " AND tipo = ?";
            $params[] = $tipo;
        }
        
        $sql .= " ORDER BY nivel, titulo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>