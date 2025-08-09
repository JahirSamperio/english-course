<?php
session_start();
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid method');
    }

    if (!isset($_SESSION['estudiante_id'])) {
        throw new Exception('No student session');
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        throw new Exception('Invalid JSON input');
    }

    require_once 'config/Database.php';
    $db = Database::getInstance()->getConnection();

    $estudiante_id = $_SESSION['estudiante_id'];
    $totalCorrect = $input['totalCorrect'] ?? 0;
    $totalPoints = $input['totalPoints'] ?? 0;
    $totalExercises = count($input['results'] ?? []);

    // Obtener progreso actual
    $stmt = $db->prepare("SELECT * FROM Progreso WHERE estudiante_id = ?");
    $stmt->execute([$estudiante_id]);
    $progreso = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$progreso) {
        // Crear progreso inicial
        $stmt = $db->prepare("INSERT INTO Progreso (estudiante_id, ejercicios_completados, ejercicios_correctos, puntos_acumulados, porcentaje, racha_dias) VALUES (?, ?, ?, ?, ?, ?)");
        $porcentaje = $totalExercises > 0 ? round(($totalCorrect / $totalExercises) * 100, 2) : 0;
        $stmt->execute([$estudiante_id, $totalExercises, $totalCorrect, $totalPoints, $porcentaje, 1]);
    } else {
        // Actualizar progreso existente
        $ejercicios_completados = $progreso['ejercicios_completados'] + $totalExercises;
        $ejercicios_correctos = $progreso['ejercicios_correctos'] + $totalCorrect;
        $puntos_acumulados = $progreso['puntos_acumulados'] + $totalPoints;
        $porcentaje = $ejercicios_completados > 0 ? round(($ejercicios_correctos / $ejercicios_completados) * 100, 2) : 0;
        $racha_dias = $progreso['racha_dias'] + 1;

        $stmt = $db->prepare("UPDATE Progreso SET ejercicios_completados = ?, ejercicios_correctos = ?, puntos_acumulados = ?, porcentaje = ?, racha_dias = ? WHERE estudiante_id = ?");
        $stmt->execute([$ejercicios_completados, $ejercicios_correctos, $puntos_acumulados, $porcentaje, $racha_dias, $estudiante_id]);
    }

    echo json_encode(['success' => true, 'message' => 'Results saved successfully']);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>