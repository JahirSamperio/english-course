<?php
require_once 'config/Database.php';

class Audio {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getByTema($tema_id) {
        $stmt = $this->db->prepare("SELECT * FROM Audio WHERE tema_id = ? ORDER BY titulo");
        $stmt->execute([$tema_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT a.*, t.nombre as tema_nombre FROM Audio a LEFT JOIN Tema t ON a.tema_id = t.id ORDER BY t.nombre, a.titulo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO Audio (archivo_audio, titulo, duracion, transcripcion, tema_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['archivo_audio'],
            $data['titulo'],
            $data['duracion'],
            $data['transcripcion'],
            $data['tema_id']
        ]);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Audio WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>