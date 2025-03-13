<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén los datos del formulario
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $texto = $_POST['texto'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $contenido_activo = 1;
    $video_path = '';

    // Validaciones de las fechas en el backend
    if (empty($fecha_inicio) || $fecha_inicio == '0000-00-00') {
        die('Error: La fecha de inicio no puede estar vacía ni ser 0.');
    }
    if (empty($fecha_fin) || $fecha_fin == '0000-00-00') {
        die('Error: La fecha de fin no puede estar vacía ni ser 0.');
    }
    if ($fecha_inicio > $fecha_fin) {
        die('Error: La fecha de inicio no puede ser mayor que la fecha de fin.');
    }

    // Directorio donde se guardarán los archivos subidos
    $uploadFileDir = realpath(dirname(__FILE__)) . '/uploaded_videos/';
    if (!file_exists($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }

    // Manejo de la carga del archivo
    if (isset($_FILES['video_path']) && $_FILES['video_path']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['video_path']['tmp_name'];
        $fileName = $_FILES['video_path']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validar la extensión del archivo
        $allowedExtensions = array('mp4', 'avi', 'mov', 'wmv');
        if (in_array($fileExtension, $allowedExtensions)) {
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $video_path = 'core/app/view/contenidoDinamico/uploaded_videos/' . $fileName;
            } else {
                echo 'Error al mover el archivo: ' . error_get_last()['message'];
            }
        } else {
            echo 'Solo se permiten archivos de video (mp4, avi, mov, wmv).';
        }
    }

    // Crea una instancia del modelo y asigna los datos
    $contenido_dinamico = new ContenidoDinamicoData();
    $contenido_dinamico->titulo = $titulo;
    $contenido_dinamico->subtitulo = $subtitulo;
    $contenido_dinamico->texto = $texto;
    $contenido_dinamico->fecha_inicio = $fecha_inicio;
    $contenido_dinamico->fecha_fin = $fecha_fin;
    $contenido_dinamico->contenido_activo = $contenido_activo;
    $contenido_dinamico->video_path = $video_path;

    // Agrega el registro a la base de datos
    $contenido_dinamico->add();
    
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
    <title>Agregar Contenido Dinámico</title>
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
        <h1 class="mb-4">Agregar Contenido Dinámico</h1>
        <form id="upload-form" action="" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <textarea id="titulo" name="titulo" class="form-control" rows="2" required></textarea>
            </div>

            <div class="form-group">
                <label for="subtitulo">Subtítulo:</label>
                <textarea id="subtitulo" name="subtitulo" class="form-control" rows="2" required></textarea>
            </div>

            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea id="texto" name="texto" class="form-control" rows="10" required></textarea>
            </div>

            <div class="form-group">
                <label for="fecha_inicio">Fecha de inicio de visualización:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="fecha_fin">Fecha de fin de visualización:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="video_path">Subir Video:</label>
                <input type="file" id="video_path" name="video_path" class="form-control-file">
                <div id="progress-container" class="mt-2" style="display: none;">
                    <br>
                    <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    <span id="progress-text">0%</span>
                </div>
            </div>

            <button type="submit" class="btn" style="background-color: black; color: aliceblue">Agregar</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Establece la fecha de inicio con el día actual
            let fechaActual = new Date().toISOString().split('T')[0];
            document.getElementById('fecha_inicio').value = fechaActual;
        });

        function validarFormulario() {
            let fechaInicio = document.getElementById('fecha_inicio').value;
            let fechaFin = document.getElementById('fecha_fin').value;

            if (!fechaInicio || fechaInicio === '0000-00-00') {
                alert("La fecha de inicio no puede estar vacía ni ser 0.");
                return false;
            }
            if (!fechaFin || fechaFin === '0000-00-00') {
                alert("La fecha de fin no puede estar vacía ni ser 0.");
                return false;
            }
            if (fechaInicio > fechaFin) {
                alert("La fecha de inicio no puede ser mayor que la fecha de fin.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
