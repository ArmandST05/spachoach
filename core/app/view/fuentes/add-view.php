<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén los datos del formulario
    $titulo = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $subtitulo = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $texto = isset($_POST['texto']) ? $_POST['texto'] : ''; // Campo adicional para el texto
    $file_path = ''; // Aquí almacenaremos la ruta del archivo

    // Directorio donde se guardarán los archivos subidos
    $uploadFileDir = realpath(dirname(__FILE__)) . '/uploaded_files/';
    if (!file_exists($uploadFileDir)) {
        mkdir($uploadFileDir, 0775, true);
    }

    // Manejo de la carga del archivo
    if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file_path']['tmp_name'];
        $fileName = $_FILES['file_path']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validar la extensión del archivo
        $allowedExtensions = array('pdf', 'jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedExtensions)) {
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $file_path = 'uploaded_files/' . $fileName; // Guarda la ruta relativa del archivo en la base de datos
            } else {
                echo 'Error al mover el archivo: ' . error_get_last()['message'];
            }
        } else {
            echo 'Solo se permiten archivos PDF e imágenes (pdf, jpg, jpeg, png, gif).';
        }
    }

    // Crea una instancia del modelo y asigna los datos
    $fuentes = new FuenteData();
    $fuentes->titulo = $titulo;
    $fuentes->subtitulo = $subtitulo;
    $fuentes->texto = $texto; // Asigna el texto
    $fuentes->file_path = $file_path; // Asigna la ruta del archivo

    // Agrega el registro a la base de datos
    $fuentes->add();

    // Redirige a la misma página para actualizar la vista
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Fuente</title>
    <!-- Enlace a los estilos de Bootstrap -->
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
        <form id="upload-form" action="" method="post" enctype="multipart/form-data">
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

            <div class="form-group">
                <label for="file_path">Subir Archivo:</label>
                <input type="file" id="file_path" name="file_path" class="form-control-file" accept=".pdf, .jpg, .jpeg, .png, .gif">
                <div id="progress-container" class="mt-2" style="display: none;">
                    <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    <span id="progress-text">0%</span>
                </div>
            </div>

            <button type="submit" class="btn"  style="background-color: #757575; color:azure">Agregar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('upload-form');
        var progressContainer = document.getElementById('progress-container');
        var progressBar = document.getElementById('progress-bar');
        var progressText = document.getElementById('progress-text');
        
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Evita el envío del formulario

            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);

            xhr.upload.onprogress = function (e) {
                if (e.lengthComputable) {
                    var percentComplete = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percentComplete + '%';
                    progressBar.setAttribute('aria-valuenow', percentComplete);
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

            xhr.send(formData);
        });
    });
    </script>
</body>
</html>
