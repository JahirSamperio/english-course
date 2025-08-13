<?php
require_once 'config/Database.php';

echo "<h2>🔍 Test de Ejercicios - Diagnóstico</h2>";

try {
    $db = Database::getInstance()->getConnection();
    
    // 1. Verificar todos los ejercicios en la base de datos
    echo "<h3>📊 Todos los ejercicios en la base de datos:</h3>";
    $stmt = $db->query("SELECT id, titulo, nivel, tipo, puntos, tema_id FROM Ejercicio ORDER BY id DESC LIMIT 20");
    $ejercicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($ejercicios)) {
        echo "<p style='color: red;'>❌ No hay ejercicios en la base de datos</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Título</th><th>Nivel</th><th>Tipo</th><th>Puntos</th><th>Tema ID</th></tr>";
        foreach ($ejercicios as $ej) {
            echo "<tr>";
            echo "<td>{$ej['id']}</td>";
            echo "<td>{$ej['titulo']}</td>";
            echo "<td>{$ej['nivel']}</td>";
            echo "<td>{$ej['tipo']}</td>";
            echo "<td>{$ej['puntos']}</td>";
            echo "<td>{$ej['tema_id']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // 2. Verificar estudiantes y sus niveles
    echo "<h3>👥 Estudiantes y sus niveles:</h3>";
    $stmt = $db->query("
        SELECT u.nombre, u.email, e.grado, e.nivel_actual, e.id as estudiante_id
        FROM Usuario u 
        JOIN Estudiante e ON u.id = e.usuario_id 
        WHERE u.tipo = 'estudiante'
    ");
    $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Nombre</th><th>Email</th><th>Grado</th><th>Nivel Actual</th><th>ID</th></tr>";
    foreach ($estudiantes as $est) {
        echo "<tr>";
        echo "<td>{$est['nombre']}</td>";
        echo "<td>{$est['email']}</td>";
        echo "<td>{$est['grado']}</td>";
        echo "<td>{$est['nivel_actual']}</td>";
        echo "<td>{$est['estudiante_id']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 3. Simular la lógica del StudentController para cada estudiante
    echo "<h3>🎯 Ejercicios que vería cada estudiante:</h3>";
    
    function getNivelesPermitidos($nivel_estudiante) {
        $jerarquia = ['Beginner', 'Elementary', 'Intermediate', 'Upper-Intermediate', 'Advanced'];
        $indice = array_search($nivel_estudiante, $jerarquia);
        
        if ($indice === false) {
            return ['Beginner'];
        }
        
        return array_slice($jerarquia, 0, $indice + 1);
    }
    
    foreach ($estudiantes as $est) {
        echo "<h4>Estudiante: {$est['nombre']} (Nivel: {$est['grado']})</h4>";
        
        $niveles_permitidos = getNivelesPermitidos($est['grado']);
        echo "<p><strong>Niveles permitidos:</strong> " . implode(', ', $niveles_permitidos) . "</p>";
        
        $placeholders = str_repeat('?,', count($niveles_permitidos) - 1) . '?';
        $stmt = $db->prepare("SELECT id, titulo, nivel, tipo, puntos FROM Ejercicio WHERE nivel IN ($placeholders) ORDER BY nivel, titulo");
        $stmt->execute($niveles_permitidos);
        $ejercicios_estudiante = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($ejercicios_estudiante)) {
            echo "<p style='color: red;'>❌ No hay ejercicios disponibles para este estudiante</p>";
        } else {
            echo "<p style='color: green;'>✅ {count($ejercicios_estudiante)} ejercicios disponibles</p>";
            echo "<ul>";
            foreach ($ejercicios_estudiante as $ej) {
                echo "<li>{$ej['titulo']} - {$ej['nivel']} - {$ej['tipo']} ({$ej['puntos']} pts)</li>";
            }
            echo "</ul>";
        }
    }
    
    // 4. Verificar ejercicios creados recientemente
    echo "<h3>🆕 Ejercicios creados recientemente (últimos 10):</h3>";
    $stmt = $db->query("SELECT id, titulo, nivel, tipo, puntos, tema_id FROM Ejercicio ORDER BY id DESC LIMIT 10");
    $ejercicios_recientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($ejercicios_recientes)) {
        echo "<p style='color: red;'>❌ No hay ejercicios recientes</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Título</th><th>Nivel</th><th>Tipo</th><th>Puntos</th><th>Tema ID</th></tr>";
        foreach ($ejercicios_recientes as $ej) {
            echo "<tr>";
            echo "<td>{$ej['id']}</td>";
            echo "<td>{$ej['titulo']}</td>";
            echo "<td>{$ej['nivel']}</td>";
            echo "<td>{$ej['tipo']}</td>";
            echo "<td>{$ej['puntos']}</td>";
            echo "<td>{$ej['tema_id']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // 5. Verificar ejercicios de opción múltiple específicamente
    echo "<h3>🔍 Verificación de Ejercicios de Opción Múltiple:</h3>";
    $stmt = $db->query("SELECT id, titulo, contenido, respuesta_correcta FROM Ejercicio WHERE tipo = 'multiple_choice'");
    $multiple_choice = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($multiple_choice)) {
        echo "<p style='color: orange;'>⚠️ No hay ejercicios de opción múltiple</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Título</th><th>Contenido</th><th>Respuesta Correcta</th><th>Estado</th></tr>";
        foreach ($multiple_choice as $mc) {
            $estado = "✅ OK";
            $color = "green";
            
            // Verificar si la respuesta correcta es una letra (a, b, c, d)
            if (!preg_match('/^[a-d]$/i', $mc['respuesta_correcta'])) {
                $estado = "❌ Debe ser letra (a, b, c, d)";
                $color = "red";
            }
            
            echo "<tr>";
            echo "<td>{$mc['id']}</td>";
            echo "<td>{$mc['titulo']}</td>";
            echo "<td>" . substr($mc['contenido'], 0, 50) . "...</td>";
            echo "<td><strong>{$mc['respuesta_correcta']}</strong></td>";
            echo "<td style='color: $color;'>$estado</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<p><strong>Nota:</strong> Para ejercicios de opción múltiple, la respuesta correcta debe ser solo la letra (a, b, c, d), no la palabra completa.</p>";
        echo "<p><strong>Solución:</strong> Ejecutar el archivo <code>fix_multiple_choice.sql</code> en phpMyAdmin para corregir las respuestas.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<br><br><a href='/englishdemo/'>← Volver al sistema</a>";
echo "<br><a href='/englishdemo/fix_multiple_choice.sql' target='_blank'>📄 Ver script de corrección SQL</a>";
?>