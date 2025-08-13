<?php
// Datos ya disponibles desde el controlador: $total_estudiantes, $total_evaluaciones, $total_ejercicios, $estudiantes
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👩‍🏫 Panel del Docente</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        body {
            background: #e0f2f1 !important;
            animation: none !important;
        }
    </style>
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
            transition: all 0.3s ease;
        }
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        .dashboard-header {
            background: linear-gradient(135deg, #4ECDC4, #45B7D1);
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
        .dashboard-header p {
            font-size: 1.2rem;
            margin: 0 0 20px 0;
            opacity: 0.9;
        }
        .stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        .stats span {
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 15px;
            font-weight: bold;
            backdrop-filter: blur(10px);
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
            text-align: center;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card.wide {
            grid-column: 1 / -1;
            text-align: left;
        }
        .estudiante-item {
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
        .btn {
            background: linear-gradient(45deg, #4ECDC4, #45B7D1);
            color: white;
            padding: 12px 25px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 15px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
    </style>
    </style>
    <style>
        .logo-corner {
            position: fixed;
            top: 20px;
            left: 20px;
            background: linear-gradient(45deg, #4ECDC4, #45B7D1);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body class="dashboard docente-theme">
    <div class="logo-corner">📚 Learning English</div>
    <a href="/englishdemo/?controller=auth&action=logout" class="logout-btn">🚪 Salir</a>
    
    <div class="dashboard-header">
        <h1>👩‍🏫 Panel del Profesor</h1>
        <p>Gestiona el aprendizaje de tus estudiantes</p>
        <div class="stats">
            <span>👥 <?php echo $total_estudiantes ?? 0; ?> Estudiantes</span>
            <span>📋 <?php echo $total_evaluaciones ?? 0; ?> Evaluaciones</span>
            <span>🎯 <?php echo $total_ejercicios ?? 0; ?> Ejercicios</span>
        </div>
    </div>
    
    <div class="dashboard-content">
        <div class="card wide">
            <h3>👥 Lista de Estudiantes</h3>
            <div class="estudiantes-lista">
                <?php if(isset($estudiantes)): foreach($estudiantes as $estudiante): ?>
                    <div class="estudiante-item">
                        <strong><?php echo $estudiante['nombre'] ?? 'Sin nombre'; ?></strong>
                        <span>Grado: <?php echo $estudiante['grado']; ?></span>
                        <span>Progreso: <?php echo $estudiante['porcentaje'] ?? 0; ?>%</span>
                        <span>Nivel: <?php echo $estudiante['nivel_actual'] ?? 'Beginner'; ?></span>
                        <?php if (!empty($estudiante['grupo_nombre'])): ?>
                            <span style="background: #4ECDC4; color: white; padding: 4px 8px; border-radius: 10px; font-size: 12px;">
                                Grupo: <?php echo $estudiante['grupo_nombre']; ?>
                            </span>
                        <?php else: ?>
                            <span style="background: #FFA726; color: white; padding: 4px 8px; border-radius: 10px; font-size: 12px;">
                                Sin grupo
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; endif; ?>
            </div>
            
            <!-- Paginación -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination" style="text-align: center; margin-top: 20px;">
                    <?php if ($current_page > 1): ?>
                        <a href="?controller=teacher&action=dashboard&page=<?php echo $current_page - 1; ?>" class="btn" style="margin: 0 5px;">← Anterior</a>
                    <?php endif; ?>
                    
                    <span style="margin: 0 15px; font-weight: bold;">Página <?php echo $current_page; ?> de <?php echo $total_pages; ?></span>
                    
                    <?php if ($current_page < $total_pages): ?>
                        <a href="?controller=teacher&action=dashboard&page=<?php echo $current_page + 1; ?>" class="btn" style="margin: 0 5px;">Siguiente →</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="card">
            <h3>📝 Crear Evaluación</h3>
            <p>Crear nueva evaluación para estudiantes</p>
            <a href="/englishdemo/?controller=teacher&action=createEvaluation" class="btn">✏️ Crear</a>
        </div>
        
        <div class="card">
            <h3>🎯 Panel del Profesor</h3>
            <p>Gestionar planes, temas y progreso</p>
            <a href="/englishdemo/?controller=teacher&action=panel" class="btn">📤 Abrir Panel</a>
        </div>
        
        <div class="card">
            <h3>📊 Ver Resultados</h3>
            <p>Analizar resultados de evaluaciones</p>
            <a href="/englishdemo/?controller=teacher&action=results" class="btn">📈 Ver Resultados</a>
        </div>
        
        <div class="card">
            <h3>📝 Calificar Evaluaciones</h3>
            <p>Asignar calificaciones a evaluaciones</p>
            <a href="/englishdemo/?controller=teacher&action=calificarEvaluaciones" class="btn">✏️ Calificar</a>
        </div>
        
        <div class="card">
            <h3>📝 Ejercicios Múltiples</h3>
            <p>Crear hasta 10 ejercicios de una vez</p>
            <a href="/englishdemo/?controller=teacher&action=crearEjerciciosMultiples" class="btn">⚡ Crear Múltiples</a>
        </div>
        
        <div class="card">
            <h3>📄 Evaluación PDF</h3>
            <p>Crear evaluación con archivo PDF</p>
            <a href="/englishdemo/?controller=teacher&action=crearEvaluacionPdf" class="btn">📁 Subir PDF</a>
        </div>
    </div>
    
    <script src="/englishdemo/assets/js/teacher.js"></script>
</body>
</html>