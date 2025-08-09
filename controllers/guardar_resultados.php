<?php
error_reporting(0);
ini_set('display_errors', 0);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

try {
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/Progreso.php';
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Include error']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid method']);
    exit;
}

if (!isset($_SESSION['estudiante_id'])) {
    echo json_encode(['success' => false, 'error' => 'No student session', 'session' => $_SESSION]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$estudiante_id = $_SESSION['estudiante_id'];
$totalCorrect = $input['totalCorrect'] ?? 0;
$totalPoints = $input['totalPoints'] ?? 0;
$totalExercises = count($input['results'] ?? []);

// Obtener progreso actual
try {
    $progresoModel = new Progreso();
    $progreso_actual = $progresoModel->getByStudentId($estudiante_id);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    exit;
}

// Calcular nuevos valores
$ejercicios_completados = ($progreso_actual['ejercicios_completados'] ?? 0) + $totalExercises;
$ejercicios_correctos = ($progreso_actual['ejercicios_correctos'] ?? 0) + $totalCorrect;
$puntos_acumulados = ($progreso_actual['puntos_acumulados'] ?? 0) + $totalPoints;
$porcentaje = $ejercicios_completados > 0 ? round(($ejercicios_correctos / $ejercicios_completados) * 100, 2) : 0;

// Actualizar racha
$racha_dias = ($progreso_actual['racha_dias'] ?? 0) + 1;

// Determinar nivel
$nivel_actual = 'Beginner';
if ($porcentaje >= 90) $nivel_actual = 'Advanced';
elseif ($porcentaje >= 70) $nivel_actual = 'Intermediate';
elseif ($porcentaje >= 50) $nivel_actual = 'Elementary';

// Actualizar progreso
$success = $progresoModel->updateProgress($estudiante_id, [
    'ejercicios_completados' => $ejercicios_completados,
    'ejercicios_correctos' => $ejercicios_correctos,
    'porcentaje' => $porcentaje,
    'puntos_acumulados' => $puntos_acumulados,
    'racha_dias' => $racha_dias,
    'nivel_actual' => $nivel_actual
]);

echo json_encode([
    'success' => $success,
    'debug' => [
        'estudiante_id' => $estudiante_id,
        'totalExercises' => $totalExercises,
        'totalCorrect' => $totalCorrect,
        'totalPoints' => $totalPoints,
        'porcentaje' => $porcentaje
    ]
]);
?>