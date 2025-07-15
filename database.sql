-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS english_learning_system;

-- Usar la base de datos creada
USE english_learning_system;

-- Tabla Usuario
CREATE TABLE Usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    tipo ENUM('estudiante', 'padre', 'profesor') NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla Estudiante
CREATE TABLE Estudiante (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    grado ENUM('Beginner', 'Elementary', 'Intermediate', 'Upper-Intermediate', 'Advanced') NOT NULL,
    edad INT,
    nivel_actual VARCHAR(50) DEFAULT 'Beginner',
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
);

-- Tabla Padre
CREATE TABLE Padre (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    telefono VARCHAR(20),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
);

-- Tabla Hijo
CREATE TABLE Hijo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    padre_id INT,
    estudiante_id INT,
    FOREIGN KEY (padre_id) REFERENCES Padre(id) ON DELETE CASCADE,
    FOREIGN KEY (estudiante_id) REFERENCES Estudiante(id) ON DELETE CASCADE
);

-- Tabla Profesor
CREATE TABLE Profesor (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    especialidad VARCHAR(100) DEFAULT 'English Teaching',
    experiencia_anos INT DEFAULT 0,
    certificacion VARCHAR(200),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
);

-- Tabla Tema
CREATE TABLE Tema (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    nivel_requerido ENUM('Beginner', 'Elementary', 'Intermediate', 'Upper-Intermediate', 'Advanced'),
    audios TEXT,
    contenidos TEXT,
    duracion_estimada INT DEFAULT 60 -- en minutos
);

-- Tabla Audio
CREATE TABLE Audio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    archivo_audio VARCHAR(255) NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    duracion INT, -- en segundos
    transcripcion TEXT,
    tema_id INT,
    FOREIGN KEY (tema_id) REFERENCES Tema(id) ON DELETE CASCADE
);

-- Tabla Unidad
CREATE TABLE Unidad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    orden_unidad INT,
    tema_id INT,
    FOREIGN KEY (tema_id) REFERENCES Tema(id) ON DELETE CASCADE
);

-- Tabla Plan_de_estudios
CREATE TABLE Plan_de_estudios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    nivel ENUM('Beginner', 'Elementary', 'Intermediate', 'Upper-Intermediate', 'Advanced'),
    duracion_semanas INT DEFAULT 12,
    unidades TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla Estudiantes_asignados (intermedia)
CREATE TABLE Estudiantes_asignados (
    id INT PRIMARY KEY AUTO_INCREMENT,
    estudiante_id INT,
    plan_estudios_id INT,
    fecha_asignacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_inicio DATE,
    fecha_fin_estimada DATE,
    FOREIGN KEY (estudiante_id) REFERENCES Estudiante(id) ON DELETE CASCADE,
    FOREIGN KEY (plan_estudios_id) REFERENCES Plan_de_estudios(id) ON DELETE CASCADE
);

-- Tabla Ejercicio
CREATE TABLE Ejercicio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT NOT NULL,
    respuesta_correcta TEXT NOT NULL,
    tipo ENUM('multiple_choice', 'fill_blank', 'listening', 'speaking', 'writing', 'grammar', 'vocabulary') NOT NULL,
    nivel ENUM('Beginner', 'Elementary', 'Intermediate', 'Upper-Intermediate', 'Advanced'),
    puntos INT DEFAULT 10,
    tema_id INT,
    FOREIGN KEY (tema_id) REFERENCES Tema(id) ON DELETE CASCADE
);

-- Tabla Evaluacion
CREATE TABLE Evaluacion (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha DATE NOT NULL,
    tiempo_limite INT DEFAULT 60, -- en minutos
    puntos_total INT DEFAULT 100,
    resultado DECIMAL(5,2),
    estudiante_id INT,
    profesor_id INT,
    FOREIGN KEY (estudiante_id) REFERENCES Estudiante(id) ON DELETE CASCADE,
    FOREIGN KEY (profesor_id) REFERENCES Profesor(id) ON DELETE SET NULL
);

-- Tabla Resultado_de_evaluacion
CREATE TABLE Resultado_de_evaluacion (
    id INT PRIMARY KEY AUTO_INCREMENT,
    calificaciones DECIMAL(5,2) NOT NULL,
    comentarios TEXT,
    fecha_de_realizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tiempo_empleado INT, -- en minutos
    evaluacion_id INT,
    ejercicio_id INT,
    respuesta_estudiante TEXT,
    es_correcta BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (evaluacion_id) REFERENCES Evaluacion(id) ON DELETE CASCADE,
    FOREIGN KEY (ejercicio_id) REFERENCES Ejercicio(id) ON DELETE CASCADE
);

-- Tabla Progreso
CREATE TABLE Progreso (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ejercicios_completados INT DEFAULT 0,
    ejercicios_correctos INT DEFAULT 0,
    porcentaje DECIMAL(5,2) DEFAULT 0.00,
    nivel_actual ENUM('Beginner', 'Elementary', 'Intermediate', 'Upper-Intermediate', 'Advanced') DEFAULT 'Beginner',
    puntos_acumulados INT DEFAULT 0,
    racha_dias INT DEFAULT 0,
    ultima_actividad TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estudiante_id INT,
    FOREIGN KEY (estudiante_id) REFERENCES Estudiante(id) ON DELETE CASCADE
);

-- Insertar datos de ejemplo para inglés
INSERT INTO Usuario (nombre, email, password, tipo) VALUES 
('John Smith', 'john.student@email.com', 'password123', 'estudiante'),
('Emma Johnson', 'emma.student@email.com', 'password123', 'estudiante'),
('Michael Brown', 'michael.student@email.com', 'password123', 'estudiante'),
('Sarah Davis', 'sarah.parent@email.com', 'password123', 'padre'),
('Robert Wilson', 'robert.parent@email.com', 'password123', 'padre'),
('Jennifer Miller', 'jennifer.teacher@email.com', 'password123', 'profesor'),
('David Anderson', 'david.teacher@email.com', 'password123', 'profesor');

INSERT INTO Estudiante (usuario_id, grado, edad, nivel_actual) VALUES 
(1, 'Beginner', 15, 'Beginner'),
(2, 'Intermediate', 17, 'Intermediate'),
(3, 'Advanced', 18, 'Advanced');

INSERT INTO Padre (usuario_id, telefono) VALUES 
(4, '+1-555-0123'),
(5, '+1-555-0124');

INSERT INTO Profesor (usuario_id, especialidad, experiencia_anos, certificacion) VALUES 
(6, 'English Grammar and Conversation', 8, 'TEFL Certified'),
(7, 'English Literature and Writing', 12, 'TESOL Certified');

INSERT INTO Hijo (padre_id, estudiante_id) VALUES 
(1, 1), -- Sarah es madre de John
(2, 2); -- Robert es padre de Emma

INSERT INTO Tema (nombre, descripcion, nivel_requerido, audios, contenidos, duracion_estimada) VALUES 
('English Grammar Basics', 'Fundamental grammar rules for beginners', 'Beginner', 'grammar_basics.mp3', 'Verb to be, Present simple, Articles, Pronouns', 90),
('Essential Vocabulary', 'Building core English vocabulary', 'Beginner', 'vocabulary_audio.mp3', 'Family, Colors, Numbers, Food, Daily objects', 75),
('Conversation Skills', 'Practical speaking and listening practice', 'Elementary', 'conversation_practice.mp3', 'Greetings, Introductions, Daily routines, Shopping', 120),
('Intermediate Grammar', 'Advanced grammar structures', 'Intermediate', 'intermediate_grammar.mp3', 'Past tenses, Future forms, Conditionals', 100),
('Business English', 'Professional communication skills', 'Upper-Intermediate', 'business_english.mp3', 'Meetings, Presentations, Emails, Negotiations', 150),
('Advanced Listening', 'Complex listening comprehension', 'Advanced', 'advanced_listening.mp3', 'News, Interviews, Academic lectures', 90);

INSERT INTO Audio (archivo_audio, titulo, duracion, transcripcion, tema_id) VALUES 
('verb_to_be.mp3', 'Learning Verb To Be', 480, 'I am, you are, he is, she is...', 1),
('present_simple.mp3', 'Present Simple Tense', 600, 'I work, you work, he works...', 1),
('family_vocabulary.mp3', 'Family Members', 360, 'Father, mother, brother, sister...', 2),
('daily_conversations.mp3', 'Daily Conversations', 720, 'Good morning! How are you today?', 3),
('business_meeting.mp3', 'Business Meeting Example', 900, 'Lets discuss the quarterly results...', 5),
('news_report.mp3', 'English News Report', 600, 'Today in international news...', 6);

INSERT INTO Unidad (titulo, descripcion, orden_unidad, tema_id) VALUES 
('Unit 1: Grammar Fundamentals', 'Basic sentence structure and verb forms', 1, 1),
('Unit 2: Essential Words', 'Core vocabulary for everyday communication', 1, 2),
('Unit 3: Speaking Practice', 'Interactive conversation exercises', 1, 3),
('Unit 4: Intermediate Structures', 'Complex grammar patterns', 1, 4),
('Unit 5: Professional English', 'Business communication skills', 1, 5),
('Unit 6: Advanced Comprehension', 'High-level listening skills', 1, 6);

INSERT INTO Plan_de_estudios (titulo, descripcion, nivel, duracion_semanas, unidades) VALUES 
('Beginner English Course', 'Complete beginner program', 'Beginner', 16, 'Grammar Basics, Essential Vocabulary'),
('Intermediate English Course', 'For students with basic knowledge', 'Intermediate', 20, 'Grammar, Vocabulary, Conversation Skills'),
('Advanced English Course', 'High-level English mastery', 'Advanced', 24, 'Business English, Advanced Listening, Writing');

INSERT INTO Estudiantes_asignados (estudiante_id, plan_estudios_id, fecha_inicio, fecha_fin_estimada) VALUES 
(1, 1, '2024-07-01', '2024-10-28'),
(2, 2, '2024-07-01', '2024-11-25'),
(3, 3, '2024-07-01', '2024-12-23');

INSERT INTO Ejercicio (titulo, contenido, respuesta_correcta, tipo, nivel, puntos, tema_id) VALUES 
('Complete the sentence', 'I ___ a student', 'am', 'fill_blank', 'Beginner', 10, 1),
('Choose correct form', 'She ___ to school every day. a)go b)goes c)going', 'goes', 'multiple_choice', 'Beginner', 10, 1),
('Vocabulary Quiz', 'What fruit is red and round?', 'apple', 'fill_blank', 'Beginner', 5, 2),
('Listening Exercise', 'Listen and write what you hear', 'Hello, how are you?', 'listening', 'Elementary', 15, 3),
('Grammar Challenge', 'If I ___ rich, I would travel the world', 'were', 'fill_blank', 'Intermediate', 20, 4),
('Business Scenario', 'Write a professional email requesting a meeting', 'Dear Mr. Smith, I would like to schedule a meeting...', 'writing', 'Upper-Intermediate', 25, 5);

INSERT INTO Evaluacion (titulo, descripcion, fecha, tiempo_limite, puntos_total, resultado, estudiante_id, profesor_id) VALUES 
('Grammar Basics Test', 'Assessment of basic grammar knowledge', '2024-07-15', 45, 100, 88.5, 1, 1),
('Vocabulary Quiz', 'Essential vocabulary assessment', '2024-07-16', 30, 50, 92.0, 1, 1),
('Intermediate Grammar Test', 'Complex grammar structures', '2024-07-17', 60, 100, 85.0, 2, 2),
('Conversation Assessment', 'Speaking skills evaluation', '2024-07-18', 30, 100, 90.0, 2, 1),
('Advanced Listening Test', 'High-level comprehension test', '2024-07-19', 50, 100, 95.5, 3, 2);

INSERT INTO Progreso (ejercicios_completados, ejercicios_correctos, porcentaje, nivel_actual, puntos_acumulados, racha_dias, estudiante_id) VALUES 
(48, 39, 81.25, 'Elementary', 390, 12, 1),
(87, 74, 85.06, 'Upper-Intermediate', 1480, 25, 2),
(125, 119, 95.20, 'Advanced', 2975, 45, 3);

INSERT INTO Resultado_de_evaluacion (calificaciones, comentarios, fecha_de_realizacion, tiempo_empleado, evaluacion_id, ejercicio_id, respuesta_estudiante, es_correcta) VALUES 
(88.5, 'Good understanding of basic grammar. Keep practicing verb forms.', '2024-07-15 14:30:00', 40, 1, 1, 'am', TRUE),
(92.0, 'Excellent vocabulary retention. Try to learn 5 new words daily.', '2024-07-16 10:15:00', 25, 2, 3, 'apple', TRUE),
(85.0, 'Shows improvement in complex structures. Focus on conditionals.', '2024-07-17 16:45:00', 55, 3, 5, 'were', TRUE),
(90.0, 'Great conversation skills. Work on pronunciation of th sounds.', '2024-07-18 11:20:00', 28, 4, 4, 'Hello, how are you?', TRUE),
(95.5, 'Outstanding listening comprehension. Ready for advanced materials.', '2024-07-19 13:10:00', 47, 5, 6, 'Dear Mr. Smith, I would like to schedule a meeting to discuss our project timeline.', TRUE);

-- Mostrar confirmación
SELECT 'English Learning System database created successfully!' AS Status;

-- Mostrar datos de ejemplo
SELECT 'STUDENTS AND THEIR LEVELS:' AS Info;
SELECT u.nombre, u.email, e.grado, e.nivel_actual 
FROM Usuario u 
JOIN Estudiante e ON u.id = e.usuario_id;

SELECT 'ENGLISH TOPICS AVAILABLE:' AS Info;
SELECT nombre, nivel_requerido, duracion_estimada FROM Tema;

SELECT 'STUDENT PROGRESS:' AS Info;
SELECT u.nombre, p.ejercicios_completados, p.porcentaje, p.nivel_actual, p.puntos_acumulados, p.racha_dias
FROM Usuario u 
JOIN Estudiante e ON u.id = e.usuario_id
JOIN Progreso p ON e.id = p.estudiante_id;