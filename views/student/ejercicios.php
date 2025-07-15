<?php
session_start();
require_once '../config/Database.php';
$pdo = Database::getInstance()->getConnection();

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'estudiante') {
    header('Location: login.php');
    exit();
}

$estudiante_id = $_SESSION['estudiante_id'];

// Obtener ejercicios
$stmt = $pdo->query("SELECT id, titulo, contenido, respuesta_correcta, tipo, nivel, puntos FROM Ejercicio ORDER BY RAND() LIMIT 5");
$ejercicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar respuesta si se envió
if ($_POST && isset($_POST['ejercicio_id']) && isset($_POST['respuesta'])) {
    $ejercicio_id = $_POST['ejercicio_id'];
    $respuesta_usuario = $_POST['respuesta'];
    
    // Obtener respuesta correcta
    $stmt = $pdo->prepare("SELECT respuesta_correcta, puntos FROM Ejercicio WHERE id = ?");
    $stmt->execute([$ejercicio_id]);
    $ejercicio = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $correcto = (strtolower(trim($respuesta_usuario)) === strtolower(trim($ejercicio['respuesta_correcta'])));
    
    // Actualizar progreso
    $stmt = $pdo->prepare("UPDATE Progreso SET ejercicios_completados = ejercicios_completados + 1, ejercicios_correctos = ejercicios_correctos + ?, puntos_acumulados = puntos_acumulados + ?, ultima_actividad = NOW() WHERE estudiante_id = ?");
    $puntos_ganados = $correcto ? $ejercicio['puntos'] : 0;
    $correctos_incremento = $correcto ? 1 : 0;
    $stmt->execute([$correctos_incremento, $puntos_ganados, $estudiante_id]);
    
    // Actualizar porcentaje
    $stmt = $pdo->prepare("UPDATE Progreso SET porcentaje = (ejercicios_correctos * 100.0 / ejercicios_completados) WHERE estudiante_id = ? AND ejercicios_completados > 0");
    $stmt->execute([$estudiante_id]);
    
    $puntos_texto = $correcto ? " (+{$ejercicio['puntos']} points)" : "";
    $mensaje = $correcto ? "¡Correct! 🎉{$puntos_texto}" : "Incorrect. The answer was: " . $ejercicio['respuesta_correcta'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎯 English Exercises - Learning System</title>
    <link rel="stylesheet" href="styles_kids.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎯 English Practice Exercises</h1>
            <p>Ejercicios de Práctica de Inglés</p>
        </div>
        
        <nav class="nav-menu">
            <a href="dashboard_alumno.php" class="nav-btn exercises">
                <span>←</span>
                <span>Volver / Back to Dashboard</span>
            </a>
        </nav>
        
        <?php if (isset($mensaje)): ?>
            <div class="progress-section <?php echo $correcto ? 'sparkle' : ''; ?>" style="background: <?php echo $correcto ? 'linear-gradient(45deg, #00B894, #00CEC9)' : 'linear-gradient(45deg, #FF6B6B, #FD79A8)'; ?>; color: white; margin-bottom: 20px;">
                <h2><?php echo $mensaje; ?></h2>
            </div>
        <?php endif; ?>
        
        <div class="cards-grid">
            <?php foreach($ejercicios as $ejercicio): ?>
                <div class="card bounce">
                    <span class="card-icon">🎲</span>
                    <h3><?php echo $ejercicio['titulo']; ?></h3>
                    <p><strong>Type:</strong> <?php echo ucfirst($ejercicio['tipo']); ?> | <strong>Level:</strong> <?php echo $ejercicio['nivel']; ?></p>
                    <div style="background: #FFE066; padding: 10px; border-radius: 15px; margin: 15px 0; font-weight: bold; color: #2C3E50;">
                        🏆 <?php echo $ejercicio['puntos']; ?> Points / Puntos
                    </div>
                    <p class="pregunta" style="font-size: 1.2rem; font-weight: bold; color: #2C3E50; margin: 15px 0;"><?php echo $ejercicio['contenido']; ?></p>
                    
                    <form method="POST" style="margin-top: 20px;">
                        <input type="hidden" name="ejercicio_id" value="<?php echo $ejercicio['id']; ?>">
                        <input type="text" name="respuesta" placeholder="Your answer... / Tu respuesta..." required style="width: 100%; padding: 15px; border: 3px solid #4ECDC4; border-radius: 25px; font-size: 1.1rem; margin-bottom: 15px; text-align: center;">
                        <button type="submit" class="big-btn start">Submit Answer / Enviar Respuesta</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>