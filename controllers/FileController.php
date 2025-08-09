<?php
require_once 'config/CloudinaryConfig.php';

class FileController {
    private $cloudinary;
    
    public function __construct() {
        try {
            $this->cloudinary = new CloudinaryManager();
        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'error' => 'Error de configuración: ' . $e->getMessage()]);
        }
    }
    
    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    public function uploadAudio() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['audio'])) {
                $file = $_FILES['audio'];
                
                // Validar archivo
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $this->jsonResponse(['success' => false, 'error' => 'Error al subir archivo: ' . $file['error']]);
                }
                
                // Validar tipo de archivo
                $allowedTypes = ['audio/mpeg', 'audio/wav', 'audio/mp3'];
                if (!in_array($file['type'], $allowedTypes)) {
                    $this->jsonResponse(['success' => false, 'error' => 'Tipo no permitido: ' . $file['type']]);
                }
                
                // Subir a Cloudinary
                $fileName = pathinfo($file['name'], PATHINFO_FILENAME);
                $result = $this->cloudinary->uploadAudio($file['tmp_name'], $fileName);
                
                $this->jsonResponse($result);
            }
            
            $this->jsonResponse(['success' => false, 'error' => 'No se recibió archivo']);
        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    public function uploadImage() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
                $file = $_FILES['image'];
                
                // Validar archivo
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $this->jsonResponse(['success' => false, 'error' => 'Error al subir archivo: ' . $file['error']]);
                }
                
                // Validar tipo de archivo
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($file['type'], $allowedTypes)) {
                    $this->jsonResponse(['success' => false, 'error' => 'Tipo no permitido: ' . $file['type']]);
                }
                
                // Subir a Cloudinary
                $fileName = pathinfo($file['name'], PATHINFO_FILENAME);
                $result = $this->cloudinary->uploadImage($file['tmp_name'], $fileName);
                
                $this->jsonResponse($result);
            }
            
            $this->jsonResponse(['success' => false, 'error' => 'No se recibió archivo']);
        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    public function uploadEvaluacionPdf() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['evaluacion_pdf'])) {
                $file = $_FILES['evaluacion_pdf'];
                
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $this->jsonResponse(['success' => false, 'error' => 'Error al subir archivo: ' . $file['error']]);
                }
                
                $allowedTypes = ['application/pdf'];
                if (!in_array($file['type'], $allowedTypes)) {
                    $this->jsonResponse(['success' => false, 'error' => 'Solo se permiten archivos PDF']);
                }
                
                $fileName = 'evaluacion_' . time() . '_' . pathinfo($file['name'], PATHINFO_FILENAME) . '.pdf';
                $result = $this->cloudinary->uploadPdf($file['tmp_name'], $fileName);
                
                $this->jsonResponse($result);
            }
            
            $this->jsonResponse(['success' => false, 'error' => 'No se recibió archivo']);
        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }
}
?>