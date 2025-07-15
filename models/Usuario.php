<?php
require_once 'config/Database.php';

class Usuario {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function authenticate($email, $password, $tipo) {
        $stmt = $this->db->prepare("
            SELECT u.*, e.id as estudiante_id, p.id as padre_id, pr.id as profesor_id 
            FROM Usuario u 
            LEFT JOIN Estudiante e ON u.id = e.usuario_id 
            LEFT JOIN Padre p ON u.id = p.usuario_id 
            LEFT JOIN Profesor pr ON u.id = pr.usuario_id 
            WHERE u.email = ? AND u.password = ? AND u.tipo = ?
        ");
        $stmt->execute([$email, $password, $tipo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO Usuario (nombre, email, password, tipo) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['nombre'], $data['email'], $data['password'], $data['tipo']]);
    }
}
?>