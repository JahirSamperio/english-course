<?php
// Upload directo sin autenticación
error_reporting(0);
ini_set('display_errors', 0);

require_once 'vendor/autoload.php';
require_once 'config/CloudinaryConfig.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

try {
    if (!class_exists('CloudinaryManager')) {
        echo json_encode(['success' => false, 'error' => 'CloudinaryManager no encontrado']);
        exit;
    }
    
    $cloudinary = new CloudinaryManager();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Upload Audio
        if (isset($_FILES['audio'])) {
            $file = $_FILES['audio'];
            
            if ($file['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'error' => 'Error al subir archivo: ' . $file['error']]);
                exit;
            }
            
            $fileName = pathinfo($file['name'], PATHINFO_FILENAME);
            $result = $cloudinary->uploadAudio($file['tmp_name'], $fileName);
            echo json_encode($result);
            exit;
        }
        
        // Upload Image
        if (isset($_FILES['image'])) {
            $file = $_FILES['image'];
            
            if ($file['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'error' => 'Error al subir archivo: ' . $file['error']]);
                exit;
            }
            
            $fileName = pathinfo($file['name'], PATHINFO_FILENAME);
            $result = $cloudinary->uploadImage($file['tmp_name'], $fileName);
            echo json_encode($result);
            exit;
        }
        
        // Upload PDF
        if (isset($_FILES['pdf'])) {
            $file = $_FILES['pdf'];
            
            if ($file['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'error' => 'Error al subir archivo: ' . $file['error']]);
                exit;
            }
            
            $fileName = pathinfo($file['name'], PATHINFO_FILENAME);
            $result = $cloudinary->uploadPdf($file['tmp_name'], $fileName);
            echo json_encode($result);
            exit;
        }
        
        // Upload PDF para evaluaciones
        if (isset($_FILES['evaluacion_pdf'])) {
            $file = $_FILES['evaluacion_pdf'];
            
            if ($file['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'error' => 'Error al subir archivo: ' . $file['error']]);
                exit;
            }
            
            if (!file_exists($file['tmp_name'])) {
                echo json_encode(['success' => false, 'error' => 'Archivo temporal no encontrado']);
                exit;
            }
            
            $fileName = 'evaluacion_' . time() . '_' . pathinfo($file['name'], PATHINFO_FILENAME);
            $result = $cloudinary->uploadPdf($file['tmp_name'], $fileName);
            
            if (!$result) {
                echo json_encode(['success' => false, 'error' => 'Respuesta vacía de Cloudinary']);
                exit;
            }
            
            echo json_encode($result);
            exit;
        }
    }
    
    echo json_encode(['success' => false, 'error' => 'No se recibió archivo']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage(), 'trace' => $e->getTraceAsString()]);
} catch (Error $e) {
    echo json_encode(['success' => false, 'error' => 'Fatal Error: ' . $e->getMessage()]);
}

// Asegurar que siempre hay una respuesta
if (!headers_sent()) {
    echo json_encode(['success' => false, 'error' => 'No se procesó ningún archivo']);
}
?>