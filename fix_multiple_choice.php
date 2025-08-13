<?php
require_once 'config/Database.php';

echo "<h2>🔧 Corrección Automática de Ejercicios de Opción Múltiple</h2>";

try {
    $db = Database::getInstance()->getConnection();
    
    echo "<h3>📊 Estado actual de ejercicios de opción múltiple:</h3>";
    $stmt = $db->query("SELECT id, titulo, contenido, respuesta_correcta FROM Ejercicio WHERE tipo = 'multiple_choice'");
    $ejercicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($ejercicios)) {
        echo "<p style='color: orange;'>⚠️ No hay ejercicios de opción múltiple</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Título</th><th>Respuesta Actual</th><th>Estado</th></tr>";
        foreach ($ejercicios as $ej) {
            $estado = "✅ OK";
            $color = "green";
            
            if (!preg_match('/^[a-d]$/i', $ej['respuesta_correcta'])) {
                $estado = "❌ Necesita corrección";
                $color = "red";
            }
            
            echo "<tr>";
            echo "<td>{$ej['id']}</td>";
            echo "<td>{$ej['titulo']}</td>";
            echo "<td><strong>{$ej['respuesta_correcta']}</strong></td>";
            echo "<td style='color: $color;'>$estado</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<h3>🔧 Aplicando correcciones...</h3>";
    
    $correcciones = [
        [
            'descripcion' => 'Ejercicio: Choose correct form (goes)',
            'sql' => "UPDATE Ejercicio SET respuesta_correcta = 'b' WHERE titulo = 'Choose correct form' AND contenido LIKE '%She ___ to school every day%'"
        ],
        [
            'descripcion' => 'Ejercicio: Select the correct color (Blue)',
            'sql' => "UPDATE Ejercicio SET respuesta_correcta = 'a' WHERE titulo = 'Select the correct color' AND contenido LIKE '%What color is the sky%'"
        ],
        [
            'descripcion' => 'Todos los ejercicios con respuesta "Blue"',
            'sql' => "UPDATE Ejercicio SET respuesta_correcta = 'a' WHERE tipo = 'multiple_choice' AND respuesta_correcta = 'Blue'"
        ],
        [
            'descripcion' => 'Todos los ejercicios con respuesta "goes"',
            'sql' => "UPDATE Ejercicio SET respuesta_correcta = 'b' WHERE tipo = 'multiple_choice' AND respuesta_correcta = 'goes'"
        ],
        [
            'descripcion' => 'Todos los ejercicios con respuesta "am"',
            'sql' => "UPDATE Ejercicio SET respuesta_correcta = 'a' WHERE tipo = 'multiple_choice' AND respuesta_correcta = 'am'"
        ]
    ];
    
    $total_corregidos = 0;
    
    foreach ($correcciones as $correccion) {
        echo "<p><strong>Aplicando:</strong> {$correccion['descripcion']}</p>";
        $stmt = $db->prepare($correccion['sql']);
        $stmt->execute();
        $affected = $stmt->rowCount();
        
        if ($affected > 0) {
            echo "<p style='color: green;'>✅ {$affected} ejercicio(s) corregido(s)</p>";
            $total_corregidos += $affected;
        } else {
            echo "<p style='color: gray;'>ℹ️ No se encontraron ejercicios para corregir</p>";
        }
    }
    
    echo "<h3>📊 Estado después de las correcciones:</h3>";
    $stmt = $db->query("SELECT id, titulo, contenido, respuesta_correcta FROM Ejercicio WHERE tipo = 'multiple_choice'");
    $ejercicios_corregidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Título</th><th>Respuesta Corregida</th><th>Estado</th></tr>";
    foreach ($ejercicios_corregidos as $ej) {
        $estado = "✅ OK";
        $color = "green";
        
        if (!preg_match('/^[a-d]$/i', $ej['respuesta_correcta'])) {
            $estado = "❌ Aún necesita corrección manual";
            $color = "red";
        }
        
        echo "<tr>";
        echo "<td>{$ej['id']}</td>";
        echo "<td>{$ej['titulo']}</td>";
        echo "<td><strong>{$ej['respuesta_correcta']}</strong></td>";
        echo "<td style='color: $color;'>$estado</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    if ($total_corregidos > 0) {
        echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h4>🎉 Corrección Completada</h4>";
        echo "<p><strong>Total de ejercicios corregidos:</strong> $total_corregidos</p>";
        echo "<p>Los ejercicios de opción múltiple ahora deberían funcionar correctamente.</p>";
        echo "<p><strong>Próximos pasos:</strong></p>";
        echo "<ul>";
        echo "<li>Probar los ejercicios en la interfaz del estudiante</li>";
        echo "<li>Al crear nuevos ejercicios de opción múltiple, usar solo letras (a, b, c, d) como respuesta correcta</li>";
        echo "</ul>";
        echo "</div>";
    } else {
        echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h4>ℹ️ No se Necesitaron Correcciones</h4>";
        echo "<p>Todos los ejercicios de opción múltiple ya tienen el formato correcto.</p>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h4>❌ Error</h4>";
    echo "<p>Error al aplicar correcciones: " . $e->getMessage() . "</p>";
    echo "</div>";
}

echo "<br><br>";
echo "<a href='/englishdemo/' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>← Volver al sistema</a> ";
echo "<a href='/englishdemo/test_ejercicios.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px;'>🔍 Ejecutar diagnóstico</a>";
?>