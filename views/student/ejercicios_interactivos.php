<?php
// Datos ya disponibles desde el controlador: $temas, $ejercicios, $nivel_filtro, $tema_filtro
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎯 Interactive Exercises - English Learning</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_enhanced.css">
    <style>
        .exercise-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .exercise-card.correct {
            border-color: #00B894;
            background: linear-gradient(135deg, #00B894, #00CEC9);
            color: white;
        }
        .exercise-card.incorrect {
            border-color: #FF6B6B;
            background: linear-gradient(135deg, #FF6B6B, #FD79A8);
            color: white;
        }
        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .option-btn {
            background: linear-gradient(45deg, #4ECDC4, #45B7D1);
            border: none;
            border-radius: 15px;
            padding: 15px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        .option-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .option-btn.selected {
            background: linear-gradient(45deg, #FFE066, #FF6B6B);
        }
        .fill-input {
            background: rgba(255,255,255,0.9);
            border: 3px solid #4ECDC4;
            border-radius: 15px;
            padding: 15px;
            font-size: 1.2rem;
            text-align: center;
            width: 200px;
            margin: 0 10px;
        }
        .feedback {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 20px 0;
            padding: 15px;
            border-radius: 15px;
        }
        .feedback.correct {
            background: linear-gradient(45deg, #00B894, #00CEC9);
            color: white;
        }
        .feedback.incorrect {
            background: linear-gradient(45deg, #FF6B6B, #FD79A8);
            color: white;
        }
        .progress-indicator {
            background: rgba(255,255,255,0.9);
            border-radius: 25px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
    <style>
        .logo-corner {
            position: fixed;
            top: 20px;
            left: 20px;
            background: linear-gradient(45deg, #4ECDC4, #45B7D1);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="logo-corner">📚 Learning English</div>
    <!-- Mascota educativa -->
    <div class="mascot-container">
        <svg class="mascot" viewBox="0 0 100 100" onclick="playMotivationSound()">
            <circle cx="50" cy="40" r="25" fill="#FFE066" stroke="#FF6B6B" stroke-width="2"/>
            <circle cx="42" cy="35" r="3" fill="#333"/>
            <circle cx="58" cy="35" r="3" fill="#333"/>
            <path d="M 40 45 Q 50 55 60 45" stroke="#333" stroke-width="2" fill="none"/>
            <circle cx="50" cy="70" r="15" fill="#4ECDC4"/>
            <rect x="35" y="55" width="30" height="20" rx="5" fill="#45B7D1"/>
            <text x="50" y="90" text-anchor="middle" font-size="8" fill="#333">Click me!</text>
        </svg>
    </div>
    
    <!-- Burbujas decorativas -->
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    
    <div class="container">
        <div class="header bounce fade-in">
            <h1>🎯 Interactive English Exercises</h1>
            <p>Practice and improve your English skills!</p>
        </div>
        


        <!-- Indicador de Progreso -->
        <div class="progress-indicator">
            <div id="progress-text">Exercise <span id="current-exercise">1</span> of <?php echo count($ejercicios); ?></div>
            <div class="progress-bar">
                <div class="progress-fill" id="progress-bar" style="width: 0%"></div>
            </div>
        </div>

        <!-- Ejercicios -->
        <div id="exercises-container">
            <?php foreach($ejercicios as $index => $ejercicio): ?>
                <div class="exercise-card" id="exercise-<?php echo $index; ?>" style="<?php echo $index > 0 ? 'display: none;' : ''; ?>">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3><?php echo $ejercicio['titulo']; ?></h3>
                        <div style="background: #FFE066; padding: 8px 15px; border-radius: 15px; font-weight: bold;" class="animated-icon star">
                            🏆 <?php echo $ejercicio['puntos']; ?> points
                        </div>
                    </div>
                    
                    <div style="background: rgba(76, 175, 80, 0.1); padding: 15px; border-radius: 15px; margin-bottom: 20px;">
                        <p style="font-size: 1.3rem; font-weight: bold; margin: 0;"><?php echo $ejercicio['contenido']; ?></p>
                    </div>

                    <?php if ($ejercicio['tipo'] == 'multiple_choice'): ?>
                        <?php 
                        // Extraer opciones del contenido
                        preg_match_all('/[a-d]\)[^a-d)]*/', $ejercicio['contenido'], $matches);
                        $opciones = $matches[0] ?? [];
                        ?>
                        <div class="options-grid">
                            <?php foreach($opciones as $opcion): ?>
                                <button class="option-btn" onclick="selectOption(this, '<?php echo $index; ?>')">
                                    <?php echo trim($opcion); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php elseif ($ejercicio['tipo'] == 'fill_blank'): ?>
                        <div style="text-align: center; margin: 20px 0;">
                            <input type="text" class="fill-input" id="answer-<?php echo $index; ?>" placeholder="Your answer...">
                        </div>
                    <?php elseif ($ejercicio['tipo'] == 'listening'): ?>
                        <div style="text-align: center; margin: 20px 0;">
                            <button class="big-btn practice" onclick="playAudio(<?php echo $index; ?>)">🔊 Play Audio</button>
                            <input type="text" class="fill-input" id="answer-<?php echo $index; ?>" placeholder="What did you hear?" style="margin-top: 15px;">
                        </div>
                    <?php endif; ?>

                    <div style="text-align: center; margin-top: 25px;">
                        <button class="big-btn start" onclick="checkAnswer(<?php echo $index; ?>, '<?php echo $ejercicio['tipo']; ?>', '<?php echo addslashes($ejercicio['respuesta_correcta']); ?>', <?php echo $ejercicio['id']; ?>, <?php echo $ejercicio['puntos']; ?>)">
                            Submit Answer
                        </button>
                    </div>

                    <div id="feedback-<?php echo $index; ?>" class="feedback" style="display: none;"></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navegación -->
        <div style="text-align: center; margin: 30px 0;">
            <button id="prev-btn" class="big-btn review" onclick="previousExercise()" style="display: none;">← Previous</button>
            <button id="next-btn" class="big-btn practice" onclick="nextExercise()" style="display: none;">Next →</button>
            <button id="finish-btn" class="big-btn start" onclick="finishExercises()" style="display: none;">🏆 Finish</button>
        </div>

        <nav class="nav-menu">
            <a href="?controller=student&action=dashboard" class="nav-btn exercises">
                <span>←</span>
                <span>Back to Dashboard</span>
            </a>
        </nav>
    </div>

    <script>
        let currentExercise = 0;
        let totalExercises = <?php echo count($ejercicios); ?>;
        let correctAnswers = 0;
        let totalPoints = 0;
        let exerciseResults = [];

        function selectOption(button, exerciseIndex) {
            // Deseleccionar otras opciones
            const options = button.parentElement.querySelectorAll('.option-btn');
            options.forEach(opt => opt.classList.remove('selected'));
            
            // Seleccionar esta opción
            button.classList.add('selected');
            button.setAttribute('data-selected', 'true');
        }

        function checkAnswer(exerciseIndex, type, correctAnswer, exerciseId, points) {
            let userAnswer = '';
            let isCorrect = false;

            if (type === 'multiple_choice') {
                const selectedOption = document.querySelector(`#exercise-${exerciseIndex} .option-btn.selected`);
                if (selectedOption) {
                    userAnswer = selectedOption.textContent.trim();
                    // Extraer solo la letra de la respuesta correcta
                    const correctLetter = correctAnswer.toLowerCase();
                    const userLetter = userAnswer.charAt(0).toLowerCase();
                    isCorrect = userLetter === correctLetter;
                }
            } else {
                const answerInput = document.getElementById(`answer-${exerciseIndex}`);
                userAnswer = answerInput.value.trim();
                isCorrect = userAnswer.toLowerCase() === correctAnswer.toLowerCase();
            }

            // Mostrar feedback visual
            const feedbackDiv = document.getElementById(`feedback-${exerciseIndex}`);
            const exerciseCard = document.getElementById(`exercise-${exerciseIndex}`);
            
            if (isCorrect) {
                feedbackDiv.innerHTML = '✅ Correct! Well done! 🎉';
                feedbackDiv.className = 'feedback correct fade-in';
                exerciseCard.classList.add('correct');
                correctAnswers++;
                totalPoints += points;
                playSound('correct');
                showConfetti();
                
                // Marcar opciones como correctas
                if (type === 'multiple_choice') {
                    const selectedOption = document.querySelector(`#exercise-${exerciseIndex} .option-btn.selected`);
                    if (selectedOption) selectedOption.classList.add('correct');
                }
            } else {
                feedbackDiv.innerHTML = `❌ Incorrect. The correct answer is: <strong>${correctAnswer}</strong>`;
                feedbackDiv.className = 'feedback incorrect fade-in';
                exerciseCard.classList.add('incorrect');
                playSound('incorrect');
                
                // Marcar opciones como incorrectas
                if (type === 'multiple_choice') {
                    const selectedOption = document.querySelector(`#exercise-${exerciseIndex} .option-btn.selected`);
                    if (selectedOption) selectedOption.classList.add('incorrect');
                }
            }
            
            feedbackDiv.style.display = 'block';

            // Guardar resultado
            exerciseResults.push({
                exerciseId: exerciseId,
                userAnswer: userAnswer,
                isCorrect: isCorrect,
                points: isCorrect ? points : 0
            });

            // Mostrar botón siguiente
            setTimeout(() => {
                if (currentExercise < totalExercises - 1) {
                    document.getElementById('next-btn').style.display = 'inline-block';
                } else {
                    document.getElementById('finish-btn').style.display = 'inline-block';
                }
            }, 2000);
        }

        function nextExercise() {
            if (currentExercise < totalExercises - 1) {
                document.getElementById(`exercise-${currentExercise}`).style.display = 'none';
                currentExercise++;
                document.getElementById(`exercise-${currentExercise}`).style.display = 'block';
                
                updateProgress();
                
                document.getElementById('next-btn').style.display = 'none';
                document.getElementById('prev-btn').style.display = 'inline-block';
            }
        }

        function previousExercise() {
            if (currentExercise > 0) {
                document.getElementById(`exercise-${currentExercise}`).style.display = 'none';
                currentExercise--;
                document.getElementById(`exercise-${currentExercise}`).style.display = 'block';
                
                updateProgress();
                
                if (currentExercise === 0) {
                    document.getElementById('prev-btn').style.display = 'none';
                }
            }
        }

        function updateProgress() {
            document.getElementById('current-exercise').textContent = currentExercise + 1;
            const progressPercent = ((currentExercise + 1) / totalExercises) * 100;
            document.getElementById('progress-bar').style.width = progressPercent + '%';
        }

        function finishExercises() {
            // Mostrar celebración final
            showFinalCelebration();
            
            // Enviar resultados al servidor
            fetch('/englishdemo/save_results.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    results: exerciseResults,
                    totalCorrect: correctAnswers,
                    totalPoints: totalPoints
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Server response:', data);
                if (data.success) {
                    setTimeout(() => {
                        const accuracy = Math.round((correctAnswers/totalExercises)*100);
                        let message = `🎉 Exercises completed!\n\nCorrect answers: ${correctAnswers}/${totalExercises}\nPoints earned: ${totalPoints}\nAccuracy: ${accuracy}%`;
                        
                        if (accuracy >= 90) {
                            message += '\n\n🏆 Excellent work! You\'re a star!';
                        } else if (accuracy >= 70) {
                            message += '\n\n😊 Great job! Keep practicing!';
                        } else {
                            message += '\n\n💪 Good effort! Practice makes perfect!';
                        }
                        
                        alert(message);
                        window.location.href = '?controller=student&action=dashboard';
                    }, 2000);
                } else {
                    console.error('Error saving results:', data);
                    alert('Error saving results. Redirecting anyway...');
                    setTimeout(() => {
                        window.location.href = '?controller=student&action=dashboard';
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Network error. Redirecting anyway...');
                setTimeout(() => {
                    window.location.href = '?controller=student&action=dashboard';
                }, 1000);
            });
        }
        
        function showFinalCelebration() {
            // Confetti masivo
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.backgroundColor = ['#FFE066', '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4'][Math.floor(Math.random() * 5)];
                    confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => {
                        confetti.remove();
                    }, 4000);
                }, i * 50);
            }
            
            // Sonido de celebración
            playSound('motivation');
        }

        function playAudio(exerciseIndex) {
            // Simular reproducción de audio
            playSound('audio');
            alert('🔊 Audio would play here (audio file not available in demo)');
        }

        function playSound(type) {
            // Intentar reproducir archivo de audio primero
            const audio = new Audio();
            
            switch(type) {
                case 'correct':
                    audio.src = '/englishdemo/assets/audio/correct.mp3';
                    break;
                case 'incorrect':
                    audio.src = '/englishdemo/assets/audio/incorrect.mp3';
                    break;
                case 'motivation':
                    audio.src = '/englishdemo/assets/audio/motivation.mp3';
                    break;
            }
            
            audio.volume = 0.5;
            audio.play().catch(() => {
                // Fallback a Web Audio API si no hay archivos
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                if (type === 'correct') {
                    oscillator.frequency.setValueAtTime(523.25, audioContext.currentTime);
                    oscillator.frequency.setValueAtTime(659.25, audioContext.currentTime + 0.1);
                } else if (type === 'incorrect') {
                    oscillator.frequency.setValueAtTime(220, audioContext.currentTime);
                    oscillator.frequency.setValueAtTime(196, audioContext.currentTime + 0.2);
                } else if (type === 'motivation') {
                    oscillator.frequency.setValueAtTime(440, audioContext.currentTime);
                    oscillator.frequency.setValueAtTime(554.37, audioContext.currentTime + 0.2);
                    oscillator.frequency.setValueAtTime(659.25, audioContext.currentTime + 0.4);
                }
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.5);
            });
        }
        
        function playMotivationSound() {
            playSound('motivation');
            showConfetti();
        }
        
        function showConfetti() {
            for (let i = 0; i < 10; i++) {
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

        // Inicializar
        updateProgress();
    </script>
</body>
</html>