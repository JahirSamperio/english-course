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
        }
        .dashboard-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
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
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
            justify-items: center;
        }
        .card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card.wide {
            grid-column: 1 / -1;
            max-width: none;
            width: 100%;
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
                        <?php if (!empty($hijo['grupo_nombre'])): ?>
                            <span style="background: #4ECDC4; color: white; padding: 4px 8px; border-radius: 10px; font-size: 12px;">
                                Grupo: <?php echo $hijo['grupo_nombre']; ?>
                            </span>
                        <?php else: ?>
                            <span style="background: #FFA726; color: white; padding: 4px 8px; border-radius: 10px; font-size: 12px;">
                                Sin grupo
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay hijos registrados</p>
            <?php endif; ?>
        </div>
        
        <div class="card wide">
            <h3>📋 Evaluaciones Recientes de mis Hijos</h3>
            <div class="evaluaciones-table" style="overflow-x: auto; margin-top: 15px;">
                <table style="width: 100%; min-width: 1200px; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; table-layout: fixed;">
                    <thead>
                        <tr style="background: linear-gradient(45deg, #667eea, #764ba2); color: white;">
                            <th style="padding: 18px; text-align: left; font-weight: bold; width: 25%;">📝 Evaluación</th>
                            <th style="padding: 18px; text-align: left; font-weight: bold; width: 20%;">👤 Estudiante</th>
                            <th style="padding: 18px; text-align: center; font-weight: bold; width: 20%;">📊 Resultado</th>
                            <th style="padding: 18px; text-align: center; font-weight: bold; width: 15%;">📅 Fecha</th>
                            <th style="padding: 18px; text-align: center; font-weight: bold; width: 20%;">🏆 Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($evaluaciones_hijos) && $evaluaciones_hijos): ?>
                            <?php foreach($evaluaciones_hijos as $eval): ?>
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td style="padding: 18px; vertical-align: middle;">
                                        <strong style="color: #2d3436; font-size: 15px; display: block; margin-bottom: 4px;"><?php echo $eval['titulo'] ?? 'Evaluación'; ?></strong>
                                        <small style="color: #636e72; font-size: 12px;">Evaluación académica</small>
                                    </td>
                                    <td style="padding: 18px; vertical-align: middle;">
                                        <span style="color: #2d3436; font-weight: 600; font-size: 15px;"><?php echo $eval['estudiante_nombre'] ?? 'N/A'; ?></span>
                                    </td>
                                    <td style="padding: 18px; text-align: center; vertical-align: middle;">
                                        <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                            <div style="background: #e0e0e0; border-radius: 10px; height: 10px; width: 80px; overflow: hidden;">
                                                <div style="height: 100%; background: <?php echo ($eval['resultado'] ?? 0) >= 70 ? 'linear-gradient(45deg, #00b894, #00cec9)' : 'linear-gradient(45deg, #ff6b6b, #fd79a8)'; ?>; width: <?php echo min(100, $eval['resultado'] ?? 0); ?>%;"></div>
                                            </div>
                                            <strong style="color: <?php echo ($eval['resultado'] ?? 0) >= 70 ? '#00b894' : '#ff6b6b'; ?>; font-size: 16px;">
                                                <?php echo $eval['resultado'] ?? 0; ?>%
                                            </strong>
                                        </div>
                                    </td>
                                    <td style="padding: 18px; text-align: center; vertical-align: middle;">
                                        <span style="color: #2d3436; font-weight: 600; font-size: 14px;"><?php echo date('d/m/Y', strtotime($eval['fecha'] ?? 'now')); ?></span>
                                    </td>
                                    <td style="padding: 18px; text-align: center; vertical-align: middle;">
                                        <?php 
                                        $resultado = $eval['resultado'] ?? 0;
                                        if ($resultado >= 90) {
                                            echo '<span style="background: linear-gradient(45deg, #00b894, #00cec9); color: white; padding: 6px 12px; border-radius: 15px; font-size: 12px; font-weight: bold;">🏆 Excelente</span>';
                                        } elseif ($resultado >= 70) {
                                            echo '<span style="background: linear-gradient(45deg, #4ECDC4, #45B7D1); color: white; padding: 6px 12px; border-radius: 15px; font-size: 12px; font-weight: bold;">✅ Aprobado</span>';
                                        } else {
                                            echo '<span style="background: linear-gradient(45deg, #ff6b6b, #fd79a8); color: white; padding: 6px 12px; border-radius: 15px; font-size: 12px; font-weight: bold;">📚 Mejorar</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="padding: 30px; text-align: center; color: #636e72; font-style: italic;">
                                    📝 No hay evaluaciones recientes disponibles
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                
                <!-- Paginación -->
                <?php if (isset($total_pages) && $total_pages > 1): ?>
                    <div class="pagination" style="text-align: center; margin-top: 20px;">
                        <?php if ($current_page > 1): ?>
                            <a href="?page=<?php echo $current_page - 1; ?>" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; margin: 0 5px; font-weight: bold;">← Anterior</a>
                        <?php endif; ?>
                        
                        <span style="margin: 0 15px; font-weight: bold; color: #2d3436;">Página <?php echo $current_page; ?> de <?php echo $total_pages; ?></span>
                        
                        <?php if ($current_page < $total_pages): ?>
                            <a href="?page=<?php echo $current_page + 1; ?>" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; margin: 0 5px; font-weight: bold;">Siguiente →</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card" style="grid-column: 1; max-width: none; width: 100%;">
            <h3 style="color: #2d3436; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                📈 <span>Resumen de Progreso</span>
            </h3>
            <div style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); padding: 20px; border-radius: 15px; margin-bottom: 15px;">
                <p style="color: #636e72; margin-bottom: 15px; font-weight: 500;">Seguimiento del avance académico de tus hijos</p>
                <?php if($hijos): ?>
                    <?php 
                    $total_progreso = array_sum(array_column($hijos, 'porcentaje'));
                    $promedio = count($hijos) > 0 ? $total_progreso / count($hijos) : 0;
                    ?>
                    <div style="display: flex; align-items: center; gap: 15px; margin-top: 10px;">
                        <div style="background: #e0e0e0; border-radius: 10px; height: 12px; flex: 1; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(45deg, #667eea, #764ba2); width: <?php echo min(100, $promedio); ?>%;"></div>
                        </div>
                        <strong style="color: #2d3436; font-size: 18px; min-width: 60px;"><?php echo number_format($promedio, 1); ?>%</strong>
                    </div>
                    <small style="color: #636e72; margin-top: 5px; display: block;">Promedio general de <?php echo count($hijos); ?> hijo(s)</small>
                <?php else: ?>
                    <p style="color: #636e72; font-style: italic;">No hay datos de progreso disponibles</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card" style="grid-column: 2; max-width: none; width: 100%;">
            <h3 style="color: #2d3436; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                🎯 <span>Recomendaciones</span>
            </h3>
            <div style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); padding: 20px; border-radius: 15px;">
                <p style="color: #636e72; margin-bottom: 15px; font-weight: 500;">Actividades sugeridas para reforzar el aprendizaje en casa</p>
                <div style="display: grid; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <span style="background: linear-gradient(45deg, #4ECDC4, #45B7D1); color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px;">📚</span>
                        <span style="color: #2d3436; font-weight: 500;">Practicar ejercicios de inglés diariamente</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <span style="background: linear-gradient(45deg, #96CEB4, #FFEAA7); color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px;">🎧</span>
                        <span style="color: #2d3436; font-weight: 500;">Escuchar audio en inglés 15 minutos</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <span style="background: linear-gradient(45deg, #FF6B6B, #FD79A8); color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px;">📖</span>
                        <span style="color: #2d3436; font-weight: 500;">Lectura en inglés antes de dormir</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="/englishdemo/assets/js/script.js"></script>
</body>
</html>