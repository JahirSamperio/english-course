<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👥 Gestionar Grupos</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .table-container { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: linear-gradient(45deg, #4ECDC4, #45B7D1); color: white; }
        .btn { padding: 8px 15px; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; display: inline-block; margin: 2px; }
        .btn-edit { background: #FFA726; color: white; }
        .btn-delete { background: #FF6B6B; color: white; }
        .level-badge { padding: 4px 8px; border-radius: 10px; color: white; font-size: 12px; }
        .level-beginner { background: #4ECDC4; }
        .level-intermediate { background: #FFA726; }
        .level-advanced { background: #FF6B6B; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header bounce fade-in">
            <h1>👥 Gestionar Grupos</h1>
            <p>Administra los grupos de estudiantes</p>
        </div>

        <nav class="nav-menu">
            <a href="/englishdemo/?controller=teacher&action=panel" class="nav-btn">
                <span>←</span>
                <span>Volver al Panel</span>
            </a>
        </nav>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Nivel</th>
                        <th>Profesor</th>
                        <th>Estudiantes</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($grupos) && !empty($grupos)): ?>
                        <?php foreach($grupos as $grupo): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($grupo['nombre']); ?></strong></td>
                                <td>
                                    <span class="level-badge level-<?php echo strtolower($grupo['nivel']); ?>">
                                        <?php echo $grupo['nivel']; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($grupo['profesor_nombre'] ?? 'Sin asignar'); ?></td>
                                <td><?php echo $grupo['total_estudiantes']; ?> estudiantes</td>
                                <td><?php echo date('d/m/Y', strtotime($grupo['fecha_creacion'])); ?></td>
                                <td>
                                    <a href="/englishdemo/?controller=teacher&action=editGroup&id=<?php echo $grupo['id']; ?>" class="btn btn-edit">✏️ Editar</a>
                                    <a href="/englishdemo/?controller=teacher&action=deleteGroup&id=<?php echo $grupo['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Eliminar grupo?')">🗑️ Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #666; padding: 40px;">
                                No hay grupos creados
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Paginación -->
            <?php if (isset($total_pages) && $total_pages > 1): ?>
                <div class="pagination" style="text-align: center; margin-top: 20px;">
                    <?php if ($current_page > 1): ?>
                        <a href="?controller=teacher&action=manageGroups&page=<?php echo $current_page - 1; ?>" class="btn btn-edit">← Anterior</a>
                    <?php endif; ?>
                    
                    <span style="margin: 0 15px; font-weight: bold;">Página <?php echo $current_page; ?> de <?php echo $total_pages; ?></span>
                    
                    <?php if ($current_page < $total_pages): ?>
                        <a href="?controller=teacher&action=manageGroups&page=<?php echo $current_page + 1; ?>" class="btn btn-edit">Siguiente →</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>