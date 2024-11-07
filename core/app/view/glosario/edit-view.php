<?php
// Establecer el ID fijo a 1
$id = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $texto = $_POST['texto'];
    $pdf_path = '';

    // Directorio donde se guardarán los archivos subidos
    $uploadFileDir = realpath(dirname(__FILE__)) . '/uploaded_pdfs/';
    if (!file_exists($uploadFileDir)) {
        mkdir($uploadFileDir, 0777, true);
    }

    // Manejo de la carga del archivo
    if (isset($_FILES['pdf_path']) && $_FILES['pdf_path']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pdf_path']['tmp_name'];
        $fileName = $_FILES['pdf_path']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validar la extensión del archivo
        $allowedExtensions = array('pdf');
        if (in_array($fileExtension, $allowedExtensions)) {
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $pdf_path = 'core/app/view/glosario/uploaded_pdfs/' . $fileName; // Guarda la ruta relativa del archivo en la base de datos
            } else {
                //echo 'Ocurrió un error al mover el archivo al directorio de destino.';
            }
        } else {
            //echo 'Solo se permiten archivos PDF.';
        }
    } else {
        // Si no se subió un nuevo archivo, conserva la ruta del archivo existente
        $glosario = GlosarioData::getById($id);
        $pdf_path = $glosario->pdf_path;
    }

    // Crea una instancia del modelo y asigna los datos
    $glosario = new GlosarioData();
    $glosario->id = $id;
    $glosario->titulo = $titulo;
    $glosario->subtitulo = $subtitulo;
    $glosario->texto = $texto;
    $glosario->pdf_path = $pdf_path;

    // Actualiza el registro en la base de datos
    $glosario->update();

    // Muestra un mensaje de éxito
    echo "<div class='alert alert-success' role='alert'>Actualización exitosa. <a href='./?view=glosario/index' class='btn btn-primary'>Ir a la página de inicio</a></div>";
} else {
    // Obtener los datos del glosario con id = 1
    $glosario = GlosarioData::getById($id);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Glosario</title>
    
    <!-- Bootstrap CSS -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Glosario</h1>
        <?php if (isset($glosario) && $glosario): ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="1">

            <div class="form-group">
                <label for="titulo">Título:</label>
                <textarea id="titulo" name="titulo" class="form-control" rows="2"><?php echo htmlspecialchars($glosario->titulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="subtitulo">Subtítulo:</label>
                <textarea id="subtitulo" name="subtitulo" class="form-control" rows="2"><?php echo htmlspecialchars($glosario->subtitulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea id="texto" name="texto" class="form-control" rows="10"><?php echo htmlspecialchars($glosario->texto); ?></textarea>
            </div>

            <div class="form-group">
                <label for="pdf_path">Seleccionar PDF</label>
                <input type="file" id="pdf_path" name="pdf_path" class="file-input">
                <label for="pdf_path" class="file-label">Seleccionar Archivo</label>
                
                <?php if ($glosario->pdf_path): ?>
                    <div class="mt-3">
                        <h4>Archivo Actual:</h4>
                        <a href="<?php echo htmlspecialchars($glosario->pdf_path); ?>" target="_blank">Ver PDF</a>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn" style="background-color: #757575; color:azure">Actualizar</button>
        </form>
        <?php else: ?>
            <p>No se encontró el glosario o no se proporcionó un ID válido.</p>
        <?php endif; ?>
    </div>

   <!-- Bootstrap JS and dependencies -->
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
