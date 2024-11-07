<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén los datos del formulario
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $texto = $_POST['texto'];
    $video_path = '';

    // Directorio donde se guardarán los archivos subidos
    $uploadFileDir = realpath(dirname(__FILE__)) . '/uploaded_videos/';
    if (!file_exists($uploadFileDir)) {
        mkdir($uploadFileDir, 0777, true);
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
                $video_path = 'core/app/view/contenidoDinamico/uploaded_videos/' . $fileName; // Guarda la ruta relativa del archivo en la base de datos
            } else {
                echo 'Ocurrió un error al mover el archivo al directorio de destino.';
            }
        } else {
            echo 'Solo se permiten archivos de video (mp4, avi, mov, wmv).';
        }
    } else {
        // Si no se subió un nuevo video, conserva la ruta del video existente
        $contenido_dinamico = new ContenidoDinamicoData();
        $contenido_dinamico = $contenido_dinamico->getById($id);
        $video_path = $contenido_dinamico->video_path;
    }

    // Crea una instancia del modelo y asigna los datos
    $contenido_dinamico = new ContenidoDinamicoData();
    $contenido_dinamico->id = $id;
    $contenido_dinamico->titulo = $titulo;
    $contenido_dinamico->subtitulo = $subtitulo;
    $contenido_dinamico->texto = $texto;
    $contenido_dinamico->video_path = $video_path;

    // Actualiza el registro en la base de datos
    $contenido_dinamico->update();

    // Muestra un mensaje de éxito
    echo "<div class='alert alert-success' role='alert'>Actualización exitosa. <a href='./?view=contenidoDinamico/index' class='btn btn-primary'>Ir a la página de inicio</a></div>";
} else {
    $id = $_GET['id'];
    $contenido_dinamico = ContenidoDinamicoData::getById($id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contenido Dinámico</title>
    <!-- Enlace a los estilos de Bootstrap -->
</head>
<style>
        /* Oculta el campo de archivo original */
        .file-input {
            display: none;
        }

        /* Estilo personalizado del botón */
        .file-label {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        /* Estilo para mostrar el archivo seleccionado */
        .file-label:hover {
            background-color: #0056b3;
        }
        label{
            font-size: large;
        }
      
    </style>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Contenido Temático</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($contenido_dinamico->id); ?>">

            <div class="form-group">
                <label for="titulo">Título:</label>
                <textarea id="titulo" name="titulo" class="form-control" rows="2"><?php echo htmlspecialchars($contenido_dinamico->titulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="subtitulo">Subtítulo:</label>
                <textarea id="subtitulo" name="subtitulo" class="form-control" rows="2"><?php echo htmlspecialchars($contenido_dinamico->subtitulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea id="texto" name="texto" class="form-control" rows="10"><?php echo htmlspecialchars($contenido_dinamico->texto); ?></textarea>
            </div>

            <div class="form-group">
            <label for="video_path">Seleccionar Video</label>
            <input type="file" id="video_path" name="video_path" class="file-label">
                
                <?php if ($contenido_dinamico->video_path): ?>
                    <div class="mt-3">
                        <h4>Video Actual:</h4>
                        <video width="320" height="240" controls>
                            <source src="<?php echo htmlspecialchars($contenido_dinamico->video_path); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn" style="background-color: #757575; color:azure">Actualizar</button>
        </form>
    </div>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
