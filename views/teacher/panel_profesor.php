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
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .panel-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
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
        }
        .btn-submit:hover {
            transform: translateY(-2px);
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
    </style>
</head>
<body>
    <div class="panel-container">
        <div class="header bounce fade-in">
            <h1>🎯 Panel de Control del Profesor</h1>
            <p>Gestiona planes de estudio, temas y asignaciones</p>
        </div>

        <nav class="nav-menu">
            <a href="/englishdemo/?controller=teacher&action=dashboard" class="nav-btn exercises">
                <span>←</span>
                <span>Volver al Dashboard</span>
            </a>
        </nav>

        <div class="panel-grid">
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
                    <button type="submit" class="btn-submit">✅ Crear Tema</button>
                </form>
            </div>

            <!-- Asignar Plan a Estudiantes -->
            <div class="panel-card">
                <h3>👥 Asignar Plan a Estudiantes</h3>
                <form method="POST" action="/englishdemo/?controller=teacher&action=assignPlan">
                    <div class="form-group">
                        <label>Seleccionar Plan:</label>
                        <select name="plan_id" required>
                            <?php if(isset($planes)): foreach($planes as $plan): ?>
                                <option value="<?php echo $plan['id']; ?>">
                                    <?php echo $plan['titulo']; ?> (<?php echo $plan['nivel']; ?>)
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
                                    <span><?php echo $estudiante['nombre'] ?? 'Estudiante ' . $estudiante['id']; ?> (Grado: <?php echo $estudiante['grado']; ?>)</span>
                                </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">📋 Asignar Plan</button>
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
        </div>
    </div>
</body>
</html>