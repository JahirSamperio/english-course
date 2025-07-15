<?php
// Session ya iniciada en index.php
// Database ya disponible desde AuthController

// Lógica de login movida al AuthController
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌟 English Learning Fun - Login</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
</head>
<body>
    <div class="container">
        <div class="header bounce">
            <h1>🎓 Welcome! / ¡Bienvenido!</h1>
            <p>Start learning English / Comienza a aprender inglés</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="progress-section" style="background: linear-gradient(45deg, #FF6B6B, #FD79A8); color: white; text-align: center;">
                <h2>❌ <?php echo $error; ?></h2>
            </div>
        <?php endif; ?>
        
        <div class="cards-grid" style="max-width: 500px; margin: 0 auto;">
            <div class="card sparkle">
                <span class="card-icon">🎆</span>
                <h3>Login / Iniciar Sesión</h3>
                
                <form method="POST" action="?controller=auth&action=login" style="text-align: left;">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #2C3E50;">📧 Email:</label>
                        <input type="email" name="usuario" required style="width: 100%; padding: 15px; border: 3px solid #4ECDC4; border-radius: 25px; font-size: 1.1rem;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #2C3E50;">🔒 Password / Contraseña:</label>
                        <input type="password" name="password" required style="width: 100%; padding: 15px; border: 3px solid #4ECDC4; border-radius: 25px; font-size: 1.1rem;">
                    </div>
                    
                    <div style="margin-bottom: 30px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #2C3E50;">🎭 I am / Soy:</label>
                        <select name="rol" required style="width: 100%; padding: 15px; border: 3px solid #4ECDC4; border-radius: 25px; font-size: 1.1rem;">
                            <option value="">Select / Selecciona</option>
                            <option value="estudiante">🧒 Student / Estudiante</option>
                            <option value="profesor">👩‍🏫 Teacher / Profesor</option>
                            <option value="padre">👨‍👩‍👧‍👦 Parent / Padre</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="big-btn start" style="width: 100%;">🚀 Enter / Entrar</button>
                </form>
            </div>
        </div>
    </div>
    

</body>
</html>