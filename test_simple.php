<!DOCTYPE html>
<html>
<head>
    <title>Test Cloudinary Upload</title>
</head>
<body>
    <h1>Test Cloudinary Upload</h1>
    
    <div>
        <h3>Subir Audio</h3>
        <input type="file" id="audioFile" accept="audio/*">
        <button onclick="uploadAudio()">Subir Audio</button>
    </div>
    
    <div>
        <h3>Subir Imagen</h3>
        <input type="file" id="imageFile" accept="image/*">
        <button onclick="uploadImage()">Subir Imagen</button>
    </div>
    
    <div>
        <h3>Subir PDF</h3>
        <input type="file" id="pdfFile" accept=".pdf">
        <button onclick="uploadPdf()">Subir PDF</button>
    </div>
    
    <div id="result"></div>
    
    <script>
    function uploadAudio() {
        const fileInput = document.getElementById('audioFile');
        const file = fileInput.files[0];
        
        if (!file) {
            alert('Selecciona un archivo');
            return;
        }
        
        const formData = new FormData();
        formData.append('audio', file);
        
        fetch('/englishdemo/upload_direct.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.text();
        })
        .then(text => {
            console.log('Response text:', text);
            try {
                const result = JSON.parse(text);
                document.getElementById('result').innerHTML = 
                    '<h3>Audio:</h3><pre>' + JSON.stringify(result, null, 2) + '</pre>';
                
                if (result.success) {
                    alert('¡Audio subido! URL: ' + result.url);
                } else {
                    alert('Error: ' + result.error);
                }
            } catch (e) {
                document.getElementById('result').innerHTML = '<h3>Error:</h3><pre>' + text + '</pre>';
                alert('Error de respuesta: ' + e.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
    
    function uploadImage() {
        const fileInput = document.getElementById('imageFile');
        const file = fileInput.files[0];
        
        if (!file) {
            alert('Selecciona una imagen');
            return;
        }
        
        const formData = new FormData();
        formData.append('image', file);
        
        fetch('/englishdemo/upload_direct.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.text();
        })
        .then(text => {
            console.log('Response text:', text);
            try {
                const result = JSON.parse(text);
                document.getElementById('result').innerHTML = 
                    '<h3>Imagen:</h3><pre>' + JSON.stringify(result, null, 2) + '</pre>';
                
                if (result.success) {
                    alert('¡Imagen subida! URL: ' + result.url);
                    document.getElementById('result').innerHTML += 
                        '<br><img src="' + result.url + '" style="max-width:300px;">';
                } else {
                    alert('Error: ' + result.error);
                }
            } catch (e) {
                document.getElementById('result').innerHTML = '<h3>Error:</h3><pre>' + text + '</pre>';
                alert('Error de respuesta: ' + e.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
    
    function uploadPdf() {
        const fileInput = document.getElementById('pdfFile');
        const file = fileInput.files[0];
        
        if (!file) {
            alert('Selecciona un PDF');
            return;
        }
        
        const formData = new FormData();
        formData.append('pdf', file);
        
        fetch('/englishdemo/upload_direct.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.text();
        })
        .then(text => {
            console.log('Response text:', text);
            try {
                const result = JSON.parse(text);
                document.getElementById('result').innerHTML = 
                    '<h3>PDF:</h3><pre>' + JSON.stringify(result, null, 2) + '</pre>';
                
                if (result.success) {
                    alert('¡PDF subido! URL: ' + result.url);
                    document.getElementById('result').innerHTML += 
                        '<br><a href="' + result.url + '" target="_blank">Ver PDF</a>';
                } else {
                    alert('Error: ' + result.error);
                }
            } catch (e) {
                document.getElementById('result').innerHTML = '<h3>Error:</h3><pre>' + text + '</pre>';
                alert('Error de respuesta: ' + e.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
    </script>
</body>
</html>