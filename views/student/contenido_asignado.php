<?php
// Datos ya disponibles desde el controlador: $estudiante, $plan, $temas, $ejercicios
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 My Learning Content - English System</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_enhanced.css">
</head>
<body>
    <!-- Mascota educativa -->
    <div class="mascot-container">
        <svg class="mascot" viewBox="0 0 100 100" onclick="playMotivationSound()">
            <circle cx="50" cy="40" r="25" fill="#FFE066" stroke="#FF6B6B" stroke-width="2"/>
            <circle cx="42" cy="35" r="3" fill="#333"/>
            <circle cx="58" cy="35" r="3" fill="#333"/>
            <path d="M 40 45 Q 50 55 60 45" stroke="#333" stroke-width="2" fill="none"/>
            <circle cx="50" cy="70" r="15" fill="#4ECDC4"/>
            <rect x="35" y="55" width="30" height="20" rx="5" fill="#45B7D1"/>
            <text x="50" y="90" text-anchor="middle" font-size="8" fill="#333">Study!</text>
        </svg>
    </div>

    <div class="container">
        <div class="header bounce fade-in">
            <h1 class="text-glow">📚 My Learning Path</h1>
            <p>Content assigned specifically for you</p>
        </div>

        <nav class="nav-menu">
            <a href="?controller=student&action=dashboard" class="nav-btn exercises">
                <span>🏠</span>
                <span>Dashboard</span>
            </a>
            <a href="?controller=student&action=interactiveExercises" class="nav-btn practice">
                <span>🎯</span>
                <span>Practice</span>
            </a>
        </nav>

        <?php if (!$plan): ?>
            <div class="progress-section" style="background: linear-gradient(45deg, #FF6B6B, #FD79A8); color: white;">
                <h2>⚠️ No study plan assigned. Contact your teacher.</h2>
            </div>
        <?php else: ?>
            <!-- Plan de Estudios Asignado -->
            <div class="card sparkle">
                <span class="card-icon">📋</span>
                <h3>Your Study Plan / Tu Plan de Estudios</h3>
                <div style="background: linear-gradient(45deg, #a7ffeb, #80cbc4); color: #00695c; padding: 20px; border-radius: 15px; margin: 15px 0; box-shadow: 0 4px 15px rgba(128, 203, 196, 0.4); border: 2px solid #4db6ac;">
                    <h4 style="font-size: 1.4rem; margin-bottom: 10px; font-weight: bold;"><?php echo $plan['titulo']; ?></h4>
                    <p style="font-size: 1.1rem; line-height: 1.4; color: #00897b;"><?php echo $plan['descripcion']; ?></p>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin-top: 15px;">
                        <div style="background: rgba(255,255,255,0.95); color: #00695c; padding: 12px; border-radius: 10px; text-align: center; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <strong style="font-size: 0.9rem;">Level</strong><br><span style="font-size: 1.1rem;"><?php echo $plan['nivel']; ?></span>
                        </div>
                        <div style="background: rgba(255,255,255,0.95); color: #00695c; padding: 12px; border-radius: 10px; text-align: center; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <strong style="font-size: 0.9rem;">Duration</strong><br><span style="font-size: 1.1rem;"><?php echo $plan['duracion_semanas']; ?> weeks</span>
                        </div>
                        <div style="background: rgba(255,255,255,0.95); color: #00695c; padding: 12px; border-radius: 10px; text-align: center; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <strong style="font-size: 0.9rem;">Started</strong><br><span style="font-size: 1.1rem;"><?php echo $plan['fecha_inicio']; ?></span>
                        </div>
                        <div style="background: rgba(255,255,255,0.95); color: #00695c; padding: 12px; border-radius: 10px; text-align: center; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <strong style="font-size: 0.9rem;">Ends</strong><br><span style="font-size: 1.1rem;"><?php echo $plan['fecha_fin_estimada']; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progreso General -->
            <?php if ($estudiante): ?>
                <div class="progress-section">
                    <h3>📊 Your Progress / Tu Progreso</h3>
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

            <!-- Temas Asignados -->
            <div class="card">
                <span class="card-icon">📖</span>
                <h3>Your Topics / Tus Temas (<?php echo count($temas); ?>)</h3>
                
                <?php if (empty($temas)): ?>
                    <p>No topics assigned yet. Contact your teacher.</p>
                <?php else: ?>
                    <div class="cards-grid">
                        <?php foreach($temas as $tema): ?>
                            <div class="card slide-in-left" style="margin: 0;">
                                <span class="card-icon">
                                    <?php 
                                    $icons = ['📝', '🗣️', '👂', '📖', '✍️', '🎯'];
                                    echo $icons[array_rand($icons)];
                                    ?>
                                </span>
                                <h4><?php echo $tema['nombre']; ?></h4>
                                <p><?php echo $tema['descripcion']; ?></p>
                                
                                <div style="background: #b2dfdb; color: #00695c; padding: 10px; border-radius: 10px; margin: 10px 0; font-size: 14px; font-weight: bold;">
                                    <strong>Level:</strong> <?php echo $tema['nivel_requerido']; ?><br>
                                    <strong>Duration:</strong> <?php echo $tema['duracion_estimada']; ?> min<br>
                                    <strong>Exercises:</strong> <?php echo $tema['total_ejercicios'] ?? 0; ?>
                                </div>
                                
                                <div style="background: #f8f9fa; padding: 10px; border-radius: 10px; font-size: 13px;">
                                    <strong>Content:</strong> <?php echo substr($tema['contenidos'], 0, 100); ?>...
                                </div>
                                
                                <div style="display: flex; gap: 10px; margin-top: 15px;">
                                    <a href="?controller=student&action=viewContent&tema_id=<?php echo $tema['id']; ?>" 
                                       class="big-btn review" style="font-size: 12px; padding: 8px 16px; flex: 1;">
                                        📖 Read Content
                                    </a>
                                    <a href="?controller=student&action=startTopic&tema_id=<?php echo $tema['id']; ?>&nivel=<?php echo $tema['nivel_requerido']; ?>" 
                                       class="big-btn start" style="font-size: 12px; padding: 8px 16px; flex: 1;">
                                        🎯 Practice
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Botón de Acción Principal -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="?controller=student&action=interactiveExercises" 
                   class="big-btn start" style="font-size: 1.2rem; padding: 20px 40px;">
                    🚀 Start Practice Exercises
                </a>
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
                oscillator.frequency.setValueAtTime(554.37, audioContext.currentTime + 0.2);
                oscillator.frequency.setValueAtTime(659.25, audioContext.currentTime + 0.4);
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.6);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.6);
            });
            
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