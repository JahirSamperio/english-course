<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👤 Crear Estudiante y Padre</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .form-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-section {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .form-section h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #4ECDC4;
            padding-bottom: 10px;
        }
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-group {
            flex: 1;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #2C3E50;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #4ECDC4;
            border-radius: 10px;
            font-size: 1rem;
        }
        .btn-submit {
            background: linear-gradient(45deg, #4ECDC4, #45B7D1);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 15px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1.1rem;
            width: 100%;
            margin-top: 20px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.3);
        }
        .required {
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="header">
            <h1>👤 Crear Estudiante y Padre</h1>
            <p>Registro completo de estudiante con información del padre/tutor</p>
            <a href="?controller=teacher&action=panel" class="btn-back">← Volver al Panel</a>
        </div>

        <?php if (isset($_SESSION['notification'])): ?>
            <div class="notification <?php echo $_SESSION['notification']['type']; ?>">
                <?php echo $_SESSION['notification']['message']; ?>
            </div>
            <?php unset($_SESSION['notification']); ?>
        <?php endif; ?>

        <form method="POST" action="?controller=teacher&action=guardarEstudianteCompleto">
            <!-- Información del Estudiante -->
            <div class="form-section">
                <h3>🧒 Información del Estudiante</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre Completo <span class="required">*</span></label>
                        <input type="text" name="estudiante[nombre]" required placeholder="Ej: Ana García López">
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="estudiante[email]" required placeholder="ana.garcia@email.com">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Contraseña <span class="required">*</span></label>
                        <input type="password" name="estudiante[password]" required placeholder="Mínimo 6 caracteres">
                    </div>
                    <div class="form-group">
                        <label>Edad</label>
                        <input type="number" name="estudiante[edad]" min="5" max="25" placeholder="15">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Grado/Nivel <span class="required">*</span></label>
                        <select name="estudiante[grado]" required>
                            <option value="">Seleccionar nivel</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Elementary">Elementary</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Upper-Intermediate">Upper-Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Asignar a Grupo (opcional)</label>
                        <select name="estudiante[grupo_id]">
                            <option value="">Sin grupo</option>
                            <?php if(isset($grupos)): foreach($grupos as $grupo): ?>
                                <option value="<?php echo $grupo['id']; ?>">
                                    <?php echo $grupo['nombre']; ?> (<?php echo $grupo['nivel']; ?>)
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Información del Padre -->
            <div class="form-section">
                <h3>👨👩👧👦 Información del Padre/Tutor</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre Completo <span class="required">*</span></label>
                        <input type="text" name="padre[nombre]" required placeholder="Ej: María García Rodríguez">
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="padre[email]" required placeholder="maria.garcia@email.com">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Contraseña <span class="required">*</span></label>
                        <input type="password" name="padre[password]" required placeholder="Mínimo 6 caracteres">
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="tel" name="padre[telefono]" placeholder="+1-555-0123">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                ✅ Crear Estudiante y Padre
            </button>
        </form>
    </div>

    <script>
        // Validación básica del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const estudianteEmail = document.querySelector('input[name="estudiante[email]"]').value;
            const padreEmail = document.querySelector('input[name="padre[email]"]').value;
            
            if (estudianteEmail === padreEmail) {
                e.preventDefault();
                alert('❌ Error: El email del estudiante y del padre deben ser diferentes');
                return false;
            }
            
            const estudiantePassword = document.querySelector('input[name="estudiante[password]"]').value;
            const padrePassword = document.querySelector('input[name="padre[password]"]').value;
            
            if (estudiantePassword.length < 6 || padrePassword.length < 6) {
                e.preventDefault();
                alert('❌ Error: Las contraseñas deben tener al menos 6 caracteres');
                return false;
            }
        });
    </script>
</body>
</html>