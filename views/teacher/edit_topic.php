<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✏️ Editar Tema</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #4ECDC4;
            border-radius: 10px;
            font-size: 16px;
        }
        .btn-submit {
            background: linear-gradient(45deg, #4ECDC4, #45B7D1);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header bounce fade-in">
            <h1>✏️ Editar Tema</h1>
            <p>Modifica los datos del tema</p>
        </div>

        <nav class="nav-menu">
            <a href="/englishdemo/?controller=teacher&action=manageTopics" class="nav-btn exercises">
                <span>←</span>
                <span>Volver a Gestionar</span>
            </a>
        </nav>

        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label>Nombre del Tema:</label>
                    <input type="text" name="nombre" required value="<?php echo $tema['nombre'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Descripción:</label>
                    <textarea name="descripcion"><?php echo $tema['descripcion'] ?? ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Nivel Requerido:</label>
                    <select name="nivel_requerido" required>
                        <option value="Beginner" <?php echo ($tema['nivel_requerido'] ?? '') == 'Beginner' ? 'selected' : ''; ?>>Beginner</option>
                        <option value="Elementary" <?php echo ($tema['nivel_requerido'] ?? '') == 'Elementary' ? 'selected' : ''; ?>>Elementary</option>
                        <option value="Intermediate" <?php echo ($tema['nivel_requerido'] ?? '') == 'Intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                        <option value="Advanced" <?php echo ($tema['nivel_requerido'] ?? '') == 'Advanced' ? 'selected' : ''; ?>>Advanced</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Contenidos:</label>
                    <textarea name="contenidos"><?php echo $tema['contenidos'] ?? ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Duración Estimada (min):</label>
                    <input type="number" name="duracion_estimada" min="5" max="180" value="<?php echo $tema['duracion_estimada'] ?? 30; ?>">
                </div>
                <button type="submit" class="btn-submit">💾 Guardar Cambios</button>
            </form>
        </div>
    </div>
</body>
</html>