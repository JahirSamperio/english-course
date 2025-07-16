<?php
// Datos disponibles: $tema, $estudiante
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
    <div class="mascot-container">
        <svg class="mascot" viewBox="0 0 100 100" onclick="playMotivationSound()">
            <circle cx="50" cy="40" r="25" fill="#a7ffeb" stroke="#26a69a" stroke-width="2"/>
            <circle cx="42" cy="35" r="3" fill="#333"/>
            <circle cx="58" cy="35" r="3" fill="#333"/>
            <path d="M 40 45 Q 50 55 60 45" stroke="#333" stroke-width="2" fill="none"/>
            <circle cx="50" cy="70" r="15" fill="#4db6ac"/>
            <rect x="35" y="55" width="30" height="20" rx="5" fill="#26a69a"/>
            <text x="50" y="90" text-anchor="middle" font-size="8" fill="#333">Read!</text>
        </svg>
    </div>

    <div class="container">
        <div class="header bounce fade-in">
            <h1 class="text-glow">📖 <?php echo $tema['nombre'] ?? 'Topic Content'; ?></h1>
            <p>Level: <?php echo $tema['nivel_requerido'] ?? 'Beginner'; ?> | Learn the fundamentals</p>
        </div>

        <nav class="nav-menu">
            <a href="?controller=student&action=startTopic&tema_id=<?php echo $tema['id']; ?>&nivel=<?php echo $tema['nivel_requerido']; ?>" class="nav-btn exercises">
                <span>🎯</span>
                <span>Practice</span>
            </a>
            <a href="?controller=student&action=assignedContent" class="nav-btn progress">
                <span>📚</span>
                <span>Back to Content</span>
            </a>
        </nav>

        <!-- Contenido Principal del Tema -->
        <div class="card sparkle">
            <span class="card-icon">📚</span>
            <h3><?php echo $tema['nombre']; ?></h3>
            
            <div style="background: linear-gradient(45deg, #a7ffeb, #80cbc4); color: #00695c; padding: 20px; border-radius: 15px; margin: 15px 0; box-shadow: 0 4px 15px rgba(128, 203, 196, 0.4); border: 2px solid #4db6ac;">
                <h4 style="font-size: 1.2rem; margin-bottom: 15px; font-weight: bold;">📝 Topic Overview</h4>
                <p style="font-size: 1rem; line-height: 1.6; color: #00897b;"><?php echo $tema['descripcion'] ?? 'Topic description will appear here.'; ?></p>
            </div>
            
            <!-- Contenido Detallado -->
            <div style="background: white; padding: 25px; border-radius: 15px; margin: 15px 0; border: 2px solid #b2dfdb; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <h4 style="color: #00695c; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <span>📖</span>
                    <span>Learning Content</span>
                </h4>
                
                <div style="color: #2c3e50; line-height: 1.8; font-size: 16px;">
                    <?php if (!empty($tema['contenidos'])): ?>
                        <?php 
                        $content = $tema['contenidos'];
                        // Formatear títulos principales
                        $content = preg_replace('/^([A-Z][A-Z\s\-]+)$/m', '<h3 style="color: #00695c; margin: 15px 0 8px 0; padding: 8px 12px; background: #e0f2f1; border-radius: 6px; border-left: 3px solid #26a69a; font-size: 16px;">$1</h3>', $content);
                        // Formatear subtítulos con emojis
                        $content = preg_replace('/^([🔤📚⚠️📝🎯💡🕐👨‍👩‍👧‍👦👴👵💑🗣️].+)$/m', '<h4 style="color: #00897b; margin: 12px 0 6px 0; font-size: 15px; font-weight: bold;">$1</h4>', $content);
                        // Formatear listas con bullets
                        $content = preg_replace('/^• (.+)$/m', '<div style="margin: 3px 0; padding-left: 15px; position: relative;"><span style="position: absolute; left: 0; color: #26a69a; font-weight: bold;">•</span> $1</div>', $content);
                        // Formatear ejemplos con checkmarks y X
                        $content = preg_replace('/^✅ (.+)$/m', '<div style="margin: 4px 0; padding: 6px 10px; background: #e8f5e8; border-radius: 4px; border-left: 2px solid #4caf50; font-size: 14px;"><span style="color: #4caf50; font-weight: bold;">✅</span> $1</div>', $content);
                        $content = preg_replace('/^❌ (.+)$/m', '<div style="margin: 4px 0; padding: 6px 10px; background: #ffebee; border-radius: 4px; border-left: 2px solid #f44336; font-size: 14px;"><span style="color: #f44336; font-weight: bold;">❌</span> $1</div>', $content);
                        // Formatear números de lista
                        $content = preg_replace('/^(\d+\. .+)$/m', '<div style="margin: 4px 0; padding: 6px 10px; background: #f8f9fa; border-radius: 4px; font-weight: 500; font-size: 14px;">$1</div>', $content);
                        echo nl2br($content);
                        ?>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px; color: #666;">
                            <div style="font-size: 48px; margin-bottom: 15px;">📝</div>
                            <h4>Content Coming Soon</h4>
                            <p>The detailed content for this topic will be available soon. Contact your teacher for more information.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Información del Tema -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin: 20px 0;">
                <div style="background: rgba(255,255,255,0.95); color: #00695c; padding: 15px; border-radius: 10px; text-align: center; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 1px solid #b2dfdb;">
                    <div style="font-size: 1.5rem; margin-bottom: 5px;">📊</div>
                    <strong style="font-size: 0.9rem;">Level</strong><br>
                    <span style="font-size: 1.1rem;"><?php echo $tema['nivel_requerido'] ?? 'Beginner'; ?></span>
                </div>
                <div style="background: rgba(255,255,255,0.95); color: #00695c; padding: 15px; border-radius: 10px; text-align: center; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 1px solid #b2dfdb;">
                    <div style="font-size: 1.5rem; margin-bottom: 5px;">⏱️</div>
                    <strong style="font-size: 0.9rem;">Duration</strong><br>
                    <span style="font-size: 1.1rem;"><?php echo $tema['duracion_estimada'] ?? 30; ?> min</span>
                </div>
                <div style="background: rgba(255,255,255,0.95); color: #00695c; padding: 15px; border-radius: 10px; text-align: center; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 1px solid #b2dfdb;">
                    <div style="font-size: 1.5rem; margin-bottom: 5px;">📅</div>
                    <strong style="font-size: 0.9rem;">Created</strong><br>
                    <span style="font-size: 1.1rem;"><?php echo date('d/m/Y', strtotime($tema['fecha_creacion'] ?? 'now')); ?></span>
                </div>
            </div>
            
            <!-- Botones de Acción -->
            <div style="text-align: center; margin-top: 30px; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="?controller=student&action=startTopic&tema_id=<?php echo $tema['id']; ?>&nivel=<?php echo $tema['nivel_requerido']; ?>" 
                   class="big-btn start" style="font-size: 1.1rem; padding: 15px 30px;">
                    🎯 Practice Exercises
                </a>
                <a href="?controller=student&action=assignedContent" 
                   class="big-btn review" style="font-size: 1.1rem; padding: 15px 30px;">
                    📚 Back to Topics
                </a>
            </div>
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
                oscillator.frequency.setValueAtTime(659.25, audioContext.currentTime + 0.3);
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.8);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.8);
            });
        }
    </script>
    <script src="/englishdemo/assets/js/progress-background.js"></script>
</body>
</html>