<?php
// Debug directo
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== DEBUG CLOUDINARY ===<br>";

try {
    require_once 'vendor/autoload.php';
    echo "✅ Autoload OK<br>";
    
    require_once 'config/CloudinaryConfig.php';
    echo "✅ Config OK<br>";
    
    $cloudinary = new CloudinaryManager();
    echo "✅ CloudinaryManager OK<br>";
    
    // Test simple
    if ($_POST && isset($_FILES['test'])) {
        echo "Archivo recibido: " . $_FILES['test']['name'] . "<br>";
        echo "Tipo: " . $_FILES['test']['type'] . "<br>";
        echo "Error: " . $_FILES['test']['error'] . "<br>";
        
        $result = $cloudinary->uploadAudio($_FILES['test']['tmp_name'], 'test');
        echo "<pre>" . print_r($result, true) . "</pre>";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "<br>";
    echo "Línea: " . $e->getLine() . "<br>";
    echo "Archivo: " . $e->getFile() . "<br>";
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="test" accept="audio/*">
    <button type="submit">Test Upload</button>
</form>