<?php
require_once 'config/Database.php';

echo "<h2>🔍 Debug de Grupos y Estudiantes</h2>";

try {
    $db = Database::getInstance()->getConnection();
    
    // 1. Verificar grupos existentes
    echo "<h3>📊 Grupos Existentes:</h3>";
    $stmt = $db->query("SELECT * FROM Grupo ORDER BY id");
    $grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Nivel</th><th>Profesor ID</th></tr>";
    foreach ($grupos as $grupo) {
        echo "<tr>";
        echo "<td>{$grupo['id']}</td>";
        echo "<td>{$grupo['nombre']}</td>";
        echo "<td>{$grupo['nivel']}</td>";
        echo "<td>{$grupo['profesor_id']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 2. Verificar estudiantes en grupos
    echo "<h3>👥 Estudiantes por Grupo:</h3>";
    $stmt = $db->query("
        SELECT g.id as grupo_id, g.nombre as grupo_nombre, 
               e.id as estudiante_id, u.nombre as estudiante_nombre
        FROM Grupo g
        LEFT JOIN Grupo_Estudiantes ge ON g.id = ge.grupo_id
        LEFT JOIN Estudiante e ON ge.estudiante_id = e.id
        LEFT JOIN Usuario u ON e.usuario_id = u.id
        ORDER BY g.id, e.id
    ");
    $relaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Grupo ID</th><th>Grupo Nombre</th><th>Estudiante ID</th><th>Estudiante Nombre</th></tr>";
    foreach ($relaciones as $rel) {
        echo "<tr>";
        echo "<td>{$rel['grupo_id']}</td>";
        echo "<td>{$rel['grupo_nombre']}</td>";
        echo "<td>" . ($rel['estudiante_id'] ?? 'SIN ESTUDIANTES') . "</td>";
        echo "<td>" . ($rel['estudiante_nombre'] ?? 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 3. Verificar estudiantes sin grupo
    echo "<h3>🚫 Estudiantes Sin Grupo:</h3>";
    $stmt = $db->query("
        SELECT e.id as estudiante_id, u.nombre as estudiante_nombre, e.grado
        FROM Estudiante e
        JOIN Usuario u ON e.usuario_id = u.id
        LEFT JOIN Grupo_Estudiantes ge ON e.id = ge.estudiante_id
        WHERE ge.estudiante_id IS NULL
        ORDER BY e.id
    ");
    $sin_grupo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($sin_grupo)) {
        echo "<p style='color: green;'>✅ Todos los estudiantes tienen grupo asignado</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Estudiante ID</th><th>Nombre</th><th>Grado</th></tr>";
        foreach ($sin_grupo as $est) {
            echo "<tr>";
            echo "<td>{$est['estudiante_id']}</td>";
            echo "<td>{$est['estudiante_nombre']}</td>";
            echo "<td>{$est['grado']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // 4. Asignar estudiantes automáticamente al grupo 4 si está vacío
    echo "<h3>🔧 Corrección Automática:</h3>";
    
    // Verificar si grupo 4 tiene estudiantes
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM Grupo_Estudiantes WHERE grupo_id = 4");
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    if ($count == 0) {
        echo "<p style='color: orange;'>⚠️ El grupo 4 no tiene estudiantes. Asignando automáticamente...</p>";
        
        // Obtener estudiantes sin grupo o del nivel Beginner
        $stmt = $db->query("
            SELECT e.id 
            FROM Estudiante e
            LEFT JOIN Grupo_Estudiantes ge ON e.id = ge.estudiante_id
            WHERE ge.estudiante_id IS NULL OR e.grado = 'Beginner'
            LIMIT 3
        ");
        $estudiantes_disponibles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $asignados = 0;
        foreach ($estudiantes_disponibles as $est) {
            $stmt = $db->prepare("INSERT IGNORE INTO Grupo_Estudiantes (grupo_id, estudiante_id) VALUES (4, ?)");
            if ($stmt->execute([$est['id']])) {
                $asignados++;
            }
        }
        
        echo "<p style='color: green;'>✅ Se asignaron $asignados estudiantes al grupo 4</p>";
    } else {
        echo "<p style='color: green;'>✅ El grupo 4 ya tiene $count estudiante(s) asignado(s)</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<br><br><a href='/englishdemo/'>← Volver al sistema</a>";
?>