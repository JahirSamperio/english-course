<?php
// Proxy para servir PDFs con headers correctos
if (!isset($_GET['url'])) {
    http_response_code(400);
    die('URL requerida');
}

$pdfUrl = $_GET['url'];

// Validar que sea una URL de Cloudinary
if (!str_contains($pdfUrl, 'cloudinary.com')) {
    http_response_code(403);
    die('URL no permitida');
}

// Obtener el contenido del PDF
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ]
    ]
]);

$pdfContent = file_get_contents($pdfUrl, false, $context);

if ($pdfContent === false) {
    http_response_code(404);
    die('PDF no encontrado');
}

// Enviar headers correctos
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="evaluacion.pdf"');
header('Content-Length: ' . strlen($pdfContent));
header('Cache-Control: public, max-age=3600');

// Enviar contenido
echo $pdfContent;
?>