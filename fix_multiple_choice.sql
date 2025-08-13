-- Actualizar ejercicios de opción múltiple para usar letras como respuesta correcta
UPDATE Ejercicio 
SET respuesta_correcta = 'b' 
WHERE titulo = 'Choose correct form' 
AND contenido LIKE '%She ___ to school every day%';

-- Actualizar ejercicio del color del cielo
UPDATE Ejercicio 
SET respuesta_correcta = 'a' 
WHERE titulo = 'Select the correct color' 
AND contenido LIKE '%What color is the sky%';

-- Actualizar todos los ejercicios de opción múltiple que tengan respuestas como palabras
UPDATE Ejercicio 
SET respuesta_correcta = 'a' 
WHERE tipo = 'multiple_choice' 
AND respuesta_correcta = 'Blue';

UPDATE Ejercicio 
SET respuesta_correcta = 'b' 
WHERE tipo = 'multiple_choice' 
AND respuesta_correcta = 'goes';

-- Verificar todos los cambios
SELECT id, titulo, contenido, respuesta_correcta, tipo 
FROM Ejercicio 
WHERE tipo = 'multiple_choice';