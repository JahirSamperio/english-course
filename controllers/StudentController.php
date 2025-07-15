<?php
require_once 'models/Estudiante.php';
require_once 'models/Tema.php';
require_once 'models/Ejercicio.php';

class StudentController {
    private $estudianteModel;
    private $temaModel;
    private $ejercicioModel;
    
    public function __construct() {
        $this->estudianteModel = new Estudiante();
        $this->temaModel = new Tema();
        $this->ejercicioModel = new Ejercicio();
    }
    
    public function dashboard($estudiante_id) {
        $estudiante = $this->estudianteModel->getWithProgress($estudiante_id);
        $temas = $this->temaModel->getAssignedToStudent($estudiante_id);
        $ejercicios = $this->ejercicioModel->getByLevel($estudiante['grado'] ?? 'Beginner');
        
        $data = [
            'estudiante' => $estudiante,
            'temas' => $temas,
            'ejercicios' => $ejercicios,
            'page_title' => 'Student Dashboard'
        ];
        
        $this->loadView('student/dashboard_alumno', $data);
    }
    
    public function assignedContent($estudiante_id) {
        $estudiante = $this->estudianteModel->getWithProgress($estudiante_id);
        $plan = $this->estudianteModel->getAssignedPlan($estudiante_id);
        $temas = $this->temaModel->getAssignedToStudent($estudiante_id);
        
        // Obtener ejercicios con nombre del tema usando Database
        require_once 'config/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT e.*, t.nombre as tema_nombre 
            FROM Ejercicio e 
            LEFT JOIN Tema t ON e.tema_id = t.id 
            WHERE e.nivel = ? 
            ORDER BY e.titulo
        ");
        $stmt->execute([$estudiante['grado'] ?? 'Beginner']);
        $ejercicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $data = [
            'estudiante' => $estudiante,
            'plan' => $plan,
            'temas' => $temas,
            'ejercicios' => $ejercicios,
            'page_title' => 'My Learning Content'
        ];
        
        $this->loadView('student/contenido_asignado', $data);
    }
    
    public function interactiveExercises($estudiante_id, $nivel = null, $tema_id = null) {
        $estudiante = $this->estudianteModel->getWithProgress($estudiante_id);
        $temas = $this->temaModel->getAssignedToStudent($estudiante_id);
        
        // Filtrar por nivel del estudiante
        $ejercicios = $this->ejercicioModel->getByLevel($estudiante['grado'] ?? 'Beginner');
        
        $data = [
            'estudiante' => $estudiante,
            'temas' => $temas,
            'ejercicios' => $ejercicios,
            'page_title' => 'Interactive Exercises'
        ];
        
        $this->loadView('student/ejercicios_interactivos', $data);
    }
    
    private function loadView($view, $data = []) {
        extract($data);
        require_once "views/$view.php";
    }
}
?>