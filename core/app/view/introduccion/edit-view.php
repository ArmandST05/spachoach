<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén los datos del formulario
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $texto = $_POST['texto'];
    $pdf_path = '';

    // Directorio donde se guardarán los archivos subidos
    $uploadFileDir = realpath(dirname(__FILE__)) . '/uploaded_files/';
    if (!file_exists($uploadFileDir)) {
        mkdir($uploadFileDir, 0777, true);
    }

    // Manejo de la carga del archivo
    if (isset($_FILES['pdf_path']) && $_FILES['pdf_path']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pdf_path']['tmp_name'];
        $fileName = $_FILES['pdf_path']['name'];
        $fileSize = $_FILES['pdf_path']['size'];
        $fileType = $_FILES['pdf_path']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validar la extensión del archivo
        $allowedExtensions = array('pdf');
        if (in_array($fileExtension, $allowedExtensions)) {
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Guarda la ruta relativa del archivo en la base de datos
                $pdf_path = 'core/app/view/introduccion/uploaded_files/' . $fileName;
            } else {
                echo 'Ocurrió un error al mover el archivo al directorio de destino.';
            }
        } else {
            echo 'Solo se permiten archivos PDF.';
        }
    }

    // Crea una instancia del modelo y asigna los datos
    $introduccion = new IntroduccionData();
    $introduccion->id = $id;
    $introduccion->titulo = $titulo;
    $introduccion->subtitulo = $subtitulo;
    $introduccion->texto = $texto;
    $introduccion->pdf_path = $pdf_path;

    // Actualiza el registro en la base de datos
    $introduccion->update();

    // Muestra un mensaje de éxito
    echo "<div class='alert alert-success' role='alert'>Actualización exitosa. <a href='./?view=introduccion/index' class='btn btn-primary'>Ir a la página de inicio</a></div>";
} else {
    $introduccion = IntroduccionData::getById(1);
}
?>
<style>
    body {
    zoom: 0.90;
}
</style>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Introducción</title>
    <!-- Enlace a los estilos de Bootstrap -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Introducción</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($introduccion->id); ?>">

            <div class="form-group">
                <label for="titulo">Título:</label>
                <textarea id="titulo" name="titulo" class="form-control" rows="2"><?php echo htmlspecialchars($introduccion->titulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="subtitulo">Subtítulo:</label>
                <textarea id="subtitulo" name="subtitulo" class="form-control" rows="2"><?php echo htmlspecialchars($introduccion->subtitulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea id="texto" name="texto" class="form-control" rows="10"><?php echo htmlspecialchars($introduccion->texto); ?></textarea>
            </div>

            <div class="form-group">
                <label for="pdf_path">Subir PDF:</label>
                <input type="file" id="pdf_path" name="pdf_path" class="form-control-file">
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
