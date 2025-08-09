<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Evaluación con PDF</title>
    <link rel="stylesheet" href="/englishdemo/assets/css/styles_kids.css">
    <style>
        .upload-area {
            border: 2px dashed #4ECDC4;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin: 20px 0;
            background: #f8f9fa;
        }
        .upload-area.dragover {
            background: #e8f5f4;
            border-color: #27AE60;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #2C3E50;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #4ECDC4;
            border-radius: 8px;
            font-size: 1rem;
        }
        .btn-upload {
            background: #27AE60;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
        }
        .pdf-preview {
            margin: 20px 0;
            padding: 15px;
            background: #e8f5f4;
            border-radius: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📄 Crear Evaluación con PDF</h1>
            <a href="?controller=teacher&action=dashboard" class="btn-back">← Volver</a>
        </div>

        <form method="POST" action="?controller=teacher&action=guardarEvaluacionPdf">
            <div class="form-group">
                <label>Título de la Evaluación:</label>
                <input type="text" name="titulo" required>
            </div>
            
            <div class="form-group">
                <label>Descripción:</label>
                <textarea name="descripcion" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Fecha:</label>
                <input type="date" name="fecha" required>
            </div>
            
            <div class="form-group">
                <label>Tiempo límite (minutos):</label>
                <input type="number" name="tiempo_limite" value="60" min="1">
            </div>
            
            <div class="form-group">
                <label>Puntos totales:</label>
                <input type="number" name="puntos_total" value="100" min="1">
            </div>

            <div class="upload-area" id="uploadArea">
                <h3>📎 Subir PDF de la Evaluación</h3>
                <p>Arrastra el archivo aquí o haz clic para seleccionar</p>
                <input type="file" id="pdfFile" accept=".pdf" style="display: none;">
                <button type="button" class="btn-upload" onclick="document.getElementById('pdfFile').click()">
                    Seleccionar PDF
                </button>
            </div>

            <div class="pdf-preview" id="pdfPreview">
                <h4>✅ PDF Subido:</h4>
                <p id="pdfName"></p>
                <a id="pdfLink" href="#" target="_blank">Ver PDF</a>
                <input type="hidden" name="archivo_pdf" id="archivoPdfUrl">
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <button type="submit" class="big-btn start" id="submitBtn" disabled>
                    💾 Crear Evaluación
                </button>
                <p><small>El PDF se guardará en la base de datos con la evaluación</small></p>
            </div>
            
            <!-- Debug info -->
            <div id="debugInfo" style="background: #f0f0f0; padding: 10px; margin: 10px 0; display: none;">
                <h4>Debug Info:</h4>
                <p>PDF URL: <span id="debugUrl"></span></p>
            </div>
        </form>
    </div>

    <script>
    const uploadArea = document.getElementById('uploadArea');
    const pdfFile = document.getElementById('pdfFile');
    const pdfPreview = document.getElementById('pdfPreview');
    const submitBtn = document.getElementById('submitBtn');

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0 && files[0].type === 'application/pdf') {
            handleFile(files[0]);
        }
    });

    pdfFile.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });

    function handleFile(file) {
        if (file.type !== 'application/pdf') {
            alert('Solo se permiten archivos PDF');
            return;
        }

        const formData = new FormData();
        formData.append('evaluacion_pdf', file);

        // Mostrar loading
        uploadArea.innerHTML = '<h3>⏳ Subiendo PDF...</h3>';

        fetch('/englishdemo/upload_direct.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Mostrar preview
                document.getElementById('pdfName').textContent = file.name;
                document.getElementById('pdfLink').href = result.url;
                document.getElementById('archivoPdfUrl').value = result.url;
                pdfPreview.style.display = 'block';
                submitBtn.disabled = false;
                
                // Debug
                document.getElementById('debugUrl').textContent = result.url;
                document.getElementById('debugInfo').style.display = 'block';
                
                // Restaurar upload area
                uploadArea.innerHTML = `
                    <h3>✅ PDF Subido Correctamente</h3>
                    <p>Archivo: ${file.name}</p>
                `;
            } else {
                alert('Error: ' + result.error);
                // Restaurar upload area
                uploadArea.innerHTML = `
                    <h3>📎 Subir PDF de la Evaluación</h3>
                    <p>Arrastra el archivo aquí o haz clic para seleccionar</p>
                    <button type="button" class="btn-upload" onclick="document.getElementById('pdfFile').click()">
                        Seleccionar PDF
                    </button>
                `;
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
    </script>
</body>
</html>