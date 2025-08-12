<?php
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Utils;

class CloudinaryManager {
    
    public function __construct() {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => 'dszrfmjri',
                'api_key' => '281486293299224',
                'api_secret' => 'LpZXYn-GkbidycEx3MPZCuMo4Rk'
            ],
            'url' => [
                'secure' => true
            ]
        ]);
        
        // Deshabilitar verificación SSL para desarrollo local
        if ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
            $context = stream_context_create([
                'http' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ]);
        }
    }
    
    public function uploadAudio($filePath, $fileName = null) {
        try {
            $uploadApi = new UploadApi();
            $result = $uploadApi->upload($filePath, [
                'resource_type' => 'video', // Para archivos de audio
                'folder' => 'english-learning/audios',
                'public_id' => $fileName,
                'overwrite' => true
            ]);
            
            return [
                'success' => true,
                'url' => $result['secure_url'],
                'public_id' => $result['public_id']
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function uploadImage($filePath, $fileName = null) {
        try {
            $uploadApi = new UploadApi();
            $result = $uploadApi->upload($filePath, [
                'resource_type' => 'image',
                'folder' => 'english-learning/images',
                'public_id' => $fileName,
                'overwrite' => true
            ]);
            
            return [
                'success' => true,
                'url' => $result['secure_url'],
                'public_id' => $result['public_id']
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function uploadPdf($filePath, $fileName = null) {
        try {
            // Configurar cURL para desarrollo local
            $curlOptions = [];
            if ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
                $curlOptions = [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_TIMEOUT => 60
                ];
            }
            
            $uploadApi = new UploadApi();
            
            $options = [
                'resource_type' => 'raw',
                'folder' => 'english-learning/pdfs',
                'public_id' => $fileName,
                'overwrite' => true
            ];
            
            if (!empty($curlOptions)) {
                $options['curl'] = $curlOptions;
            }
            
            $result = $uploadApi->upload($filePath, $options);
            
            if (!$result || !isset($result['secure_url'])) {
                throw new Exception('Respuesta inválida de Cloudinary');
            }
            
            return [
                'success' => true,
                'url' => $result['secure_url'],
                'public_id' => $result['public_id'] ?? ''
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'Upload failed: ' . $e->getMessage()
            ];
        }
    }
    
    public function getSignedPdfUrl($publicId) {
        try {
            $url = Utils::cloudinaryUrl($publicId, [
                'resource_type' => 'raw',
                'type' => 'upload',
                'sign_url' => true,
                'expires_at' => time() + 3600 // 1 hora
            ]);
            return $url;
        } catch (Exception $e) {
            return null;
        }
    }
}
?>