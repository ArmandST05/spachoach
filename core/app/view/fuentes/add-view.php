<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Fuente</title>
    <style>
        #progress-container {
            width: 100%;
            background-color: #e9ecef;
            border-radius: .25rem;
        }
        #progress-bar {
            width: 0;
            height: 1rem;
            transition: width .4s ease;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Fuente</h1>
        <form id="upload-form" method="post" enctype="multipart/form-data" action="index.php?action=fuentes/add">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea id="texto" name="texto" class="form-control" rows="5" required></textarea>
            </div>

           <!-- <div class="form-group">
                <label for="file_path">Subir Archivo:</label>
                <input type="file" id="file_path" name="file_path" class="form-control-file" accept=".pdf, .jpg, .jpeg, .png, .gif">
                <div id="progress-container" class="mt-2" style="display: none;">
                    <div id="progress-bar" class="progress-bar bg-succsess" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    <span id="progress-text">0%</span>
                </div>
            </div>
    -->
            <button type="submit" class="btn" style="background-color: #757575; color:azure">Agregar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
// Cuando se envía el formulario
form.addEventListener('submit', function (e) {
    e.preventDefault(); // Evita el envío del formulario

    var formData = new FormData(form);
    console.log("FormData enviado:", formData); // Muestra los datos en consola

    // Verificamos que los datos están correctos
    for (var pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);

    xhr.upload.onprogress = function (e) {
        if (e.lengthComputable) {
            var percentComplete = Math.round((e.loaded / e.total) * 100);
            progressBar.style.width = percentComplete + '%';
            progressText.textContent = percentComplete + '%';
            progressContainer.style.display = 'block';
        }
    };

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Carga exitosa
            window.location.reload(); // Recarga la página
        } else {
            // Manejo de errores
            console.error('Error en la carga:', xhr.statusText);
        }
    };

    xhr.onerror = function () {
        console.error('Error en la solicitud.');
    };

    xhr.send(formData); // Envia el formulario usando AJAX
});

    </script>
</body>
</html>
