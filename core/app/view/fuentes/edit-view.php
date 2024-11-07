<?php

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $texto = $_POST['texto'];
    $file_path = '';

    // Obtener la fuente para actualizar
    $fuente = FuenteData::getById($id);

    // Manejo de la carga del archivo
    if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file_path']['tmp_name'];
        $fileName = $_FILES['file_path']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validar la extensión del archivo
        $allowedExtensions = array('pdf', 'jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedExtensions)) {
            // Directorio donde se guardarán los archivos subidos
            $uploadFileDir = realpath(dirname(__FILE__)) . '/uploaded_files/';
            if (!file_exists($uploadFileDir)) {
                mkdir($uploadFileDir, 775, true);
            }

            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $file_path = 'core/app/view/contenidoDinamico/uploaded_files/' . $fileName; // Guarda la ruta relativa del archivo en la base de datos
            } else {
                echo 'Error al mover el archivo: ' . error_get_last()['message'];
            }
        } else {
            echo 'Solo se permiten archivos PDF e imágenes (pdf, jpg, jpeg, png, gif).';
        }
    } else {
        // Mantener el archivo actual si no se subió uno nuevo
        $file_path = $fuente->file_path;
    }

    // Asigna los datos a la instancia del modelo
    $fuente->titulo = $titulo;
    $fuente->subtitulo = $subtitulo;
    $fuente->texto = $texto;
    $fuente->file_path = $file_path;

    // Actualiza el registro en la base de datos
    $fuente->update();

    // Muestra un mensaje de éxito
    echo "<div class='alert alert-success' role='alert'>Actualización exitosa. <a href='./?view=fuentes/index' class='btn btn-primary'>Ir a la página de inicio</a></div>";
} else {
    // Obtener los datos de la fuente con el ID proporcionado
    $fuente = FuenteData::getById($id);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Fuente</title>
    <!-- Bootstrap CSS -->
</head>
<body>
<div class="container mt-5">
        <h1 class="mb-4">Editar Fuente</h1>
        <?php if (isset($fuente) && $fuente): ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($fuente->id); ?>">

            <div class="form-group">
                <label for="titulo">Título:</label>
                <textarea id="titulo" name="titulo" class="form-control" rows="2"><?php echo htmlspecialchars($fuente->titulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="subtitulo">Subtítulo:</label>
                <textarea id="subtitulo" name="subtitulo" class="form-control" rows="2"><?php echo htmlspecialchars($fuente->subtitulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea id="texto" name="texto" class="form-control" rows="10"><?php echo htmlspecialchars($fuente->texto); ?></textarea>
            </div>

            <div class="form-group">
                <label for="file_path">Subir Archivo:</label>
                <input type="file" id="file_path" name="file_path" class="form-control-file" accept=".pdf, .jpg, .jpeg, .png, .gif">
                
                <?php if ($fuente->file_path): ?>
                <div class="mt-2">
                    <!-- Verificar el tipo de archivo y generar la vista previa -->
                    <?php
                    $file_extension = pathinfo($fuente->file_path, PATHINFO_EXTENSION);
                    if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                        <!-- Vista previa de la imagen -->
                        <img src="<?php echo htmlspecialchars($fuente->file_path); ?>" alt="Vista previa de la imagen" style="max-width: 100%; height: auto;">
                    <?php elseif ($file_extension === 'pdf'): ?>
                        <!-- Vista previa del PDF -->
                        <embed src="<?php echo htmlspecialchars($fuente->file_path); ?>" type="application/pdf" width="100%" height="500px">
                    <?php else: ?>
                        <!-- Enlace si el tipo de archivo no es compatible para vista previa -->
                        <a href="<?php echo htmlspecialchars($fuente->file_path); ?>" target="_blank">Ver archivo actual</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn" style="background-color: #757575; color:azure">Actualizar</button>
        </form>
        <?php else: ?>
            <p>No se encontró la fuente o no se proporcionó un ID válido.</p>
        <?php endif; ?>
    </div>
   <!-- Scripts de Bootstrap -->
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
