-- MODIFICACIONES PARA AGREGAR SISTEMA DE GRUPOS
-- Archivo: database_grupos_modificaciones.sql
-- Fecha: 2024

-- ========================================
-- NUEVAS TABLAS
-- ========================================

-- Tabla Grupo
CREATE TABLE Grupo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    nivel ENUM('Beginner', 'Elementary', 'Intermediate', 'Upper-Intermediate', 'Advanced'),
    profesor_id INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (profesor_id) REFERENCES Profesor(id) ON DELETE SET NULL
);

-- Tabla intermedia Grupo_Estudiantes
CREATE TABLE Grupo_Estudiantes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    grupo_id INT,
    estudiante_id INT,
    fecha_ingreso TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (grupo_id) REFERENCES Grupo(id) ON DELETE CASCADE,
    FOREIGN KEY (estudiante_id) REFERENCES Estudiante(id) ON DELETE CASCADE,
    UNIQUE KEY unique_grupo_estudiante (grupo_id, estudiante_id)
);

-- ========================================
-- MODIFICACIONES A TABLAS EXISTENTES
-- ========================================

-- Agregar grupo_id a Evaluacion
ALTER TABLE Evaluacion ADD COLUMN grupo_id INT,
ADD FOREIGN KEY (grupo_id) REFERENCES Grupo(id) ON DELETE SET NULL;

-- Agregar grupo_id a Plan_de_estudios  
ALTER TABLE Plan_de_estudios ADD COLUMN grupo_id INT,
ADD FOREIGN KEY (grupo_id) REFERENCES Grupo(id) ON DELETE SET NULL;

-- ========================================
-- DATOS DE EJEMPLO
-- ========================================

-- Insertar grupos de ejemplo
INSERT INTO Grupo (nombre, descripcion, nivel, profesor_id) VALUES 
('Beginners A1', 'Grupo inicial de principiantes', 'Beginner', 1),
('Intermediate B1', 'Estudiantes nivel intermedio', 'Intermediate', 2),
('Advanced C1', 'Grupo avanzado', 'Advanced', 2);

-- Asignar estudiantes a grupos
INSERT INTO Grupo_Estudiantes (grupo_id, estudiante_id) VALUES 
(1, 1), -- John en Beginners A1
(2, 2), -- Emma en Intermediate B1  
(3, 3); -- Michael en Advanced C1

-- ========================================
-- CONSULTAS DE VERIFICACIÓN
-- ========================================

-- Ver grupos con sus profesores
SELECT 
    g.nombre AS grupo,
    g.nivel,
    u.nombre AS profesor,
    g.fecha_creacion
FROM Grupo g
JOIN Profesor p ON g.profesor_id = p.id
JOIN Usuario u ON p.usuario_id = u.id;

-- Ver estudiantes por grupo
SELECT 
    g.nombre AS grupo,
    u.nombre AS estudiante,
    e.nivel_actual,
    ge.fecha_ingreso
FROM Grupo g
JOIN Grupo_Estudiantes ge ON g.id = ge.grupo_id
JOIN Estudiante e ON ge.estudiante_id = e.id
JOIN Usuario u ON e.usuario_id = u.id
ORDER BY g.nombre, u.nombre;

-- ========================================
-- BENEFICIOS DEL SISTEMA DE GRUPOS
-- ========================================

/*
1. ORGANIZACIÓN MEJORADA:
   - Profesores pueden gestionar múltiples grupos por nivel
   - Estudiantes organizados por competencia

2. EVALUACIONES GRUPALES:
   - Asignar evaluaciones a todo un grupo
   - Comparar rendimiento entre grupos

3. PLANES COMPARTIDOS:
   - Mismo plan de estudios para todo el grupo
   - Gestión centralizada de contenido

4. ESCALABILIDAD:
   - Fácil adición de nuevos grupos
   - Transferencia de estudiantes entre grupos

5. REPORTES AVANZADOS:
   - Estadísticas por grupo
   - Progreso comparativo
*/