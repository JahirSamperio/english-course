<?php
// Datos disponibles: $unidad, $temas, $estudiante, $nivel
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
            <text x="50" y="90" text-anchor="middle" font-size="8" fill="#333">Unit!</text>
        </svg>
    </div>

    <div class="container">
        <div class="header bounce fade-in">
            <h1 class="text-glow">📚 <?php echo $unidad['nombre'] ?? 'Learning Unit'; ?></h1>
            <p>Level: <?php echo $nivel; ?> | Complete all topics to master this unit</p>
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

        <!-- Información de la Unidad -->
        <div class="card sparkle">
            <span class="card-icon">📖</span>
            <h3>Unit Overview</h3>
            <div style="background: linear-gradient(45deg, #a7ffeb, #80cbc4); color: #00695c; padding: 20px; border-radius: 15px; margin: 15px 0; box-shadow: 0 4px 15px rgba(128, 203, 196, 0.4); border: 2px solid #4db6ac;">
                <h4 style="font-size: 1.4rem; margin-bottom: 10px; font-weight: bold;"><?php echo $unidad['nombre'] ?? 'Learning Unit'; ?></h4>
                <p style="font-size: 1.1rem; line-height: 1.4; color: #00897b;"><?php echo $unidad['descripcion'] ?? 'Complete this unit to advance your English skills.'; ?></p>
            </div>
        </div>

        <!-- Temas de la Unidad -->
        <div class="card">
            <span class="card-icon">📋</span>
            <h3>Topics in this Unit (<?php echo count($temas); ?>)</h3>
            
            <?php if (empty($temas)): ?>
                <div style="background: #fff3cd; color: #856404; padding: 20px; border-radius: 15px; text-align: center;">
                    <h4>⚠️ No topics available</h4>
                    <p>Contact your teacher to add topics to this unit.</p>
                </div>
            <?php else: ?>
                <div class="cards-grid">
                    <?php foreach($temas as $index => $tema): ?>
                        <div class="card slide-in-left" style="margin: 0; border: 2px solid #b2dfdb;">
                            <span class="card-icon">
                                <?php 
                                $icons = ['📝', '🗣️', '👂', '📖', '✍️', '🎯'];
                                echo $icons[$index % count($icons)];
                                ?>
                            </span>
                            <h4><?php echo $tema['nombre']; ?></h4>
                            <p style="color: #666; font-size: 14px;"><?php echo substr($tema['descripcion'], 0, 100); ?>...</p>
                            
                            <div style="background: #b2dfdb; color: #00695c; padding: 10px; border-radius: 10px; margin: 10px 0; font-size: 14px; font-weight: bold;">
                                <strong>Level:</strong> <?php echo $tema['nivel_requerido']; ?><br>
                                <strong>Duration:</strong> <?php echo $tema['duracion_estimada']; ?> min
                            </div>
                            
                            <a href="?controller=student&action=startTopic&tema_id=<?php echo $tema['id']; ?>&nivel=<?php echo $tema['nivel_requerido']; ?>" 
                               class="big-btn start" style="margin-top: 15px; font-size: 14px;">
                                Start Topic
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
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
                
                oscillator.frequency.setValueAtTime(440, audioContext.currentTime);
                oscillator.frequency.setValueAtTime(523.25, audioContext.currentTime + 0.2);
                oscillator.frequency.setValueAtTime(659.25, audioContext.currentTime + 0.4);
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.6);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.6);
            });
        }
    </script>
    <script src="/englishdemo/assets/js/progress-background.js"></script>
</body>
</html>