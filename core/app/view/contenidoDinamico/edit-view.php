<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén los datos del formulario
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $texto = $_POST['texto'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
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
                $video_path = 'core/app/view/contenidoDinamico/uploaded_videos/' . $fileName;
            } else {
                echo 'Ocurrió un error al mover el archivo al directorio de destino.';
            }
        } else {
            echo 'Solo se permiten archivos de video (mp4, avi, mov, wmv).';
        }
    } else {
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
    $contenido_dinamico->fecha_inicio = $fecha_inicio;
    $contenido_dinamico->fecha_fin = $fecha_fin;
    $contenido_dinamico->video_path = $video_path;

    // Actualiza el registro en la base de datos
    $contenido_dinamico->update();

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
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Contenido Dinámico</h1>
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
                <label for="fecha_inicio">Fecha de inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?php echo htmlspecialchars($contenido_dinamico->fecha_inicio); ?>">
            </div>

            <div class="form-group">
                <label for="fecha_fin">Fecha de fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="<?php echo htmlspecialchars($contenido_dinamico->fecha_fin); ?>">
            </div>

            <div class="form-group">
                <label for="video_path">Seleccionar Video</label>
                <input type="file" id="video_path" name="video_path" class="form-control">
                <?php if ($contenido_dinamico->video_path): ?>
                    <div class="mt-3">
                        <h4>Video Actual:</h4>
                        <video width="320" height="240" controls>
                            <source src="<?php echo htmlspecialchars($contenido_dinamico->video_path); ?>" type="video/mp4">
                            Tu navegador no soporta el elemento de video.
                        </video>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</body>
</html>
