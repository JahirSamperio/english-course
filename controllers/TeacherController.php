<?php
require_once 'models/Estudiante.php';
require_once 'models/Tema.php';
require_once 'models/Ejercicio.php';
require_once 'models/PlanEstudios.php';
require_once 'models/EstudiantesAsignados.php';
require_once 'models/Evaluacion.php';
require_once 'models/Progreso.php';

class TeacherController {
    private $estudianteModel;
    private $temaModel;
    private $ejercicioModel;
    private $planModel;
    private $asignacionModel;
    private $evaluacionModel;
    private $progresoModel;
    
    public function __construct() {
        $this->estudianteModel = new Estudiante();
        $this->temaModel = new Tema();
        $this->ejercicioModel = new Ejercicio();
        $this->planModel = new PlanEstudios();
        $this->asignacionModel = new EstudiantesAsignados();
        $this->evaluacionModel = new Evaluacion();
        $this->progresoModel = new Progreso();
    }
    
    public function dashboard() {
        $estudiantes = $this->estudianteModel->getAll();
        $total_evaluaciones = $this->evaluacionModel->getAll();
        $total_ejercicios = $this->ejercicioModel->getAll();
        
        $data = [
            'total_estudiantes' => count($estudiantes),
            'total_evaluaciones' => $total_evaluaciones,
            'total_ejercicios' => count($total_ejercicios),
            'estudiantes' => $estudiantes,
            'page_title' => 'Teacher Dashboard'
        ];
        
        $this->loadView('teacher/dashboard_docente', $data);
    }
    
    public function createTema($data) {
        if ($this->temaModel->create($data)) {
            return ['success' => true, 'message' => 'Tema creado exitosamente'];
        }
        return ['success' => false, 'message' => 'Error al crear tema'];
    }
    
    public function createEjercicio($data) {
        if ($this->ejercicioModel->create($data)) {
            return ['success' => true, 'message' => 'Ejercicio creado exitosamente'];
        }
        return ['success' => false, 'message' => 'Error al crear ejercicio'];
    }
    
    public function createEvaluation() {
        if ($_POST) {
            $this->evaluacionModel->create($_POST);
            header('Location: /englishdemo/?controller=teacher&action=dashboard');
            exit();
        }
        $data = ['page_title' => 'Crear Evaluación'];
        $this->loadView('teacher/crear_evaluacion', $data);
    }
    
    public function panel() {
        $data = [
            'planes' => $this->planModel->getAll(),
            'estudiantes' => $this->estudianteModel->getAll(),
            'temas' => $this->temaModel->getAll(),
            'asignaciones' => $this->asignacionModel->getAll(),
            'page_title' => 'Panel del Profesor'
        ];
        $this->loadView('teacher/panel_profesor', $data);
    }
    
    public function results() {
        // Mostrar todos los resultados sin filtros
        $estudiantes_progreso = $this->progresoModel->getAll();
        $evaluaciones_recientes = $this->evaluacionModel->getRecent(10);
        
        $data = [
            'estudiantes_progreso' => $estudiantes_progreso,
            'evaluaciones_recientes' => $evaluaciones_recientes,
            'estadisticas' => [
                'total_estudiantes' => count($estudiantes_progreso),
                'promedio_progreso' => count($estudiantes_progreso) > 0 ? round(array_sum(array_column($estudiantes_progreso, 'porcentaje')) / count($estudiantes_progreso), 2) : 0,
                'total_puntos' => array_sum(array_column($estudiantes_progreso, 'puntos_acumulados')),
                'ejercicios_completados' => array_sum(array_column($estudiantes_progreso, 'ejercicios_completados'))
            ],
            'page_title' => 'Ver Resultados'
        ];
        $this->loadView('teacher/resultados', $data);
    }
    
    public function createPlan() {
        if ($_POST) {
            $this->planModel->create($_POST);
            header('Location: /englishdemo/?controller=teacher&action=panel');
            exit();
        }
    }
    
    public function createTopic() {
        if ($_POST) {
            $_POST['contenidos'] = $_POST['descripcion'];
            $this->temaModel->create($_POST);
            header('Location: /englishdemo/?controller=teacher&action=panel');
            exit();
        }
    }
    
    public function assignPlan() {
        if ($_POST) {
            $plan_id = $_POST['plan_id'];
            $estudiantes = $_POST['estudiantes'] ?? [];
            
            foreach ($estudiantes as $estudiante_id) {
                $this->asignacionModel->assignPlan($estudiante_id, $plan_id);
            }
            header('Location: /englishdemo/?controller=teacher&action=panel');
            exit();
        }
    }
    
    private function loadView($view, $data = []) {
        extract($data);
        require_once "views/$view.php";
    }
}
?>