<?php
// Datos ya disponibles desde el controlador: $estudiantes_progreso, $evaluaciones_recientes, $estadisticas
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Ver Resultados</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .results-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }
        .results-table {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            margin: 20px 0;
            overflow-x: auto;
        }
        .progress-bar {
            background: #e0e0e0;
            border-radius: 10px;
            height: 20px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(45deg, #4ECDC4, #45B7D1);
            transition: width 0.3s ease;
        }
        .level-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }
        .level-beginner { background: #FFE066; color: #333; }
        .level-elementary { background: #4ECDC4; }
        .level-intermediate { background: #FF6B6B; }
        .level-advanced { background: #6C5CE7; }
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .filter-group {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        .filter-group select {
            padding: 8px 12px;
            border: 2px solid #4ECDC4;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="results-container">
        <div class="header bounce fade-in">
            <h1>📊 Resultados y Análisis</h1>
            <p>Monitorea el progreso y rendimiento de tus estudiantes</p>
        </div>

        <nav class="nav-menu">
            <a href="/englishdemo/?controller=teacher&action=dashboard" class="nav-btn exercises">
                <span>←</span>
                <span>Volver al Dashboard</span>
            </a>
        </nav>

        <!-- Estadísticas Generales -->
        <div class="stats-overview">
            <div class="stat-card">
                <div>👥</div>
                <div class="stat-number"><?php echo $estadisticas['total_estudiantes'] ?? 0; ?></div>
                <div>Estudiantes Activos</div>
            </div>
            <div class="stat-card">
                <div>📈</div>
                <div class="stat-number"><?php echo number_format($estadisticas['promedio_progreso'] ?? 0, 2); ?>%</div>
                <div>Progreso Promedio</div>
            </div>
            <div class="stat-card">
                <div>🏆</div>
                <div class="stat-number"><?php echo $estadisticas['total_puntos'] ?? 0; ?></div>
                <div>Puntos Totales</div>
            </div>
            <div class="stat-card">
                <div>🎯</div>
                <div class="stat-number"><?php echo $estadisticas['ejercicios_completados'] ?? 0; ?></div>
                <div>Ejercicios Completados</div>
            </div>
        </div>

        <!-- Información General -->
        <div class="filter-section">
            <h3>📊 Resumen General</h3>
            <p>Mostrando todos los estudiantes y su progreso actual en el sistema</p>
        </div>

        <!-- Progreso de Estudiantes -->
        <div class="results-table">
            <h3>👥 Progreso Individual de Estudiantes</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: linear-gradient(45deg, #4ECDC4, #45B7D1); color: white;">
                        <th style="padding: 12px; text-align: left;">Estudiante</th>
                        <th style="padding: 12px; text-align: left;">Grado</th>
                        <th style="padding: 12px; text-align: left;">Nivel</th>
                        <th style="padding: 12px; text-align: left;">Progreso</th>
                        <th style="padding: 12px; text-align: left;">Ejercicios</th>
                        <th style="padding: 12px; text-align: left;">Puntos</th>
                        <th style="padding: 12px; text-align: left;">Racha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($estudiantes_progreso)): foreach($estudiantes_progreso as $estudiante): ?>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <strong><?php echo $estudiante['nombre'] ?? 'Estudiante ' . $estudiante['id']; ?></strong>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <?php echo $estudiante['grado'] ?? 'N/A'; ?>°
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <span class="level-badge level-<?php echo strtolower($estudiante['nivel_actual'] ?? 'beginner'); ?>">
                                    <?php echo $estudiante['nivel_actual'] ?? 'Beginner'; ?>
                                </span>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $estudiante['porcentaje'] ?? 0; ?>%"></div>
                                </div>
                                <small><?php echo $estudiante['porcentaje'] ?? 0; ?>%</small>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <?php echo $estudiante['ejercicios_completados'] ?? 0; ?> / <?php echo $estudiante['ejercicios_correctos'] ?? 0; ?>
                                <small style="color: #666;">(correctos)</small>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <strong style="color: #4ECDC4;"><?php echo $estudiante['puntos_acumulados'] ?? 0; ?></strong>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                🔥 <?php echo $estudiante['racha_dias'] ?? 0; ?> días
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="7" style="padding: 20px; text-align: center; color: #666;">
                                No hay datos de progreso disponibles
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <!-- Paginación -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination" style="text-align: center; margin-top: 20px;">
                    <?php if ($current_page > 1): ?>
                        <a href="?controller=teacher&action=results&page=<?php echo $current_page - 1; ?>" class="btn" style="background: linear-gradient(45deg, #4ECDC4, #45B7D1); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; margin: 0 5px;">← Anterior</a>
                    <?php endif; ?>
                    
                    <span style="margin: 0 15px; font-weight: bold;">Página <?php echo $current_page; ?> de <?php echo $total_pages; ?></span>
                    
                    <?php if ($current_page < $total_pages): ?>
                        <a href="?controller=teacher&action=results&page=<?php echo $current_page + 1; ?>" class="btn" style="background: linear-gradient(45deg, #4ECDC4, #45B7D1); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; margin: 0 5px;">Siguiente →</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Evaluaciones Recientes -->
        <div class="results-table">
            <h3>📋 Evaluaciones Recientes</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: linear-gradient(45deg, #FF6B6B, #FD79A8); color: white;">
                        <th style="padding: 12px; text-align: left;">Evaluación</th>
                        <th style="padding: 12px; text-align: left;">Estudiante</th>
                        <th style="padding: 12px; text-align: left;">Resultado</th>
                        <th style="padding: 12px; text-align: left;">Fecha</th>
                        <th style="padding: 12px; text-align: left;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($evaluaciones_recientes)): foreach($evaluaciones_recientes as $evaluacion): ?>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <strong><?php echo $evaluacion['titulo'] ?? 'Evaluación'; ?></strong>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <?php echo $evaluacion['estudiante_nombre'] ?? 'N/A'; ?>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <strong style="color: <?php echo ($evaluacion['resultado'] ?? 0) >= 70 ? '#00B894' : '#FF6B6B'; ?>">
                                    <?php echo $evaluacion['resultado'] ?? 0; ?>%
                                </strong>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <?php echo $evaluacion['fecha'] ?? 'N/A'; ?>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <?php 
                                $resultado = $evaluacion['resultado'] ?? 0;
                                if ($resultado >= 90) echo '<span style="color: #00B894;">🏆 Excelente</span>';
                                elseif ($resultado >= 70) echo '<span style="color: #4ECDC4;">✅ Aprobado</span>';
                                else echo '<span style="color: #FF6B6B;">❌ Necesita mejorar</span>';
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" style="padding: 20px; text-align: center; color: #666;">
                                No hay evaluaciones recientes
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <!-- Paginación para Evaluaciones -->
            <?php if ($total_pages2 > 1): ?>
                <div class="pagination" style="text-align: center; margin-top: 20px;">
                    <?php if ($current_page2 > 1): ?>
                        <a href="?controller=teacher&action=results&page=<?php echo $current_page; ?>&page2=<?php echo $current_page2 - 1; ?>" class="btn" style="background: linear-gradient(45deg, #FF6B6B, #FD79A8); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; margin: 0 5px;">← Anterior</a>
                    <?php endif; ?>
                    
                    <span style="margin: 0 15px; font-weight: bold;">Página <?php echo $current_page2; ?> de <?php echo $total_pages2; ?></span>
                    
                    <?php if ($current_page2 < $total_pages2): ?>
                        <a href="?controller=teacher&action=results&page=<?php echo $current_page; ?>&page2=<?php echo $current_page2 + 1; ?>" class="btn" style="background: linear-gradient(45deg, #FF6B6B, #FD79A8); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; margin: 0 5px;">Siguiente →</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>