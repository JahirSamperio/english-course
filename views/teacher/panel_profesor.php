<?php
// Datos ya disponibles desde el controlador: $planes, $estudiantes, $temas, $asignaciones
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎯 Panel del Profesor</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .panel-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .panel-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 20px 0;
        }
        @media (max-width: 1024px) {
            .panel-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .panel-grid {
                grid-template-columns: 1fr;
            }
        }
        .panel-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            height: fit-content;
            display: flex;
            flex-direction: column;
        }
        .panel-card h3 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #4ECDC4;
            border-radius: 8px;
        }
        .btn-submit {
            background: linear-gradient(45deg, #4ECDC4, #45B7D1);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: auto;
            text-align: center;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.3);
        }
        .student-list {
            max-height: 200px;
            overflow-y: auto;
            border: 2px solid #4ECDC4;
            border-radius: 10px;
            padding: 10px;
        }
        .student-item {
            display: flex;
            align-items: center;
            margin: 5px 0;
        }
        .student-item input {
            margin-right: 10px;
            width: auto;
        }
        .notification {
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-weight: bold;
            text-align: center;
            animation: slideIn 0.5s ease;
        }
        .notification.success {
            background: linear-gradient(45deg, #00B894, #00CEC9);
            color: white;
        }
        .notification.error {
            background: linear-gradient(45deg, #FF6B6B, #FD79A8);
            color: white;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="panel-container">
        <div class="header bounce fade-in">
            <h1>🎯 Panel de Control del Profesor</h1>
            <p>Gestiona planes de estudio, temas y asignaciones</p>
        </div>
        
        <?php if (isset($_SESSION['notification'])): ?>
            <div class="notification <?php echo $_SESSION['notification']['type']; ?>" id="notification">
                <?php echo $_SESSION['notification']['message']; ?>
            </div>
            <?php unset($_SESSION['notification']); ?>
        <?php endif; ?>

        <nav class="nav-menu">
            <a href="/englishdemo/?controller=teacher&action=dashboard" class="nav-btn exercises">
                <span>←</span>
                <span>Volver al Dashboard</span>
            </a>
        </nav>

        <div class="panel-grid">
            <!-- Crear Grupo -->
            <div class="panel-card">
                <h3>👥 Crear Grupo</h3>
                <form method="POST" action="/englishdemo/?controller=teacher&action=createGroup">
                    <div class="form-group">
                        <label>Nombre del Grupo:</label>
                        <input type="text" name="nombre" required placeholder="Ej: Beginners A1">
                    </div>
                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea name="descripcion" placeholder="Describe el grupo"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nivel:</label>
                        <select name="nivel" required>
                            <option value="Beginner">Beginner</option>
                            <option value="Elementary">Elementary</option>
                            <option value="Intermediate">Intermediate
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-submit">✅ Crear Grupo</button>
                </form>
                <a href="/englishdemo/?controller=teacher&action=manageGroups" class="btn-submit" style="display: block; text-decoration: none; margin-top: 10px; background: linear-gradient(45deg, #FF6B6B, #FD79A8);">
                    📋 Gestionar Grupos
                </a>
            </div>

            <!-- Crear Plan de Estudios -->
            <div class="panel-card">
                <h3>📚 Crear Plan de Estudios</h3>
                <form method="POST" action="/englishdemo/?controller=teacher&action=createPlan">
                    <div class="form-group">
                        <label>Título:</label>
                        <input type="text" name="titulo" required placeholder="Ej: English Basics">
                    </div>
                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea name="descripcion" placeholder="Describe el plan de estudios"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nivel:</label>
                        <select name="nivel" required>
                            <option value="Beginner">Beginner</option>
                            <option value="Elementary">Elementary</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Duración (semanas):</label>
                        <input type="number" name="duracion_semanas" min="1" max="52" value="8">
                    </div>
                    <button type="submit" class="btn-submit">✅ Crear Plan</button>
                </form>
                <a href="/englishdemo/?controller=teacher&action=managePlans" class="btn-submit" style="display: block; text-decoration: none; margin-top: 10px; background: linear-gradient(45deg, #FF6B6B, #FD79A8);">
                    📋 Gestionar Planes
                </a>
            </div>

            <!-- Crear Tema -->
            <div class="panel-card">
                <h3>📖 Crear Tema</h3>
                <form method="POST" action="/englishdemo/?controller=teacher&action=createTopic">
                    <div class="form-group">
                        <label>Nombre del Tema:</label>
                        <input type="text" name="nombre" required placeholder="Ej: Present Simple">
                    </div>
                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea name="descripcion" placeholder="Describe el tema"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nivel Requerido:</label>
                        <select name="nivel_requerido" required>
                            <option value="Beginner">Beginner</option>
                            <option value="Elementary">Elementary</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Duración Estimada (min):</label>
                        <input type="number" name="duracion_estimada" min="5" max="180" value="30">
                    </div>
                    <div class="form-group">
                        <label>Plan de Estudios (opcional):</label>
                        <select name="plan_id">
                            <option value="">Sin plan asignado</option>
                            <?php if(isset($planes)): foreach($planes as $plan): ?>
                                <option value="<?php echo $plan['id']; ?>">
                                    <?php echo $plan['titulo']; ?> (<?php echo $plan['nivel']; ?>)
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-submit">✅ Crear Tema</button>
                </form>
                <a href="/englishdemo/?controller=teacher&action=manageTopics" class="btn-submit" style="display: block; text-decoration: none; margin-top: 10px; background: linear-gradient(45deg, #FF6B6B, #FD79A8);">
                    📋 Gestionar Temas
                </a>
            </div>

            <!-- Crear Ejercicio -->
            <div class="panel-card">
                <h3>🎯 Crear Ejercicio</h3>
                <p style="text-align: center; color: #666; margin-bottom: 20px;">Diseña ejercicios interactivos para los estudiantes</p>
                <a href="/englishdemo/?controller=teacher&action=createExercise" class="btn-submit" style="display: block; text-decoration: none; margin-top: auto;">
                    📝 Crear Ejercicio
                </a>
                <a href="/englishdemo/?controller=teacher&action=manageExercises" class="btn-submit" style="display: block; text-decoration: none; margin-top: 10px; background: linear-gradient(45deg, #FF6B6B, #FD79A8);">
                    📋 Gestionar Ejercicios
                </a>
            </div>

            <!-- Asignar Estudiantes a Grupo -->
            <div class="panel-card">
                <h3>👥 Asignar Estudiantes a Grupo</h3>
                <form method="POST" action="/englishdemo/?controller=teacher&action=assignToGroup">
                    <div class="form-group">
                        <label>Seleccionar Grupo:</label>
                        <select name="grupo_id" required>
                            <?php if(isset($grupos)): foreach($grupos as $grupo): ?>
                                <option value="<?php echo $grupo['id']; ?>">
                                    <?php echo $grupo['nombre']; ?> (<?php echo $grupo['nivel']; ?>)
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Seleccionar Estudiantes:</label>
                        <div class="student-list">
                            <?php if(isset($estudiantes)): foreach($estudiantes as $estudiante): ?>
                                <div class="student-item">
                                    <input type="checkbox" name="estudiantes[]" value="<?php echo $estudiante['id']; ?>">
                                    <span>
                                        <strong><?php echo $estudiante['nombre'] ?? 'Sin nombre'; ?></strong> - 
                                        Grado: <?php echo $estudiante['grado']; ?> - 
                                        Nivel: <?php echo $estudiante['nivel_actual'] ?? 'Beginner'; ?>
                                        <?php if (!empty($estudiante['grupo_nombre'])): ?>
                                            - <span style="color: #4ECDC4; font-weight: bold;">Grupo: <?php echo $estudiante['grupo_nombre']; ?></span>
                                        <?php else: ?>
                                            - <span style="color: #FFA726;">Sin grupo</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">👥 Asignar a Grupo</button>
                </form>
            </div>

            <!-- Crear Estudiante Completo -->
            <div class="panel-card">
                <h3>👤 Crear Estudiante</h3>
                <p style="text-align: center; color: #666; margin-bottom: 20px;">Registro completo con información del padre/tutor</p>
                <a href="/englishdemo/?controller=teacher&action=crearEstudianteCompleto" class="btn-submit" style="display: block; text-decoration: none; margin-top: auto;">
                    👨‍👩‍👧‍👦 Crear Estudiante y Padre
                </a>
            </div>
            


            <!-- Asignar Evaluación a Grupo -->
            <div class="panel-card">
                <h3>📝 Asignar Evaluación a Grupo</h3>
                <form method="POST" action="/englishdemo/?controller=teacher&action=assignEvaluationToGroup">
                    <div class="form-group">
                        <label>Seleccionar Evaluación:</label>
                        <select name="evaluacion_id" required>
                            <option value="">Seleccionar evaluación...</option>
                            <?php if(isset($evaluaciones)): foreach($evaluaciones as $eval): ?>
                                <option value="<?php echo $eval['id']; ?>">
                                    <?php echo $eval['titulo']; ?> - <?php echo $eval['fecha']; ?> (<?php echo $eval['puntos_total']; ?>pts)
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Grupo:</label>
                        <select name="grupo_id" required>
                            <option value="">Seleccionar grupo...</option>
                            <?php if(isset($grupos)): foreach($grupos as $grupo): ?>
                                <option value="<?php echo $grupo['id']; ?>">
                                    <?php echo $grupo['nombre']; ?> (<?php echo $grupo['nivel']; ?>)
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-submit">📝 Asignar Evaluación</button>
                </form>
            </div>
        </div>

        <!-- Lista de Asignaciones Actuales -->
        <div class="panel-card" style="margin-top: 20px;">
            <h3>📊 Asignaciones Actuales</h3>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: linear-gradient(45deg, #4ECDC4, #45B7D1); color: white;">
                            <th style="padding: 12px; text-align: left;">Estudiante</th>
                            <th style="padding: 12px; text-align: left;">Plan</th>
                            <th style="padding: 12px; text-align: left;">Nivel</th>
                            <th style="padding: 12px; text-align: left;">Fecha Inicio</th>
                            <th style="padding: 12px; text-align: left;">Fecha Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($asignaciones)): foreach($asignaciones as $asignacion): ?>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #ddd;"><?php echo $asignacion['estudiante_nombre'] ?? 'N/A'; ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid #ddd;"><?php echo $asignacion['plan_titulo'] ?? 'N/A'; ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                    <span style="background: #4ECDC4; color: white; padding: 4px 8px; border-radius: 10px; font-size: 12px;">
                                        <?php echo $asignacion['nivel'] ?? 'N/A'; ?>
                                    </span>
                                </td>
                                <td style="padding: 12px; border-bottom: 1px solid #ddd;"><?php echo $asignacion['fecha_inicio'] ?? 'N/A'; ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid #ddd;"><?php echo $asignacion['fecha_fin_estimada'] ?? 'N/A'; ?></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr>
                                <td colspan="5" style="padding: 20px; text-align: center; color: #666;">No hay asignaciones activas</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination" style="text-align: center; margin-top: 20px;">
                    <?php if ($current_page > 1): ?>
                        <a href="?controller=teacher&action=panel&page=<?php echo $current_page - 1; ?>" class="btn-submit" style="margin: 0 5px; display: inline-block; text-decoration: none;">← Anterior</a>
                    <?php endif; ?>
                    
                    <span style="margin: 0 15px; font-weight: bold;">Página <?php echo $current_page; ?> de <?php echo $total_pages; ?></span>
                    
                    <?php if ($current_page < $total_pages): ?>
                        <a href="?controller=teacher&action=panel&page=<?php echo $current_page + 1; ?>" class="btn-submit" style="margin: 0 5px; display: inline-block; text-decoration: none;">Siguiente →</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        // Auto-hide notification after 3 seconds
        const notification = document.getElementById('notification');
        if (notification) {
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>