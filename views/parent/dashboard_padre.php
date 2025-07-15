<?php
// Datos ya disponibles desde el controlador: $hijos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👨‍👩‍👧‍👦 Panel de Padres</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .logout-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(45deg, #FF6B6B, #FD79A8);
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .dashboard-header {
            background: linear-gradient(135deg, #96CEB4, #FFEAA7);
            color: white;
            padding: 40px 20px;
            text-align: center;
            border-radius: 20px;
            margin: 20px auto;
            max-width: 1200px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .dashboard-header h1 {
            font-size: 2.5rem;
            margin: 0 0 10px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .dashboard-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card.wide {
            grid-column: 1 / -1;
        }
        .hijo-item, .evaluacion-item {
            background: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
    </style>
    
</head>
<body class="dashboard padre-theme">
    <a href="/englishdemo/?controller=auth&action=logout" class="logout-btn">🚪 Salir</a>
    
    <div class="dashboard-header">
        <h1>👨‍👩‍👧‍👦 Hola <?php echo $_SESSION['nombre'] ?? 'Padre/Madre'; ?></h1>
        <p>Acompaña el aprendizaje de tu hijo/a</p>
    </div>
    
    <div class="dashboard-content">
        <div class="card wide">
            <h3>👥 Mis Hijos</h3>
            <?php if($hijos): ?>
                <?php foreach($hijos as $hijo): ?>
                    <div class="hijo-item">
                        <strong><?php echo $hijo['nombre'] ?? 'Estudiante'; ?></strong>
                        <span>Grado: <?php echo $hijo['grado'] ?? 'No asignado'; ?></span>
                        <span>Progreso: <?php echo $hijo['porcentaje'] ?? 0; ?>%</span>
                        <span>Nivel: <?php echo $hijo['nivel_actual'] ?? 'Principiante'; ?></span>
                        <span>Ejercicios: <?php echo $hijo['ejercicios_completados'] ?? 0; ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay hijos registrados</p>
            <?php endif; ?>
        </div>
        
        <div class="card">
            <h3>📋 Evaluaciones Recientes</h3>
            <?php if(isset($evaluaciones_hijos) && $evaluaciones_hijos): ?>
                <?php foreach($evaluaciones_hijos as $eval): ?>
                    <div class="evaluacion-item">
                        <strong><?php echo $eval['titulo']; ?></strong>
                        <span>Resultado: <?php echo $eval['resultado']; ?></span>
                        <small><?php echo $eval['fecha']; ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay evaluaciones recientes</p>
            <?php endif; ?>
        </div>
        
        <div class="card">
            <h3>📈 Resumen de Progreso</h3>
            <p>Seguimiento del avance académico</p>
            <?php if($hijos): ?>
                <p>Promedio general: <?php 
                    $total_progreso = array_sum(array_column($hijos, 'porcentaje'));
                    $promedio = count($hijos) > 0 ? $total_progreso / count($hijos) : 0;
                    echo number_format($promedio, 2);
                ?>%</p>
            <?php endif; ?>
        </div>
        
        <div class="card">
            <h3>🎯 Recomendaciones</h3>
            <p>Actividades sugeridas para casa</p>
            <ul>
                <li>Practicar ejercicios de matemáticas</li>
                <li>Repasar temas de ciencias</li>
                <li>Lectura diaria 15 minutos</li>
            </ul>
        </div>
    </div>
    
    <script src="/englishdemo/assets/js/script.js"></script>
</body>
</html>