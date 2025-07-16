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
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $estudiantes = $this->estudianteModel->getAll($page, $limit);
        $total_evaluaciones = $this->evaluacionModel->getAll();
        $total_ejercicios = $this->ejercicioModel->getAllSimple();
        
        $data = [
            'total_estudiantes' => $this->estudianteModel->getCount(),
            'total_evaluaciones' => $total_evaluaciones,
            'total_ejercicios' => count($total_ejercicios),
            'estudiantes' => $estudiantes,
            'current_page' => $page,
            'total_pages' => ceil($this->estudianteModel->getCount() / $limit),
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
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $data = [
            'planes' => $this->planModel->getAllSimple(),
            'estudiantes' => $this->estudianteModel->getAllSimple(),
            'temas' => $this->temaModel->getAllSimple(),
            'asignaciones' => $this->asignacionModel->getAll($page, $limit),
            'current_page' => $page,
            'total_pages' => ceil($this->asignacionModel->getCount() / $limit),
            'page_title' => 'Panel del Profesor'
        ];
        $this->loadView('teacher/panel_profesor', $data);
    }
    
    public function results() {
        $page = $_GET['page'] ?? 1;
        $page2 = $_GET['page2'] ?? 1;
        $limit = 5;
        $estudiantes_progreso = $this->progresoModel->getAll($page, $limit);
        $evaluaciones_recientes = $this->evaluacionModel->getRecent($page2, $limit);
        
        $data = [
            'estudiantes_progreso' => $estudiantes_progreso,
            'evaluaciones_recientes' => $evaluaciones_recientes,
            'current_page' => $page,
            'total_pages' => ceil($this->progresoModel->getCount() / $limit),
            'current_page2' => $page2,
            'total_pages2' => ceil($this->evaluacionModel->getCount() / $limit),
            'estadisticas' => [
                'total_estudiantes' => $this->progresoModel->getCount(),
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
            if ($this->planModel->create($_POST)) {
                $_SESSION['notification'] = ['type' => 'success', 'message' => 'Plan creado exitosamente'];
            } else {
                $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error al crear el plan'];
            }
            header('Location: /englishdemo/?controller=teacher&action=panel');
            exit();
        }
    }
    
    public function createTopic() {
        if ($_POST) {
            $_POST['contenidos'] = $_POST['descripcion'];
            if ($this->temaModel->create($_POST)) {
                $_SESSION['notification'] = ['type' => 'success', 'message' => 'Tema creado exitosamente'];
            } else {
                $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error al crear el tema'];
            }
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
    
    public function createExercise() {
        if ($_POST) {
            if ($this->ejercicioModel->create($_POST)) {
                $_SESSION['notification'] = ['type' => 'success', 'message' => 'Ejercicio creado exitosamente'];
            } else {
                $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error al crear el ejercicio'];
            }
            header('Location: /englishdemo/?controller=teacher&action=panel');
            exit();
        }
        $data = [
            'temas' => $this->temaModel->getAll(),
            'page_title' => 'Crear Ejercicio'
        ];
        $this->loadView('teacher/crear_ejercicio', $data);
    }
    
    public function managePlans() {
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $data = [
            'planes' => $this->planModel->getAll($page, $limit),
            'total' => $this->planModel->getCount(),
            'current_page' => $page,
            'total_pages' => ceil($this->planModel->getCount() / $limit),
            'page_title' => 'Gestionar Planes'
        ];
        $this->loadView('teacher/manage_plans', $data);
    }
    
    public function manageTopics() {
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $data = [
            'temas' => $this->temaModel->getAll($page, $limit),
            'total' => $this->temaModel->getCount(),
            'current_page' => $page,
            'total_pages' => ceil($this->temaModel->getCount() / $limit),
            'page_title' => 'Gestionar Temas'
        ];
        $this->loadView('teacher/manage_topics', $data);
    }
    
    public function manageExercises() {
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $data = [
            'ejercicios' => $this->ejercicioModel->getAll($page, $limit),
            'total' => $this->ejercicioModel->getCount(),
            'current_page' => $page,
            'total_pages' => ceil($this->ejercicioModel->getCount() / $limit),
            'page_title' => 'Gestionar Ejercicios'
        ];
        $this->loadView('teacher/manage_exercises', $data);
    }
    
    public function editPlan($id) {
        if ($_POST) {
            if ($this->planModel->update($id, $_POST)) {
                $_SESSION['notification'] = ['type' => 'success', 'message' => 'Plan actualizado exitosamente'];
            } else {
                $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error al actualizar el plan'];
            }
            header('Location: /englishdemo/?controller=teacher&action=managePlans');
            exit();
        }
        $data = [
            'plan' => $this->planModel->getById($id),
            'page_title' => 'Editar Plan'
        ];
        $this->loadView('teacher/edit_plan', $data);
    }
    
    public function editTopic($id) {
        if ($_POST) {
            if ($this->temaModel->update($id, $_POST)) {
                $_SESSION['notification'] = ['type' => 'success', 'message' => 'Tema actualizado exitosamente'];
            } else {
                $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error al actualizar el tema'];
            }
            header('Location: /englishdemo/?controller=teacher&action=manageTopics');
            exit();
        }
        $data = [
            'tema' => $this->temaModel->getById($id),
            'page_title' => 'Editar Tema'
        ];
        $this->loadView('teacher/edit_topic', $data);
    }
    
    public function editExercise($id) {
        if ($_POST) {
            if ($this->ejercicioModel->update($id, $_POST)) {
                $_SESSION['notification'] = ['type' => 'success', 'message' => 'Ejercicio actualizado exitosamente'];
            } else {
                $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error al actualizar el ejercicio'];
            }
            header('Location: /englishdemo/?controller=teacher&action=manageExercises');
            exit();
        }
        $data = [
            'ejercicio' => $this->ejercicioModel->getById($id),
            'temas' => $this->temaModel->getAll(),
            'page_title' => 'Editar Ejercicio'
        ];
        $this->loadView('teacher/edit_exercise', $data);
    }
    
    public function deletePlan($id) {
        if ($this->planModel->delete($id)) {
            $_SESSION['notification'] = ['type' => 'success', 'message' => 'Plan eliminado exitosamente'];
        } else {
            $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error al eliminar el plan'];
        }
        header('Location: /englishdemo/?controller=teacher&action=managePlans');
        exit();
    }
    
    public function deleteTopic($id) {
        if ($this->temaModel->delete($id)) {
            $_SESSION['notification'] = ['type' => 'success', 'message' => 'Tema eliminado exitosamente'];
        } else {
            $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error al eliminar el tema'];
        }
        header('Location: /englishdemo/?controller=teacher&action=manageTopics');
        exit();
    }
    
    public function deleteExercise($id) {
        if ($this->ejercicioModel->delete($id)) {
            $_SESSION['notification'] = ['type' => 'success', 'message' => 'Ejercicio eliminado exitosamente'];
        } else {
            $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error al eliminar el ejercicio'];
        }
        header('Location: /englishdemo/?controller=teacher&action=manageExercises');
        exit();
    }
    
    private function loadView($view, $data = []) {
        extract($data);
        require_once "views/$view.php";
    }
}
?>