<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✏️ Editar Plan</title>
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
            <h1>✏️ Editar Plan de Estudios</h1>
            <p>Modifica los datos del plan</p>
        </div>

        <nav class="nav-menu">
            <a href="/englishdemo/?controller=teacher&action=managePlans" class="nav-btn exercises">
                <span>←</span>
                <span>Volver a Gestionar</span>
            </a>
        </nav>

        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label>Título:</label>
                    <input type="text" name="titulo" required value="<?php echo $plan['titulo'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Descripción:</label>
                    <textarea name="descripcion"><?php echo $plan['descripcion'] ?? ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Nivel:</label>
                    <select name="nivel" required>
                        <option value="Beginner" <?php echo ($plan['nivel'] ?? '') == 'Beginner' ? 'selected' : ''; ?>>Beginner</option>
                        <option value="Elementary" <?php echo ($plan['nivel'] ?? '') == 'Elementary' ? 'selected' : ''; ?>>Elementary</option>
                        <option value="Intermediate" <?php echo ($plan['nivel'] ?? '') == 'Intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                        <option value="Advanced" <?php echo ($plan['nivel'] ?? '') == 'Advanced' ? 'selected' : ''; ?>>Advanced</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Duración (semanas):</label>
                    <input type="number" name="duracion_semanas" min="1" max="52" value="<?php echo $plan['duracion_semanas'] ?? 8; ?>">
                </div>
                <button type="submit" class="btn-submit">💾 Guardar Cambios</button>
            </form>
        </div>
    </div>
</body>
</html>