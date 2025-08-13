<?php
// Incluir autoload de Composer
require_once 'vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Router simple
$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

// Verificar autenticación
if ($controller !== 'auth' && !isset($_SESSION['tipo'])) {
    header('Location: /englishdemo/?controller=auth&action=login');
    exit();
}

// Debug de sesión
if (isset($_GET['debug'])) {
    echo "Session ID: " . session_id() . "<br>";
    echo "Controller: $controller, Action: $action<br>";
    echo "Session tipo: " . ($_SESSION['tipo'] ?? 'no set') . "<br>";
    echo "Session data: " . print_r($_SESSION, true) . "<br>";
}

// Cargar controlador apropiado
switch ($controller) {
    case 'student':
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'estudiante') {
            header('Location: /englishdemo/?controller=auth&action=login');
            exit();
        }
        require_once 'controllers/StudentController.php';
        $ctrl = new StudentController();
        
        switch ($action) {
            case 'dashboard':
                $ctrl->dashboard($_SESSION['estudiante_id']);
                break;
            case 'assignedContent':
                $ctrl->assignedContent($_SESSION['estudiante_id']);
                break;
            case 'interactiveExercises':
                $ctrl->interactiveExercises($_SESSION['estudiante_id'], $_GET['nivel'] ?? 'Beginner', $_GET['tema_id'] ?? null);
                break;
            case 'startTopic':
                $ctrl->startTopic($_SESSION['estudiante_id']);
                break;
            case 'startUnit':
                $ctrl->startUnit($_SESSION['estudiante_id']);
                break;
            case 'startEvaluation':
                $ctrl->startEvaluation($_SESSION['estudiante_id']);
                break;
            case 'viewContent':
                $ctrl->viewContent($_SESSION['estudiante_id']);
                break;
            case 'verEvaluaciones':
                $ctrl->verEvaluaciones($_SESSION['estudiante_id']);
                break;
            default:
                $ctrl->dashboard($_SESSION['estudiante_id']);
                break;
        }
        break;
        
    case 'teacher':
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'profesor') {
            header('Location: /englishdemo/?controller=auth&action=login');
            exit();
        }
        require_once 'controllers/TeacherController.php';
        $ctrl = new TeacherController();
        
        switch ($action) {
            case 'dashboard':
                $ctrl->dashboard();
                break;
            case 'createEvaluation':
                $ctrl->createEvaluation();
                break;
            case 'panel':
                $ctrl->panel();
                break;
            case 'results':
                $ctrl->results();
                break;
            case 'createPlan':
                $ctrl->createPlan();
                break;
            case 'createTopic':
                $ctrl->createTopic();
                break;
            case 'assignPlan':
                $ctrl->assignPlan();
                break;
            case 'createExercise':
                $ctrl->createExercise();
                break;
            case 'managePlans':
                $ctrl->managePlans();
                break;
            case 'manageTopics':
                $ctrl->manageTopics();
                break;
            case 'manageExercises':
                $ctrl->manageExercises();
                break;
            case 'editPlan':
                $ctrl->editPlan($_GET['id'] ?? null);
                break;
            case 'editTopic':
                $ctrl->editTopic($_GET['id'] ?? null);
                break;
            case 'editExercise':
                $ctrl->editExercise($_GET['id'] ?? null);
                break;
            case 'deletePlan':
                $ctrl->deletePlan($_GET['id'] ?? null);
                break;
            case 'deleteTopic':
                $ctrl->deleteTopic($_GET['id'] ?? null);
                break;
            case 'deleteExercise':
                $ctrl->deleteExercise($_GET['id'] ?? null);
                break;
            case 'crearEjerciciosMultiples':
                $ctrl->crearEjerciciosMultiples();
                break;
            case 'guardarEjerciciosMultiples':
                $ctrl->guardarEjerciciosMultiples();
                break;
            case 'crearEvaluacionPdf':
                $ctrl->crearEvaluacionPdf();
                break;
            case 'guardarEvaluacionPdf':
                $ctrl->guardarEvaluacionPdf();
                break;
            case 'manageGroups':
                $ctrl->manageGroups();
                break;
            case 'createGroup':
                $ctrl->createGroup();
                break;
            case 'assignToGroup':
                $ctrl->assignToGroup();
                break;
            case 'assignEvaluationToGroup':
                $ctrl->assignEvaluationToGroup();
                break;
            case 'createStudent':
                $ctrl->createStudent();
                break;
            case 'crearEstudianteCompleto':
                $ctrl->crearEstudianteCompleto();
                break;
            case 'guardarEstudianteCompleto':
                $ctrl->guardarEstudianteCompleto();
                break;
            case 'calificarEvaluaciones':
                $ctrl->calificarEvaluaciones();
                break;
            case 'guardarCalificacion':
                $ctrl->guardarCalificacion();
                break;
            default:
                $ctrl->dashboard();
                break;
        }
        break;
        
    case 'parent':
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'padre') {
            header('Location: /englishdemo/?controller=auth&action=login');
            exit();
        }
        require_once 'controllers/ParentController.php';
        $ctrl = new ParentController();
        
        switch ($action) {
            case 'dashboard':
                $ctrl->dashboard($_SESSION['padre_id']);
                break;
            default:
                $ctrl->dashboard($_SESSION['padre_id']);
                break;
        }
        break;
        
    case 'file':
        require_once 'controllers/FileController.php';
        $ctrl = new FileController();
        
        switch ($action) {
            case 'uploadAudio':
                $ctrl->uploadAudio();
                break;
            case 'uploadImage':
                $ctrl->uploadImage();
                break;
            case 'uploadEvaluacionPdf':
                $ctrl->uploadEvaluacionPdf();
                break;
        }
        break;
        
    case 'auth':
    default:
        require_once 'controllers/AuthController.php';
        $ctrl = new AuthController();
        
        switch ($action) {
            case 'login':
                $ctrl->login();
                break;
            case 'logout':
                $ctrl->logout();
                break;
            default:
                $ctrl->login();
                break;
        }
        break;
}
?>