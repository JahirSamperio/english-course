-- ACTUALIZACIONES DE BASE DE DATOS
-- Archivo: database_updates.sql
-- Fecha: 2024

-- ========================================
-- UPDATE 1: Agregar columna archivo_pdf a tabla Evaluacion
-- ========================================

ALTER TABLE Evaluacion ADD COLUMN archivo_pdf VARCHAR(500) NULL COMMENT 'URL del archivo PDF de la evaluación';

-- ========================================
-- UPDATE 2: Agregar columna imagen a tabla Ejercicio
-- ========================================

ALTER TABLE Ejercicio ADD COLUMN imagen VARCHAR(500) NULL COMMENT 'URL de imagen para el ejercicio';

-- ========================================
-- VERIFICACIÓN
-- ========================================

-- Verificar que la columna se agregó correctamente
DESCRIBE Evaluacion;

-- ========================================
-- DATOS DE EJEMPLO (OPCIONAL)
-- ========================================

-- Actualizar evaluaciones existentes con PDFs de ejemplo
UPDATE Evaluacion SET archivo_pdf = 'https://res.cloudinary.com/dszrfmjri/raw/upload/v1/english-learning/pdfs/grammar_test_1.pdf' WHERE id = 1;
UPDATE Evaluacion SET archivo_pdf = 'https://res.cloudinary.com/dszrfmjri/raw/upload/v1/english-learning/pdfs/vocabulary_quiz_1.pdf' WHERE id = 2;

-- ========================================
-- HISTORIAL DE CAMBIOS
-- ========================================

/*
FECHA: 2024-12-XX
CAMBIO: Agregada columna archivo_pdf a tabla Evaluacion
PROPÓSITO: Permitir subir archivos PDF para evaluaciones
IMPACTO: Los profesores pueden subir PDFs de exámenes
*/