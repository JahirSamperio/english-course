<?php
require_once 'models/Estudiante.php';
require_once 'models/Tema.php';
require_once 'models/Ejercicio.php';
require_once 'models/PlanEstudios.php';
require_once 'models/EstudiantesAsignados.php';
require_once 'models/Evaluacion.php';
require_once 'models/Progreso.php';
require_once 'models/Grupo.php';

class TeacherController {
    private $estudianteModel;
    private $temaModel;
    private $ejercicioModel;
    private $planModel;
    private $asignacionModel;
    private $evaluacionModel;
    private $progresoModel;
    private $grupoModel;
    
    public function __construct() {
        $this->estudianteModel = new Estudiante();
        $this->temaModel = new Tema();
        $this->ejercicioModel = new Ejercicio();
        $this->planModel = new PlanEstudios();
        $this->asignacionModel = new EstudiantesAsignados();
        $this->evaluacionModel = new Evaluacion();
        $this->progresoModel = new Progreso();
        $this->grupoModel = new Grupo();
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
            'grupos' => $this->grupoModel->getAllSimple(),
            'evaluaciones' => $this->evaluacionModel->getAllSimple(),
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
    
    public function crearEjerciciosMultiples() {
        $data = [
            'temas' => $this->temaModel->getAllSimple(),
            'page_title' => 'Crear Ejercicios Múltiples'
        ];
        $this->loadView('teacher/crear_ejercicios_multiples', $data);
    }
    
    public function guardarEjerciciosMultiples() {
        if ($_POST && isset($_POST['ejercicios'])) {
            $tema_id = empty($_POST['tema_id']) ? null : $_POST['tema_id'];
            $nivel = $_POST['nivel'];
            $ejercicios = $_POST['ejercicios'];
            $guardados = 0;
            $errores = [];
            
            foreach ($ejercicios as $index => $ejercicio) {
                $data = [
                    'titulo' => $ejercicio['titulo'],
                    'contenido' => $ejercicio['contenido'],
                    'respuesta_correcta' => $ejercicio['respuesta_correcta'],
                    'tipo' => $ejercicio['tipo'],
                    'nivel' => $nivel,
                    'puntos' => $ejercicio['puntos'],
                    'tema_id' => $tema_id
                ];
                
                if ($this->ejercicioModel->create($data)) {
                    $guardados++;
                } else {
                    $errores[] = "Ejercicio " . ($index + 1) . ": " . $ejercicio['titulo'];
                }
            }
            
            if ($guardados > 0) {
                $_SESSION['notification'] = [
                    'type' => 'success', 
                    'message' => "$guardados ejercicios creados exitosamente" . (!empty($errores) ? ". Errores: " . implode(', ', $errores) : "")
                ];
            } else {
                $_SESSION['notification'] = [
                    'type' => 'error', 
                    'message' => 'Error: No se pudo crear ningún ejercicio. ' . implode(', ', $errores)
                ];
            }
        } else {
            $_SESSION['notification'] = [
                'type' => 'error', 
                'message' => 'Error: No se recibieron ejercicios válidos'
            ];
        }
        
        header('Location: /englishdemo/?controller=teacher&action=dashboard');
        exit();
    }
    
    public function crearEvaluacionPdf() {
        $data = [
            'grupos' => $this->grupoModel->getAllSimple(),
            'page_title' => 'Crear Evaluación PDF'
        ];
        $this->loadView('teacher/crear_evaluacion_pdf', $data);
    }
    
    public function guardarEvaluacionPdf() {
        if ($_POST) {
            $grupo_id = $_POST['grupo_id'] ?? null;
            $db = Database::getInstance()->getConnection();
            
            try {
                $db->beginTransaction();
                
                if ($grupo_id) {
                    // Obtener estudiantes del grupo
                    $stmt = $db->prepare("
                        SELECT e.id as estudiante_id
                        FROM Grupo_Estudiantes ge 
                        JOIN Estudiante e ON ge.estudiante_id = e.id 
                        WHERE ge.grupo_id = ?
                    ");
                    $stmt->execute([$grupo_id]);
                    $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    $evaluaciones_creadas = 0;
                    
                    // Crear una evaluación para cada estudiante del grupo
                    foreach ($estudiantes as $estudiante) {
                        $stmt = $db->prepare("
                            INSERT INTO Evaluacion 
                            (titulo, descripcion, fecha, tiempo_limite, puntos_total, estudiante_id, profesor_id, grupo_id, archivo_pdf) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        
                        $stmt->execute([
                            $_POST['titulo'],
                            $_POST['descripcion'],
                            $_POST['fecha'],
                            $_POST['tiempo_limite'],
                            $_POST['puntos_total'],
                            $estudiante['estudiante_id'],
                            $_SESSION['profesor_id'] ?? 1,
                            $grupo_id,
                            $_POST['archivo_pdf'] ?? null
                        ]);
                        
                        $evaluaciones_creadas++;
                    }
                    
                    $db->commit();
                    $_SESSION['notification'] = [
                        'type' => 'success',
                        'message' => "Evaluación PDF creada. Se generaron $evaluaciones_creadas evaluaciones individuales para los estudiantes del grupo."
                    ];
                } else {
                    // Crear evaluación sin grupo (individual)
                    $data = [
                        'titulo' => $_POST['titulo'],
                        'descripcion' => $_POST['descripcion'],
                        'fecha' => $_POST['fecha'],
                        'tiempo_limite' => $_POST['tiempo_limite'],
                        'puntos_total' => $_POST['puntos_total'],
                        'archivo_pdf' => $_POST['archivo_pdf'] ?? null,
                        'profesor_id' => $_SESSION['profesor_id'] ?? 1,
                        'grupo_id' => null
                    ];
                    
                    if ($this->evaluacionModel->create($data)) {
                        $_SESSION['notification'] = [
                            'type' => 'success',
                            'message' => 'Evaluación PDF individual creada exitosamente'
                        ];
                    } else {
                        $_SESSION['notification'] = [
                            'type' => 'error',
                            'message' => 'Error al crear la evaluación'
                        ];
                    }
                }
                
            } catch (Exception $e) {
                $db->rollback();
                $_SESSION['notification'] = [
                    'type' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ];
            }
        }
        
        header('Location: /englishdemo/?controller=teacher&action=dashboard');
        exit();
    }
    
    // Métodos para gestión de grupos
    public function manageGroups() {
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $data = [
            'grupos' => $this->grupoModel->getAll($page, $limit),
            'current_page' => $page,
            'total_pages' => ceil($this->grupoModel->getCount() / $limit),
            'page_title' => 'Gestionar Grupos'
        ];
        $this->loadView('teacher/manage_groups', $data);
    }
    
    public function createGroup() {
        if ($_POST) {
            $_POST['profesor_id'] = $_SESSION['profesor_id'] ?? 1;
            if ($this->grupoModel->create($_POST)) {
                $_SESSION['notification'] = ['type' => 'success', 'message' => 'Grupo creado exitosamente'];
            } else {
                $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error al crear el grupo'];
            }
            header('Location: /englishdemo/?controller=teacher&action=panel');
            exit();
        }
    }
    
    public function assignToGroup() {
        if ($_POST) {
            $grupo_id = $_POST['grupo_id'];
            $estudiantes = $_POST['estudiantes'] ?? [];
            
            foreach ($estudiantes as $estudiante_id) {
                $this->grupoModel->addStudent($grupo_id, $estudiante_id);
            }
            $_SESSION['notification'] = ['type' => 'success', 'message' => 'Estudiantes asignados al grupo'];
            header('Location: /englishdemo/?controller=teacher&action=panel');
            exit();
        }
    }
    
    public function createStudent() {
        if ($_POST) {
            $db = Database::getInstance()->getConnection();
            
            try {
                $db->beginTransaction();
                
                // Crear usuario
                $stmt = $db->prepare("INSERT INTO Usuario (nombre, email, password, tipo) VALUES (?, ?, ?, 'estudiante')");
                $stmt->execute([$_POST['nombre'], $_POST['email'], $_POST['password']]);
                $usuario_id = $db->lastInsertId();
                
                // Crear estudiante
                $stmt = $db->prepare("INSERT INTO Estudiante (usuario_id, grado, edad, nivel_actual) VALUES (?, ?, ?, ?)");
                $stmt->execute([$usuario_id, $_POST['grado'], $_POST['edad'] ?? null, $_POST['grado']]);
                $estudiante_id = $db->lastInsertId();
                
                // Asignar a grupo si se seleccionó
                if (!empty($_POST['grupo_id'])) {
                    $stmt = $db->prepare("INSERT INTO Grupo_Estudiantes (grupo_id, estudiante_id) VALUES (?, ?)");
                    $stmt->execute([$_POST['grupo_id'], $estudiante_id]);
                }
                
                $db->commit();
                $_SESSION['notification'] = ['type' => 'success', 'message' => 'Estudiante creado exitosamente'];
            } catch (Exception $e) {
                $db->rollback();
                $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error al crear estudiante: ' . $e->getMessage()];
            }
            
            header('Location: /englishdemo/?controller=teacher&action=panel');
            exit();
        }
    }
    
    public function crearEstudianteCompleto() {
        $data = [
            'grupos' => $this->grupoModel->getAllSimple(),
            'page_title' => 'Crear Estudiante y Padre'
        ];
        $this->loadView('teacher/crear_estudiante_completo', $data);
    }
    
    public function guardarEstudianteCompleto() {
        if ($_POST && isset($_POST['estudiante']) && isset($_POST['padre'])) {
            $db = Database::getInstance()->getConnection();
            
            try {
                $db->beginTransaction();
                
                $estudiante = $_POST['estudiante'];
                $padre = $_POST['padre'];
                
                // Verificar que los emails sean diferentes
                if ($estudiante['email'] === $padre['email']) {
                    throw new Exception('El email del estudiante y del padre deben ser diferentes');
                }
                
                // Crear usuario estudiante
                $stmt = $db->prepare("INSERT INTO Usuario (nombre, email, password, tipo) VALUES (?, ?, ?, 'estudiante')");
                $stmt->execute([$estudiante['nombre'], $estudiante['email'], $estudiante['password']]);
                $estudiante_usuario_id = $db->lastInsertId();
                
                // Crear estudiante
                $stmt = $db->prepare("INSERT INTO Estudiante (usuario_id, grado, edad, nivel_actual) VALUES (?, ?, ?, ?)");
                $stmt->execute([$estudiante_usuario_id, $estudiante['grado'], $estudiante['edad'] ?? null, $estudiante['grado']]);
                $estudiante_id = $db->lastInsertId();
                
                // Crear usuario padre
                $stmt = $db->prepare("INSERT INTO Usuario (nombre, email, password, tipo) VALUES (?, ?, ?, 'padre')");
                $stmt->execute([$padre['nombre'], $padre['email'], $padre['password']]);
                $padre_usuario_id = $db->lastInsertId();
                
                // Crear padre
                $stmt = $db->prepare("INSERT INTO Padre (usuario_id, telefono) VALUES (?, ?)");
                $stmt->execute([$padre_usuario_id, $padre['telefono'] ?? null]);
                $padre_id = $db->lastInsertId();
                
                // Crear relación hijo-padre
                $stmt = $db->prepare("INSERT INTO Hijo (padre_id, estudiante_id) VALUES (?, ?)");
                $stmt->execute([$padre_id, $estudiante_id]);
                
                // Asignar estudiante a grupo si se seleccionó
                if (!empty($estudiante['grupo_id'])) {
                    $stmt = $db->prepare("INSERT INTO Grupo_Estudiantes (grupo_id, estudiante_id) VALUES (?, ?)");
                    $stmt->execute([$estudiante['grupo_id'], $estudiante_id]);
                }
                
                // Crear progreso inicial para el estudiante
                $stmt = $db->prepare("INSERT INTO Progreso (estudiante_id, ejercicios_completados, ejercicios_correctos, porcentaje, nivel_actual, puntos_acumulados, racha_dias) VALUES (?, 0, 0, 0.00, ?, 0, 0)");
                $stmt->execute([$estudiante_id, $estudiante['grado']]);
                
                $db->commit();
                $_SESSION['notification'] = [
                    'type' => 'success', 
                    'message' => 'Estudiante y padre creados exitosamente. Estudiante: ' . $estudiante['nombre'] . ', Padre: ' . $padre['nombre']
                ];
                
            } catch (Exception $e) {
                $db->rollback();
                $_SESSION['notification'] = [
                    'type' => 'error', 
                    'message' => 'Error al crear estudiante y padre: ' . $e->getMessage()
                ];
            }
            
            header('Location: /englishdemo/?controller=teacher&action=panel');
            exit();
        } else {
            $_SESSION['notification'] = [
                'type' => 'error', 
                'message' => 'Error: Datos incompletos para crear estudiante y padre'
            ];
            header('Location: /englishdemo/?controller=teacher&action=panel');
            exit();
        }
    }
    
    public function assignEvaluationToGroup() {
        if ($_POST) {
            $evaluacion_id = $_POST['evaluacion_id'];
            $grupo_id = $_POST['grupo_id'];
            
            $db = Database::getInstance()->getConnection();
            
            try {
                $db->beginTransaction();
                
                // Obtener datos de la evaluación original
                $stmt = $db->prepare("SELECT * FROM Evaluacion WHERE id = ?");
                $stmt->execute([$evaluacion_id]);
                $evaluacion_original = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Obtener estudiantes del grupo
                $stmt = $db->prepare("
                    SELECT e.id as estudiante_id
                    FROM Grupo_Estudiantes ge 
                    JOIN Estudiante e ON ge.estudiante_id = e.id 
                    WHERE ge.grupo_id = ?
                ");
                $stmt->execute([$grupo_id]);
                $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $evaluaciones_creadas = 0;
                
                // Crear una evaluación para cada estudiante del grupo
                foreach ($estudiantes as $estudiante) {
                    $stmt = $db->prepare("
                        INSERT INTO Evaluacion 
                        (titulo, descripcion, fecha, tiempo_limite, puntos_total, estudiante_id, profesor_id, grupo_id, archivo_pdf) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    
                    $stmt->execute([
                        $evaluacion_original['titulo'],
                        $evaluacion_original['descripcion'],
                        $evaluacion_original['fecha'],
                        $evaluacion_original['tiempo_limite'],
                        $evaluacion_original['puntos_total'],
                        $estudiante['estudiante_id'],
                        $evaluacion_original['profesor_id'],
                        $grupo_id,
                        $evaluacion_original['archivo_pdf']
                    ]);
                    
                    $evaluaciones_creadas++;
                }
                
                $db->commit();
                $_SESSION['notification'] = [
                    'type' => 'success', 
                    'message' => "Se crearon $evaluaciones_creadas evaluaciones individuales. Estudiantes encontrados: " . count($estudiantes) . ". Grupo ID: $grupo_id"
                ];
                
            } catch (Exception $e) {
                $db->rollback();
                $_SESSION['notification'] = [
                    'type' => 'error', 
                    'message' => 'Error: ' . $e->getMessage()
                ];
            }
            
            header('Location: /englishdemo/?controller=teacher&action=panel');
            exit();
        }
    }
    
    public function calificarEvaluaciones() {
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $db = Database::getInstance()->getConnection();
        
        // Obtener evaluaciones con información del estudiante
        $stmt = $db->prepare("
            SELECT e.*, u.nombre as estudiante_nombre
            FROM Evaluacion e
            LEFT JOIN Estudiante est ON e.estudiante_id = est.id
            LEFT JOIN Usuario u ON est.usuario_id = u.id
            ORDER BY e.fecha DESC, e.id DESC
            LIMIT $limit OFFSET $offset
        ");
        $stmt->execute();
        $evaluaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Contar total para paginación
        $stmt = $db->query("SELECT COUNT(*) as total FROM Evaluacion");
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $data = [
            'evaluaciones' => $evaluaciones,
            'current_page' => $page,
            'total_pages' => ceil($total / $limit),
            'page_title' => 'Calificar Evaluaciones'
        ];
        
        $this->loadView('teacher/calificar_evaluaciones', $data);
    }
    
    public function guardarCalificacion() {
        if ($_POST && isset($_POST['evaluacion_id']) && isset($_POST['calificacion'])) {
            $evaluacion_id = $_POST['evaluacion_id'];
            $calificacion = floatval($_POST['calificacion']);
            
            // Validar rango de calificación
            if ($calificacion < 0 || $calificacion > 100) {
                $_SESSION['notification'] = [
                    'type' => 'error',
                    'message' => 'La calificación debe estar entre 0 y 100'
                ];
            } else {
                $db = Database::getInstance()->getConnection();
                $stmt = $db->prepare("UPDATE Evaluacion SET resultado = ? WHERE id = ?");
                
                if ($stmt->execute([$calificacion, $evaluacion_id])) {
                    $_SESSION['notification'] = [
                        'type' => 'success',
                        'message' => 'Calificación guardada exitosamente: ' . $calificacion . '%'
                    ];
                } else {
                    $_SESSION['notification'] = [
                        'type' => 'error',
                        'message' => 'Error al guardar la calificación'
                    ];
                }
            }
        } else {
            $_SESSION['notification'] = [
                'type' => 'error',
                'message' => 'Datos incompletos para guardar calificación'
            ];
        }
        
        header('Location: /englishdemo/?controller=teacher&action=calificarEvaluaciones');
        exit();
    }
    
    private function loadView($view, $data = []) {
        extract($data);
        require_once "views/$view.php";
    }
}
?>