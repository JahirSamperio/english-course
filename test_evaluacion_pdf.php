<!DOCTYPE html>
<html>
<head>
    <title>Test Evaluación PDF</title>
</head>
<body>
    <h1>Test: Crear Evaluación con PDF</h1>
    
    <form id="testForm">
        <h3>1. Subir PDF</h3>
        <input type="file" id="pdfFile" accept=".pdf">
        <button type="button" onclick="uploadPdf()">Subir PDF</button>
        
        <div id="pdfResult"></div>
        
        <h3>2. Crear Evaluación</h3>
        <input type="text" id="titulo" placeholder="Título" value="Test Evaluación">
        <input type="date" id="fecha" value="<?= date('Y-m-d') ?>">
        <input type="hidden" id="pdfUrl">
        
        <button type="button" onclick="crearEvaluacion()" id="btnCrear" disabled>Crear Evaluación</button>
        
        <div id="evaluacionResult"></div>
    </form>

    <script>
    function uploadPdf() {
        const file = document.getElementById('pdfFile').files[0];
        if (!file) {
            alert('Selecciona un PDF');
            return;
        }

        const formData = new FormData();
        formData.append('evaluacion_pdf', file);

        fetch('/englishdemo/?controller=file&action=uploadEvaluacionPdf', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            document.getElementById('pdfResult').innerHTML = 
                '<h4>Resultado PDF:</h4><pre>' + JSON.stringify(result, null, 2) + '</pre>';
            
            if (result.success) {
                document.getElementById('pdfUrl').value = result.url;
                document.getElementById('btnCrear').disabled = false;
                alert('PDF subido: ' + result.url);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }

    function crearEvaluacion() {
        const data = {
            titulo: document.getElementById('titulo').value,
            descripcion: 'Test evaluación con PDF',
            fecha: document.getElementById('fecha').value,
            tiempo_limite: 60,
            puntos_total: 100,
            archivo_pdf: document.getElementById('pdfUrl').value
        };

        const formData = new FormData();
        Object.keys(data).forEach(key => {
            formData.append(key, data[key]);
        });

        fetch('/englishdemo/?controller=teacher&action=guardarEvaluacionPdf', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            document.getElementById('evaluacionResult').innerHTML = 
                '<h4>Resultado Evaluación:</h4><pre>' + result + '</pre>';
            alert('Evaluación creada - revisa la base de datos');
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
    </script>
</body>
</html>