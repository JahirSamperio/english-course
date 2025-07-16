<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📖 Gestionar Temas</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .manage-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .topics-table {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            margin: 2px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-edit {
            background: #4ECDC4;
            color: white;
        }
        .btn-delete {
            background: #FF6B6B;
            color: white;
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
    <div class="manage-container">
        <div class="header bounce fade-in">
            <h1>📖 Gestionar Temas</h1>
            <p>Edita y elimina temas existentes</p>
        </div>
        
        <?php if (isset($_SESSION['notification'])): ?>
            <div class="notification <?php echo $_SESSION['notification']['type']; ?>" id="notification">
                <?php echo $_SESSION['notification']['message']; ?>
            </div>
            <?php unset($_SESSION['notification']); ?>
        <?php endif; ?>

        <nav class="nav-menu">
            <a href="/englishdemo/?controller=teacher&action=panel" class="nav-btn exercises">
                <span>←</span>
                <span>Volver al Panel</span>
            </a>
        </nav>

        <div class="topics-table">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: linear-gradient(45deg, #4ECDC4, #45B7D1); color: white;">
                        <th style="padding: 12px; text-align: left;">Nombre</th>
                        <th style="padding: 12px; text-align: left;">Nivel</th>
                        <th style="padding: 12px; text-align: left;">Duración</th>
                        <th style="padding: 12px; text-align: left;">Descripción</th>
                        <th style="padding: 12px; text-align: left;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($temas)): foreach($temas as $tema): ?>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <strong><?php echo $tema['nombre']; ?></strong>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <span style="background: #4ECDC4; color: white; padding: 4px 8px; border-radius: 10px; font-size: 12px;">
                                    <?php echo $tema['nivel_requerido']; ?>
                                </span>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <?php echo $tema['duracion_estimada']; ?> min
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <?php echo substr($tema['descripcion'], 0, 50) . '...'; ?>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                                <a href="/englishdemo/?controller=teacher&action=editTopic&id=<?php echo $tema['id']; ?>" class="btn-action btn-edit">
                                    ✏️ Editar
                                </a>
                                <a href="/englishdemo/?controller=teacher&action=deleteTopic&id=<?php echo $tema['id']; ?>" 
                                   class="btn-action btn-delete" 
                                   onclick="return confirm('¿Estás seguro de eliminar este tema?')">
                                    🗑️ Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" style="padding: 20px; text-align: center; color: #666;">
                                No hay temas disponibles
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <!-- Paginación -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination" style="text-align: center; margin-top: 20px;">
                    <?php if ($current_page > 1): ?>
                        <a href="?controller=teacher&action=manageTopics&page=<?php echo $current_page - 1; ?>" class="btn-action btn-edit">← Anterior</a>
                    <?php endif; ?>
                    
                    <span style="margin: 0 15px; font-weight: bold;">Página <?php echo $current_page; ?> de <?php echo $total_pages; ?></span>
                    
                    <?php if ($current_page < $total_pages): ?>
                        <a href="?controller=teacher&action=manageTopics&page=<?php echo $current_page + 1; ?>" class="btn-action btn-edit">Siguiente →</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        const notification = document.getElementById('notification');
        if (notification) {
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>
</body>
</html>