<?php
session_start();
require_once '../config/Database.php';
$pdo = Database::getInstance()->getConnection();

header('Content-Type: application/json');

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'estudiante') {
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit();
}

$estudiante_id = $_SESSION['estudiante_id'];
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['results'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
    exit();
}

try {
    $pdo->beginTransaction();
    
    // Crear una evaluación general para esta sesión
    $stmt = $pdo->prepare("INSERT INTO Evaluacion (titulo, descripcion, fecha, tiempo_limite, puntos_total, resultado, estudiante_id) VALUES (?, ?, CURDATE(), 30, ?, ?, ?)");
    $stmt->execute([
        'Interactive Exercise Session',
        'Student practice session with interactive exercises',
        $input['totalPoints'],
        round(($input['totalCorrect'] / count($input['results'])) * 100, 2),
        $estudiante_id
    ]);
    
    $evaluacion_id = $pdo->lastInsertId();
    
    // Guardar cada resultado individual
    foreach ($input['results'] as $result) {
        $stmt = $pdo->prepare("INSERT INTO Resultado_de_evaluacion (calificaciones, comentarios, fecha_de_realizacion, evaluacion_id, ejercicio_id, respuesta_estudiante, es_correcta) VALUES (?, ?, NOW(), ?, ?, ?, ?)");
        $stmt->execute([
            $result['points'],
            $result['isCorrect'] ? 'Correct answer' : 'Incorrect answer',
            $evaluacion_id,
            $result['exerciseId'],
            $result['userAnswer'],
            $result['isCorrect'] ? 1 : 0
        ]);
    }
    
    // Actualizar progreso del estudiante
    $stmt = $pdo->prepare("UPDATE Progreso SET 
        ejercicios_completados = ejercicios_completados + ?, 
        ejercicios_correctos = ejercicios_correctos + ?, 
        puntos_acumulados = puntos_acumulados + ?,
        ultima_actividad = NOW()
        WHERE estudiante_id = ?");
    $stmt->execute([
        count($input['results']),
        $input['totalCorrect'],
        $input['totalPoints'],
        $estudiante_id
    ]);
    
    // Recalcular porcentaje
    $stmt = $pdo->prepare("UPDATE Progreso SET porcentaje = (ejercicios_correctos * 100.0 / ejercicios_completados) WHERE estudiante_id = ? AND ejercicios_completados > 0");
    $stmt->execute([$estudiante_id]);
    
    // Actualizar racha si es necesario
    $stmt = $pdo->prepare("SELECT DATE(ultima_actividad) as last_date FROM Progreso WHERE estudiante_id = ?");
    $stmt->execute([$estudiante_id]);
    $progreso = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($progreso && $progreso['last_date'] == date('Y-m-d')) {
        $stmt = $pdo->prepare("UPDATE Progreso SET racha_dias = racha_dias + 1 WHERE estudiante_id = ?");
        $stmt->execute([$estudiante_id]);
    }
    
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Results saved successfully',
        'evaluacion_id' => $evaluacion_id
    ]);
    
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>