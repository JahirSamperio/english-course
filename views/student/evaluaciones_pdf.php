<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>📄 Mis Evaluaciones</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .evaluacion-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 15px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 5px solid #4ECDC4;
        }
        .evaluacion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .evaluacion-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2C3E50;
        }
        .evaluacion-fecha {
            background: #4ECDC4;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        .evaluacion-info {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        .info-item {
            background: #f8f9fa;
            padding: 8px 15px;
            border-radius: 10px;
            font-size: 0.9rem;
        }
        .pdf-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .btn-pdf {
            background: linear-gradient(45deg, #E74C3C, #C0392B);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .btn-pdf:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .btn-download {
            background: linear-gradient(45deg, #27AE60, #2ECC71);
        }
        .pdf-viewer {
            width: 100%;
            height: 600px;
            border: 2px solid #4ECDC4;
            border-radius: 10px;
            margin-top: 15px;
        }
        .no-evaluaciones {
            text-align: center;
            padding: 50px;
            color: #7F8C8D;
        }
    </style>
    <style>
        .logo-corner {
            position: fixed;
            top: 20px;
            left: 20px;
            background: linear-gradient(45deg, #4ECDC4, #45B7D1);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="logo-corner">📚 Learning English</div>
    <div class="container">
        <div class="header">
            <h1>📄 Mis Evaluaciones</h1>
            <a href="?controller=student&action=dashboard" class="btn-back">← Volver al Dashboard</a>
        </div>

        <?php if (empty($evaluaciones)): ?>
            <div class="no-evaluaciones">
                <h3>📭 No hay evaluaciones disponibles</h3>
                <p>Tu profesor aún no ha subido evaluaciones en PDF</p>
            </div>
        <?php else: ?>
            <?php foreach ($evaluaciones as $evaluacion): ?>
                <div class="evaluacion-card">
                    <div class="evaluacion-header">
                        <div class="evaluacion-title">
                            📋 <?= htmlspecialchars($evaluacion['titulo']) ?>
                        </div>
                        <div class="evaluacion-fecha">
                            📅 <?= date('d/m/Y', strtotime($evaluacion['fecha'])) ?>
                        </div>
                    </div>
                    
                    <div class="evaluacion-info">
                        <div class="info-item">
                            ⏱️ Tiempo: <?= $evaluacion['tiempo_limite'] ?> min
                        </div>
                        <div class="info-item">
                            🎯 Puntos: <?= $evaluacion['puntos_total'] ?>
                        </div>
                        <?php if ($evaluacion['descripcion']): ?>
                            <div class="info-item">
                                📝 <?= htmlspecialchars($evaluacion['descripcion']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($evaluacion['archivo_pdf']): ?>
                        <div class="pdf-actions">
                            <a href="#" onclick="verPDF('<?= $evaluacion['archivo_pdf'] ?>', '<?= htmlspecialchars($evaluacion['titulo']) ?>')" class="btn-pdf">
                                👁️ Ver PDF
                            </a>
                            <a href="/englishdemo/pdf_proxy.php?url=<?= urlencode($evaluacion['archivo_pdf']) ?>" target="_blank" class="btn-pdf btn-download" download="<?= htmlspecialchars($evaluacion['titulo']) ?>.pdf">
                                💾 Descargar
                            </a>
                        </div>
                        
                        <div id="viewer-<?= $evaluacion['id'] ?>" style="display: none;">
                            <iframe class="pdf-viewer" src="<?= $evaluacion['archivo_pdf'] ?>#toolbar=1&navpanes=1&scrollbar=1" type="application/pdf">
                                <p>Tu navegador no puede mostrar PDFs. 
                                <a href="<?= $evaluacion['archivo_pdf'] ?>" target="_blank">Haz clic aquí para descargar</a></p>
                            </iframe>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Modal para visualizador PDF -->
    <div id="pdfModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000;">
        <div style="position: relative; width: 90%; height: 90%; margin: 2.5% auto; background: white; border-radius: 10px; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 id="pdfTitle">📄 Evaluación</h3>
                <button onclick="cerrarPDF()" style="background: #E74C3C; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
                    ✖️ Cerrar
                </button>
            </div>
            <iframe id="pdfFrame" style="width: 100%; height: calc(100% - 60px); border: none; border-radius: 5px;"></iframe>
        </div>
    </div>

    <script>
    function verPDF(url, titulo) {
        document.getElementById('pdfTitle').textContent = '📄 ' + titulo;
        
        // Usar proxy para PDFs con extensión incorrecta
        const proxyUrl = '/englishdemo/pdf_proxy.php?url=' + encodeURIComponent(url);
        document.getElementById('pdfFrame').src = proxyUrl;
        
        document.getElementById('pdfModal').style.display = 'block';
    }

    function cerrarPDF() {
        document.getElementById('pdfModal').style.display = 'none';
        document.getElementById('pdfFrame').src = '';
    }

    // Cerrar modal con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarPDF();
        }
    });

    // Cerrar modal haciendo clic fuera
    document.getElementById('pdfModal').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarPDF();
        }
    });
    </script>
</body>
</html>