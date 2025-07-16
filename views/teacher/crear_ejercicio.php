<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 Crear Ejercicio</title>
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
        .form-group textarea {
            height: 120px;
            resize: vertical;
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
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header bounce fade-in">
            <h1>📝 Crear Nuevo Ejercicio</h1>
            <p>Diseña ejercicios interactivos para tus estudiantes</p>
        </div>

        <nav class="nav-menu">
            <a href="/englishdemo/?controller=teacher&action=panel" class="nav-btn exercises">
                <span>←</span>
                <span>Volver al Panel</span>
            </a>
        </nav>

        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="titulo">Título del Ejercicio:</label>
                    <input type="text" id="titulo" name="titulo" required placeholder="Ej: Choose correct form">
                </div>

                <div class="form-group">
                    <label for="tipo">Tipo de Ejercicio:</label>
                    <select id="tipo" name="tipo" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="fill_blank">Fill in the Blank</option>
                        <option value="listening">Listening</option>
                        <option value="writing">Writing</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nivel">Nivel:</label>
                    <select id="nivel" name="nivel" required>
                        <option value="">Seleccionar nivel</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tema_id">Tema (Opcional):</label>
                    <select id="tema_id" name="tema_id">
                        <option value="">Sin tema específico</option>
                        <?php foreach($temas as $tema): ?>
                            <option value="<?php echo $tema['id']; ?>">
                                <?php echo $tema['nombre']; ?> (<?php echo $tema['nivel_requerido']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="contenido">Contenido del Ejercicio:</label>
                    <textarea id="contenido" name="contenido" required placeholder="Ej: She ___ to school every day. a)go b)goes c)going d)went"></textarea>
                    <small style="color: #666;">Para multiple choice, incluye las opciones con a), b), c), d)</small>
                </div>

                <div class="form-group">
                    <label for="respuesta_correcta">Respuesta Correcta:</label>
                    <input type="text" id="respuesta_correcta" name="respuesta_correcta" required placeholder="Ej: b) o goes">
                </div>

                <div class="form-group">
                    <label for="puntos">Puntos:</label>
                    <input type="number" id="puntos" name="puntos" required min="1" max="50" value="10">
                </div>

                <button type="submit" class="btn-submit">
                    🎯 Crear Ejercicio
                </button>
            </form>
        </div>
    </div>
</body>
</html>