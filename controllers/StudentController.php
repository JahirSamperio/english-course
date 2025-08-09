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
    
    public function startTopic($estudiante_id) {
        $tema_id = $_GET['tema_id'] ?? null;
        $nivel = $_GET['nivel'] ?? 'Beginner';
        
        if (!$tema_id) {
            header('Location: ?controller=student&action=assignedContent');
            exit;
        }
        
        $tema = $this->temaModel->getById($tema_id);
        $ejercicios = $this->ejercicioModel->getByTemaId($tema_id);
        $estudiante = $this->estudianteModel->getWithProgress($estudiante_id);
        
        $data = [
            'tema' => $tema,
            'ejercicios' => $ejercicios,
            'estudiante' => $estudiante,
            'nivel' => $nivel,
            'page_title' => 'Start Topic - ' . ($tema['nombre'] ?? 'Topic')
        ];
        
        $this->loadView('student/start_topic', $data);
    }
    
    public function startUnit($estudiante_id) {
        $unidad_id = $_GET['unidad_id'] ?? null;
        $nivel = $_GET['nivel'] ?? 'Beginner';
        
        if (!$unidad_id) {
            header('Location: ?controller=student&action=assignedContent');
            exit;
        }
        
        // Obtener temas de la unidad
        require_once 'config/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM Tema WHERE id = ?");
        $stmt->execute([$unidad_id]);
        $unidad = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $temas = $this->temaModel->getByLevel($nivel);
        $estudiante = $this->estudianteModel->getWithProgress($estudiante_id);
        
        $data = [
            'unidad' => $unidad,
            'temas' => $temas,
            'estudiante' => $estudiante,
            'nivel' => $nivel,
            'page_title' => 'Start Unit - ' . ($unidad['nombre'] ?? 'Unit')
        ];
        
        $this->loadView('student/start_unit', $data);
    }
    
    public function startEvaluation($estudiante_id) {
        $evaluacion_id = $_GET['evaluacion_id'] ?? null;
        $nivel = $_GET['nivel'] ?? 'Beginner';
        
        if (!$evaluacion_id) {
            header('Location: ?controller=student&action=assignedContent');
            exit;
        }
        
        // Obtener evaluación
        require_once 'config/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM Evaluacion WHERE id = ?");
        $stmt->execute([$evaluacion_id]);
        $evaluacion = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $ejercicios = $this->ejercicioModel->getByLevel($nivel);
        $estudiante = $this->estudianteModel->getWithProgress($estudiante_id);
        
        $data = [
            'evaluacion' => $evaluacion,
            'ejercicios' => $ejercicios,
            'estudiante' => $estudiante,
            'nivel' => $nivel,
            'page_title' => 'Start Evaluation - ' . ($evaluacion['titulo'] ?? 'Evaluation')
        ];
        
        $this->loadView('student/start_evaluation', $data);
    }
    
    public function viewContent($estudiante_id) {
        $tema_id = $_GET['tema_id'] ?? null;
        
        if (!$tema_id) {
            header('Location: ?controller=student&action=assignedContent');
            exit;
        }
        
        $tema = $this->temaModel->getById($tema_id);
        $estudiante = $this->estudianteModel->getWithProgress($estudiante_id);
        
        $data = [
            'tema' => $tema,
            'estudiante' => $estudiante,
            'page_title' => 'Content - ' . ($tema['nombre'] ?? 'Topic')
        ];
        
        $this->loadView('student/view_content', $data);
    }
    
    public function verEvaluaciones($estudiante_id) {
        require_once 'config/Database.php';
        $db = Database::getInstance()->getConnection();
        
        // Obtener evaluaciones disponibles para el estudiante
        $stmt = $db->prepare("
            SELECT * FROM Evaluacion 
            WHERE archivo_pdf IS NOT NULL 
            ORDER BY fecha DESC
        ");
        $stmt->execute();
        $evaluaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $estudiante = $this->estudianteModel->getWithProgress($estudiante_id);
        
        $data = [
            'evaluaciones' => $evaluaciones,
            'estudiante' => $estudiante,
            'page_title' => 'Mis Evaluaciones'
        ];
        
        $this->loadView('student/evaluaciones_pdf', $data);
    }
    
    private function loadView($view, $data = []) {
        extract($data);
        require_once "views/$view.php";
    }
}
?>