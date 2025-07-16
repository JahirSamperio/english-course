<?php
// Datos ya disponibles desde el controlador: $estudiante, $temas
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌟 English Learning Fun!</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_enhanced.css">
</head>
<body>
    <div class="container">
        <!-- Mascota educativa -->
        <div class="mascot-container">
            <svg class="mascot" viewBox="0 0 100 100" onclick="playMotivationSound()">
                <circle cx="50" cy="40" r="25" fill="#FFE066" stroke="#FF6B6B" stroke-width="2"/>
                <circle cx="42" cy="35" r="3" fill="#333"/>
                <circle cx="58" cy="35" r="3" fill="#333"/>
                <path d="M 40 45 Q 50 55 60 45" stroke="#333" stroke-width="2" fill="none"/>
                <circle cx="50" cy="70" r="15" fill="#4ECDC4"/>
                <rect x="35" y="55" width="30" height="20" rx="5" fill="#45B7D1"/>
                <text x="50" y="90" text-anchor="middle" font-size="8" fill="#333">Hi!</text>
            </svg>
        </div>
        
        <!-- Header -->
        <div class="header bounce fade-in">
            <h1 class="text-glow">🌟 Hello <?php echo $estudiante['nombre'] ?? 'Student'; ?>!</h1>
            <p>Level: <?php echo $estudiante['grado'] ?? 'Beginner'; ?> | English Level: <?php echo $estudiante['nivel_actual'] ?? 'Beginner'; ?></p>
        </div>
        
        <!-- Menú de navegación -->
        <nav class="nav-menu">
            <a href="/englishdemo/?controller=student&action=interactiveExercises" class="nav-btn exercises">
                <span>🎯</span>
                <span>Mis ejercicios / My Exercises</span>
            </a>
            <a href="#progress" class="nav-btn progress">
                <span>📈</span>
                <span>Mi progreso / My Progress</span>
            </a>
            <a href="/englishdemo/?controller=auth&action=logout" class="nav-btn logout">
                <span>🚪</span>
                <span>Salir / Exit</span>
            </a>
        </nav>
        
        <!-- Sección de progreso -->
        <div class="progress-section sparkle" id="progress">
            <h2>🏆 Mi Progreso / My Progress</h2>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo $estudiante['porcentaje'] ?? 0; ?>%"></div>
                <div class="progress-text"><?php echo $estudiante['porcentaje'] ?? 0; ?>% Complete!</div>
            </div>
            <div class="progress-stats">
                <div class="stat-item">
                    <span class="stat-number animated-icon star"><?php echo $estudiante['puntos_acumulados'] ?? 0; ?></span>
                    <span class="stat-label">Puntos / Points</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $estudiante['racha_dias'] ?? 0; ?></span>
                    <span class="stat-label">Días / Days</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $estudiante['ejercicios_completados'] ?? 0; ?></span>
                    <span class="stat-label">Ejercicios / Exercises</span>
                </div>
            </div>
        </div>
        
        <!-- Tarjetas principales -->
        <div class="cards-grid">
            <div class="card pulse">
                <span class="card-icon">📚</span>
                <h3>English Topics / Temas de Inglés</h3>
                <p>Learn new words and grammar / Aprende nuevas palabras y gramática</p>
                <?php foreach($temas as $tema): ?>
                    <div style="margin: 10px 0; padding: 10px; background: #f8f9fa; border-radius: 10px;">
                        <strong><?php echo $tema['nombre']; ?></strong><br>
                        <small>Level: <?php echo $tema['nivel_requerido']; ?> | <?php echo $tema['duracion_estimada']; ?> min</small>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="card">
                <span class="card-icon">🎮</span>
                <h3>Fun Exercises / Ejercicios Divertidos</h3>
                <p>Practice English with games / Practica inglés con juegos</p>
                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    <a href="/englishdemo/?controller=student&action=assignedContent" class="big-btn start">My Content</a>
                <a href="/englishdemo/?controller=student&action=interactiveExercises" class="big-btn practice">Practice</a>
            </div>
            </div>
            
            <div class="card">
                <span class="card-icon">🏆</span>
                <h3>My Achievements / Mis Logros</h3>
                <p>See how well you're doing / Ve qué tan bien lo haces</p>
                <div style="margin-top: 15px;">
                    <p><strong>Accuracy / Precisión:</strong> <?php echo $estudiante['ejercicios_completados'] > 0 ? round(($estudiante['ejercicios_correctos'] / $estudiante['ejercicios_completados']) * 100, 1) : 0; ?>%</p>
                    <p><strong>Level / Nivel:</strong> <?php echo $estudiante['nivel_actual'] ?? 'Beginner'; ?></p>
                </div>
            </div>
            

        </div>
    </div>
    
    <script>
        function playMotivationSound() {
            const audio = new Audio('/englishdemo/assets/audio/motivation.mp3');
            audio.volume = 0.5;
            audio.play().catch(() => {
                // Fallback sound
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.setValueAtTime(440, audioContext.currentTime);
                oscillator.frequency.setValueAtTime(554.37, audioContext.currentTime + 0.2);
                oscillator.frequency.setValueAtTime(659.25, audioContext.currentTime + 0.4);
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.6);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.6);
            });
            
            // Mostrar confetti
            for (let i = 0; i < 5; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.backgroundColor = ['#FFE066', '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4'][Math.floor(Math.random() * 5)];
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => {
                        confetti.remove();
                    }, 3000);
                }, i * 100);
            }
        }
    </script>
</body>
</html>