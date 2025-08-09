<!DOCTYPE html>
<html>
<head>
    <title>Test Cloudinary Upload</title>
    <style>
        body { font-family: Arial; margin: 50px; }
        .upload-form { border: 1px solid #ddd; padding: 20px; margin: 20px 0; }
        input[type="file"] { margin: 10px 0; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .result { margin: 20px 0; padding: 10px; background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Test Cloudinary Upload</h1>
    
    <div class="upload-form">
        <h3>Subir Audio</h3>
        <form action="?controller=file&action=uploadAudio" method="POST" enctype="multipart/form-data">
            <input type="file" name="audio" accept="audio/*" required>
            <button type="submit">Subir Audio</button>
        </form>
    </div>
    
    <div class="upload-form">
        <h3>Subir Imagen</h3>
        <form action="?controller=file&action=uploadImage" method="POST" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">Subir Imagen</button>
        </form>
    </div>
    
    <div class="result">
        <h3>Instrucciones:</h3>
        <p>1. Selecciona un archivo de audio (.mp3, .wav) o imagen (.jpg, .png)</p>
        <p>2. Haz clic en "Subir"</p>
        <p>3. El archivo se subirá a Cloudinary y recibirás la URL</p>
    </div>
    
    <script>
    // Manejar respuesta AJAX
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('¡Archivo subido exitosamente!\nURL: ' + result.url);
            } else {
                alert('Error: ' + result.error);
            }
        });
    });
    </script>
</body>
</html>