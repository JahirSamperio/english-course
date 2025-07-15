<?php
// Datos ya disponibles desde el controlador
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 Crear Evaluación</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
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
            height: 100px;
            resize: vertical;
        }
        .btn-primary {
            background: linear-gradient(45deg, #4ECDC4, #45B7D1);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header bounce fade-in">
            <h1>📝 Crear Nueva Evaluación</h1>
            <p>Diseña evaluaciones personalizadas para tus estudiantes</p>
        </div>

        <nav class="nav-menu">
            <a href="/englishdemo/?controller=teacher&action=dashboard" class="nav-btn exercises">
                <span>←</span>
                <span>Volver al Dashboard</span>
            </a>
        </nav>

        <div class="form-container">
            <form method="POST" action="/englishdemo/?controller=teacher&action=createEvaluation">
                <div class="form-group">
                    <label for="titulo">Título de la Evaluación:</label>
                    <input type="text" id="titulo" name="titulo" required placeholder="Ej: Evaluación de Gramática Básica">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Describe el contenido y objetivos de la evaluación"></textarea>
                </div>

                <div class="form-group">
                    <label for="nivel">Nivel:</label>
                    <select id="nivel" name="nivel" required>
                        <option value="">Seleccionar nivel</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Upper-Intermediate">Upper-Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="duracion">Duración (minutos):</label>
                    <input type="number" id="duracion" name="duracion" min="5" max="180" value="30">
                </div>

                <div class="form-group">
                    <label for="puntos_total">Puntos Totales:</label>
                    <input type="number" id="puntos_total" name="puntos_total" min="10" max="100" value="50">
                </div>

                <div class="form-group">
                    <label for="instrucciones">Instrucciones para el Estudiante:</label>
                    <textarea id="instrucciones" name="instrucciones" placeholder="Instrucciones claras sobre cómo completar la evaluación"></textarea>
                </div>

                <div style="text-align: center; margin-top: 30px;">
                    <button type="submit" class="btn-primary">✅ Crear Evaluación</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>