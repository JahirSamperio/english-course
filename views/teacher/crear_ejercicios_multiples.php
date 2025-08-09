<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Ejercicios Múltiples</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .ejercicio-item {
            border: 2px solid #4ECDC4;
            border-radius: 15px;
            padding: 20px;
            margin: 15px 0;
            background: #f8f9fa;
        }
        .ejercicio-header {
            background: #4ECDC4;
            color: white;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2C3E50;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #4ECDC4;
            border-radius: 8px;
            font-size: 1rem;
        }
        .btn-agregar {
            background: #27AE60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin: 10px 5px;
        }
        .btn-eliminar {
            background: #E74C3C;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📝 Crear Ejercicios Múltiples</h1>
            <a href="?controller=teacher&action=dashboard" class="btn-back">← Volver</a>
        </div>

        <form method="POST" action="?controller=teacher&action=guardarEjerciciosMultiples">
            <div class="form-row">
                <div class="form-group">
                    <label>Tema:</label>
                    <select name="tema_id" required>
                        <option value="">Seleccionar tema</option>
                        <?php foreach($temas as $tema): ?>
                            <option value="<?= $tema['id'] ?>"><?= $tema['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nivel:</label>
                    <select name="nivel" required>
                        <option value="Beginner">Beginner</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Upper-Intermediate">Upper-Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                </div>
            </div>

            <div id="ejercicios-container">
                <div class="ejercicio-item">
                    <div class="ejercicio-header">
                        Ejercicio 1
                        <button type="button" class="btn-eliminar" onclick="eliminarEjercicio(this)" style="display:none;">Eliminar</button>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Título:</label>
                            <input type="text" name="ejercicios[0][titulo]" required>
                        </div>
                        <div class="form-group">
                            <label>Tipo:</label>
                            <select name="ejercicios[0][tipo]" required>
                                <option value="multiple_choice">Opción múltiple</option>
                                <option value="fill_blank">Llenar espacio</option>
                                <option value="listening">Comprensión auditiva</option>
                                <option value="grammar">Gramática</option>
                                <option value="vocabulary">Vocabulario</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Puntos:</label>
                            <input type="number" name="ejercicios[0][puntos]" value="10" min="1" max="100">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Contenido/Pregunta:</label>
                        <textarea name="ejercicios[0][contenido]" rows="3" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Respuesta correcta:</label>
                        <input type="text" name="ejercicios[0][respuesta_correcta]" required>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <button type="button" class="btn-agregar" onclick="agregarEjercicio()">+ Agregar Ejercicio</button>
                <button type="submit" class="big-btn start">💾 Guardar Todos los Ejercicios</button>
            </div>
        </form>
    </div>

    <script>
    let ejercicioCount = 1;
    const maxEjercicios = 10;

    function agregarEjercicio() {
        if (ejercicioCount >= maxEjercicios) {
            alert('Máximo 10 ejercicios por vez');
            return;
        }

        const container = document.getElementById('ejercicios-container');
        const nuevoEjercicio = document.createElement('div');
        nuevoEjercicio.className = 'ejercicio-item';
        nuevoEjercicio.innerHTML = `
            <div class="ejercicio-header">
                Ejercicio ${ejercicioCount + 1}
                <button type="button" class="btn-eliminar" onclick="eliminarEjercicio(this)">Eliminar</button>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Título:</label>
                    <input type="text" name="ejercicios[${ejercicioCount}][titulo]" required>
                </div>
                <div class="form-group">
                    <label>Tipo:</label>
                    <select name="ejercicios[${ejercicioCount}][tipo]" required>
                        <option value="multiple_choice">Opción múltiple</option>
                        <option value="fill_blank">Llenar espacio</option>
                        <option value="listening">Comprensión auditiva</option>
                        <option value="grammar">Gramática</option>
                        <option value="vocabulary">Vocabulario</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Puntos:</label>
                    <input type="number" name="ejercicios[${ejercicioCount}][puntos]" value="10" min="1" max="100">
                </div>
            </div>
            
            <div class="form-group">
                <label>Contenido/Pregunta:</label>
                <textarea name="ejercicios[${ejercicioCount}][contenido]" rows="3" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Respuesta correcta:</label>
                <input type="text" name="ejercicios[${ejercicioCount}][respuesta_correcta]" required>
            </div>
        `;
        
        container.appendChild(nuevoEjercicio);
        ejercicioCount++;
        
        // Mostrar botón eliminar en el primer ejercicio si hay más de uno
        if (ejercicioCount > 1) {
            document.querySelector('.btn-eliminar').style.display = 'inline-block';
        }
    }

    function eliminarEjercicio(btn) {
        if (ejercicioCount <= 1) {
            alert('Debe haber al menos un ejercicio');
            return;
        }
        
        btn.closest('.ejercicio-item').remove();
        ejercicioCount--;
        
        // Renumerar ejercicios
        const ejercicios = document.querySelectorAll('.ejercicio-item');
        ejercicios.forEach((ejercicio, index) => {
            ejercicio.querySelector('.ejercicio-header').firstChild.textContent = `Ejercicio ${index + 1}`;
            
            // Actualizar nombres de inputs
            const inputs = ejercicio.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                const name = input.name;
                if (name && name.includes('[')) {
                    input.name = name.replace(/\[\d+\]/, `[${index}]`);
                }
            });
        });
        
        // Ocultar botón eliminar si solo queda uno
        if (ejercicioCount === 1) {
            document.querySelector('.btn-eliminar').style.display = 'none';
        }
    }
    

    </script>
</body>
</html>