<?php
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryManager {
    
    public function __construct() {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => 'dszrfmjri', // Tu cloud name
                'api_key' => '281486293299224',
                'api_secret' => 'LpZXYn-GkbidycEx3MPZCuMo4Rk'
            ]
        ]);
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
            $uploadApi = new UploadApi();
            $result = $uploadApi->upload($filePath, [
                'resource_type' => 'raw',
                'folder' => 'english-learning/pdfs',
                'public_id' => $fileName,
                'format' => 'pdf',
                'type' => 'upload',
                'access_mode' => 'public',
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
    
    public function getSignedPdfUrl($publicId) {
        try {
            use Cloudinary\Utils;
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