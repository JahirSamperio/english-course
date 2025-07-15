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
                <div style="background: linear-gradient(45deg, #4ECDC4, #45B7D1); color: white; padding: 20px; border-radius: 15px; margin: 15px 0;">
                    <h4><?php echo $plan['titulo']; ?></h4>
                    <p><?php echo $plan['descripcion']; ?></p>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin-top: 15px;">
                        <div style="background: rgba(255,255,255,0.2); padding: 10px; border-radius: 10px; text-align: center;">
                            <strong>Level</strong><br><?php echo $plan['nivel']; ?>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); padding: 10px; border-radius: 10px; text-align: center;">
                            <strong>Duration</strong><br><?php echo $plan['duracion_semanas']; ?> weeks
                        </div>
                        <div style="background: rgba(255,255,255,0.2); padding: 10px; border-radius: 10px; text-align: center;">
                            <strong>Started</strong><br><?php echo $plan['fecha_inicio']; ?>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); padding: 10px; border-radius: 10px; text-align: center;">
                            <strong>Ends</strong><br><?php echo $plan['fecha_fin_estimada']; ?>
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
                                
                                <div style="background: #FFE066; padding: 8px; border-radius: 10px; margin: 10px 0; font-size: 14px;">
                                    <strong>Level:</strong> <?php echo $tema['nivel_requerido']; ?><br>
                                    <strong>Duration:</strong> <?php echo $tema['duracion_estimada']; ?> min<br>
                                    <strong>Exercises:</strong> <?php echo $tema['total_ejercicios'] ?? 0; ?>
                                </div>
                                
                                <div style="background: #f8f9fa; padding: 10px; border-radius: 10px; font-size: 13px;">
                                    <strong>Content:</strong> <?php echo substr($tema['contenidos'], 0, 100); ?>...
                                </div>
                                
                                <a href="ejercicios_interactivos.php?tema_id=<?php echo $tema['id']; ?>&nivel=<?php echo $tema['nivel_requerido']; ?>" 
                                   class="big-btn start" style="margin-top: 15px; font-size: 14px;">
                                    Start Topic
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Ejercicios Disponibles -->
            <div class="card">
                <span class="card-icon">🎯</span>
                <h3>Available Exercises / Ejercicios Disponibles (<?php echo count($ejercicios); ?>)</h3>
                
                <?php if (empty($ejercicios)): ?>
                    <p>No exercises available for your assigned topics.</p>
                <?php else: ?>
                    <div style="max-height: 400px; overflow-y: auto;">
                        <?php 
                        $current_tema = '';
                        foreach($ejercicios as $ejercicio): 
                            if ($current_tema != $ejercicio['tema_nombre']) {
                                $current_tema = $ejercicio['tema_nombre'];
                                echo "<div style='background: linear-gradient(45deg, #4ECDC4, #45B7D1); color: white; padding: 10px; margin: 15px 0 5px 0; border-radius: 10px; font-weight: bold;'>{$current_tema}</div>";
                            }
                        ?>
                            <div style="background: rgba(255, 255, 255, 0.9); margin: 5px 0; padding: 15px; border-radius: 10px; border-left: 4px solid #FFE066;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong><?php echo $ejercicio['titulo']; ?></strong>
                                        <span style="background: #4ECDC4; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px; margin-left: 10px;">
                                            <?php echo ucfirst($ejercicio['tipo']); ?>
                                        </span>
                                    </div>
                                    <div style="background: #FFE066; padding: 5px 10px; border-radius: 10px; font-weight: bold; font-size: 12px;">
                                        🏆 <?php echo $ejercicio['puntos']; ?> pts
                                    </div>
                                </div>
                                <p style="margin: 8px 0; color: #666; font-size: 14px;"><?php echo substr($ejercicio['contenido'], 0, 100); ?>...</p>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                                    <small style="color: #999;">Level: <?php echo $ejercicio['nivel']; ?></small>
                                    <a href="ejercicios_interactivos.php?tema_id=<?php echo $ejercicio['tema_nombre']; ?>&nivel=<?php echo $ejercicio['nivel']; ?>" 
                                       class="big-btn practice" style="font-size: 12px; padding: 8px 15px;">
                                        Practice
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
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