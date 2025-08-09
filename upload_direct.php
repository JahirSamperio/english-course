<?php
// Upload directo sin autenticación
require_once 'vendor/autoload.php';
require_once 'config/CloudinaryConfig.php';

header('Content-Type: application/json');

try {
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
            
            $fileName = 'evaluacion_' . time() . '_' . pathinfo($file['name'], PATHINFO_FILENAME) . '.pdf';
            $result = $cloudinary->uploadPdf($file['tmp_name'], $fileName);
            echo json_encode($result);
            exit;
        }
    }
    
    echo json_encode(['success' => false, 'error' => 'No se recibió archivo']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
}
?>