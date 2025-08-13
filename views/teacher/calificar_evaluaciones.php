<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 Calificar Evaluaciones</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .evaluaciones-table {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        table {
            width: 100%;
            min-width: 1000px;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }
        th {
            background: linear-gradient(45deg, #4ECDC4, #45B7D1);
            color: white;
            font-weight: bold;
        }
        .calificacion-input {
            width: 80px;
            padding: 8px;
            border: 2px solid #4ECDC4;
            border-radius: 8px;
            text-align: center;
        }
        .btn-calificar {
            background: linear-gradient(45deg, #00B894, #00CEC9);
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-calificar:hover {
            transform: translateY(-2px);
        }
        .estado {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .estado.pendiente {
            background: #FFA726;
            color: white;
        }
        .estado.calificada {
            background: #4ECDC4;
            color: white;
        }
        .notification {
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-weight: bold;
            text-align: center;
        }
        .notification.success {
            background: linear-gradient(45deg, #00B894, #00CEC9);
            color: white;
        }
        .notification.error {
            background: linear-gradient(45deg, #FF6B6B, #FD79A8);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📝 Calificar Evaluaciones</h1>
            <p>Asignar calificaciones a evaluaciones pendientes</p>
            <a href="?controller=teacher&action=dashboard" class="btn-back">← Volver al Dashboard</a>
        </div>

        <?php if (isset($_SESSION['notification'])): ?>
            <div class="notification <?php echo $_SESSION['notification']['type']; ?>">
                <?php echo $_SESSION['notification']['message']; ?>
            </div>
            <?php unset($_SESSION['notification']); ?>
        <?php endif; ?>

        <div class="evaluaciones-table">
            <h3>📋 Evaluaciones por Calificar</h3>
            
            <?php if (empty($evaluaciones)): ?>
                <p style="text-align: center; color: #666; padding: 40px;">
                    ✅ No hay evaluaciones pendientes de calificar
                </p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>📝 Evaluación</th>
                            <th>👤 Estudiante</th>
                            <th>📅 Fecha</th>
                            <th>⏱️ Tiempo Límite</th>
                            <th>🎯 Puntos Total</th>
                            <th>📊 Calificación</th>
                            <th>🏆 Estado</th>
                            <th>⚡ Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($evaluaciones as $eval): ?>
                            <tr>
                                <td>
                                    <strong><?php echo $eval['titulo']; ?></strong>
                                    <?php if ($eval['descripcion']): ?>
                                        <br><small style="color: #666;"><?php echo substr($eval['descripcion'], 0, 50); ?>...</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo $eval['estudiante_nombre'] ?? 'Sin asignar'; ?>
                                </td>
                                <td>
                                    <?php echo date('d/m/Y', strtotime($eval['fecha'])); ?>
                                </td>
                                <td>
                                    <?php echo $eval['tiempo_limite']; ?> min
                                </td>
                                <td>
                                    <?php echo $eval['puntos_total']; ?> pts
                                </td>
                                <td>
                                    <form method="POST" action="?controller=teacher&action=guardarCalificacion" style="display: inline;">
                                        <input type="hidden" name="evaluacion_id" value="<?php echo $eval['id']; ?>">
                                        <input type="number" 
                                               name="calificacion" 
                                               class="calificacion-input" 
                                               min="0" 
                                               max="100" 
                                               step="0.1"
                                               value="<?php echo $eval['resultado'] ?? ''; ?>"
                                               placeholder="0-100">
                                </td>
                                <td>
                                    <?php if ($eval['resultado'] !== null): ?>
                                        <span class="estado calificada">✅ Calificada</span>
                                    <?php else: ?>
                                        <span class="estado pendiente">⏳ Pendiente</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                        <button type="submit" class="btn-calificar">
                                            💾 Guardar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Paginación -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination" style="text-align: center; margin-top: 20px;">
                        <?php if ($current_page > 1): ?>
                            <a href="?controller=teacher&action=calificarEvaluaciones&page=<?php echo $current_page - 1; ?>" 
                               style="background: #4ECDC4; color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; margin: 0 5px;">
                                ← Anterior
                            </a>
                        <?php endif; ?>
                        
                        <span style="margin: 0 15px; font-weight: bold;">
                            Página <?php echo $current_page; ?> de <?php echo $total_pages; ?>
                        </span>
                        
                        <?php if ($current_page < $total_pages): ?>
                            <a href="?controller=teacher&action=calificarEvaluaciones&page=<?php echo $current_page + 1; ?>" 
                               style="background: #4ECDC4; color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; margin: 0 5px;">
                                Siguiente →
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>