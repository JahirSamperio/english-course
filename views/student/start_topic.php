<?php
// Datos disponibles: $tema, $ejercicios, $estudiante, $nivel
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - English Learning</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_enhanced.css">
</head>
<body>
    <!-- Mascota educativa -->
    <div class="mascot-container">
        <svg class="mascot" viewBox="0 0 100 100" onclick="playMotivationSound()">
            <circle cx="50" cy="40" r="25" fill="#a7ffeb" stroke="#26a69a" stroke-width="2"/>
            <circle cx="42" cy="35" r="3" fill="#333"/>
            <circle cx="58" cy="35" r="3" fill="#333"/>
            <path d="M 40 45 Q 50 55 60 45" stroke="#333" stroke-width="2" fill="none"/>
            <circle cx="50" cy="70" r="15" fill="#4db6ac"/>
            <rect x="35" y="55" width="30" height="20" rx="5" fill="#26a69a"/>
            <text x="50" y="90" text-anchor="middle" font-size="8" fill="#333">Go!</text>
        </svg>
    </div>

    <div class="container">
        <div class="header bounce fade-in">
            <h1 class="text-glow">🎯 <?php echo $tema['nombre'] ?? 'Topic'; ?></h1>
            <p>Level: <?php echo $nivel; ?> | Duration: <?php echo $tema['duracion_estimada'] ?? 30; ?> minutes</p>
        </div>

        <nav class="nav-menu">
            <a href="?controller=student&action=assignedContent" class="nav-btn exercises">
                <span>📚</span>
                <span>Back to Content</span>
            </a>
            <a href="?controller=student&action=dashboard" class="nav-btn progress">
                <span>🏠</span>
                <span>Dashboard</span>
            </a>
        </nav>

        <!-- Información del Tema -->
        <div class="card sparkle">
            <span class="card-icon">📖</span>
            <h3>Topic Overview</h3>
            <div style="background: linear-gradient(45deg, #a7ffeb, #80cbc4); color: #00695c; padding: 20px; border-radius: 15px; margin: 15px 0; box-shadow: 0 4px 15px rgba(128, 203, 196, 0.4); border: 2px solid #4db6ac;">
                <h4 style="font-size: 1.4rem; margin-bottom: 10px; font-weight: bold;"><?php echo $tema['nombre']; ?></h4>
                <p style="font-size: 1.1rem; line-height: 1.4; color: #00897b; margin-bottom: 15px;"><?php echo $tema['descripcion']; ?></p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 10px; margin-top: 15px;">
                    <div style="background: rgba(255,255,255,0.95); color: #00695c; padding: 12px; border-radius: 10px; text-align: center; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <strong style="font-size: 0.9rem;">Level</strong><br><span style="font-size: 1.1rem;"><?php echo $tema['nivel_requerido']; ?></span>
                    </div>
                    <div style="background: rgba(255,255,255,0.95); color: #00695c; padding: 12px; border-radius: 10px; text-align: center; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <strong style="font-size: 0.9rem;">Duration</strong><br><span style="font-size: 1.1rem;"><?php echo $tema['duracion_estimada']; ?> min</span>
                    </div>
                    <div style="background: rgba(255,255,255,0.95); color: #00695c; padding: 12px; border-radius: 10px; text-align: center; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <strong style="font-size: 0.9rem;">Exercises</strong><br><span style="font-size: 1.1rem;"><?php echo count($ejercicios); ?></span>
                    </div>
                </div>
            </div>
            
            <?php if (!empty($tema['contenidos'])): ?>
            <!-- Resumen breve del contenido -->
            <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin: 15px 0; border-left: 3px solid #4db6ac;">
                <h4 style="color: #00695c; margin-bottom: 8px; font-size: 14px;">📝 What you'll learn:</h4>
                <div style="color: #00897b; line-height: 1.5; font-size: 14px;">
                    <?php 
                    $preview = strlen($tema['contenidos']) > 150 ? substr($tema['contenidos'], 0, 150) . '...' : $tema['contenidos'];
                    echo nl2br(htmlspecialchars($preview));
                    ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Botón de Acción Principal -->
        <div style="text-align: center; margin: 30px 0;">
            <a href="?controller=student&action=interactiveExercises&tema_id=<?php echo $tema['id']; ?>&nivel=<?php echo $nivel; ?>" 
               class="big-btn start" style="font-size: 1.2rem; padding: 20px 40px;">
                🚀 Start Practice Exercises
            </a>
        </div>

        <!-- Progreso del Estudiante -->
        <?php if ($estudiante): ?>
            <div class="progress-section">
                <h3>📊 Your Progress</h3>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo $estudiante['porcentaje'] ?? 0; ?>%"></div>
                    <div class="progress-text"><?php echo round($estudiante['porcentaje'] ?? 0); ?>% Complete</div>
                </div>
                <div class="progress-stats">
                    <div class="stat-item">
                        <span class="stat-number animated-icon star"><?php echo $estudiante['puntos_acumulados'] ?? 0; ?></span>
                        <span class="stat-label">Points</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo $estudiante['ejercicios_completados'] ?? 0; ?></span>
                        <span class="stat-label">Exercises</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number animated-icon heart"><?php echo $estudiante['racha_dias'] ?? 0; ?></span>
                        <span class="stat-label">Day Streak</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function playMotivationSound() {
            const audio = new Audio('/englishdemo/assets/audio/motivation.mp3');
            audio.volume = 0.5;
            audio.play().catch(() => {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.setValueAtTime(523.25, audioContext.currentTime);
                oscillator.frequency.setValueAtTime(659.25, audioContext.currentTime + 0.2);
                oscillator.frequency.setValueAtTime(783.99, audioContext.currentTime + 0.4);
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.6);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.6);
            });
            
            // Confetti effect
            for (let i = 0; i < 5; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.backgroundColor = ['#a7ffeb', '#80cbc4', '#4db6ac', '#26a69a', '#00897b'][Math.floor(Math.random() * 5)];
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => {
                        confetti.remove();
                    }, 3000);
                }, i * 100);
            }
        }
        
        // Activar progreso de fondo al cargar
        document.addEventListener('DOMContentLoaded', () => {
            if (window.progressBg) {
                window.progressBg.advanceProgress();
            }
        });
    </script>
    <script src="/englishdemo/assets/js/progress-background.js"></script>
</body>
</html>