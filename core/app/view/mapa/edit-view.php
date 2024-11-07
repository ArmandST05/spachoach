<?php
// Establecer el ID fijo a 1
$id = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $texto = $_POST['texto'];
    $imagen_path = '';

    // Directorio donde se guardarán las imágenes subidas
    $uploadFileDir = realpath(dirname(__FILE__)) . '/uploaded_images/';
    if (!file_exists($uploadFileDir)) {
        mkdir($uploadFileDir, 0777, true);
    }

    // Manejo de la carga del archivo
    if (isset($_FILES['imagen_path']) && $_FILES['imagen_path']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagen_path']['tmp_name'];
        $fileName = $_FILES['imagen_path']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validar la extensión del archivo
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedExtensions)) {
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagen_path = 'core/app/view/guia/uploaded_images/' . $fileName; // Guarda la ruta relativa del archivo en la base de datos
            } else {
                echo 'Ocurrió un error al mover el archivo al directorio de destino.';
            }
        } else {
            echo 'Solo se permiten archivos de imagen (jpg, jpeg, png, gif).';
        }
    } else {
        // Si no se subió una nueva imagen, conserva la ruta de la imagen existente
        $guia = GuiaData::getById($id);
        $imagen_path = $guia->imagen_path;
    }

    // Crea una instancia del modelo y asigna los datos
    $guia = new GuiaData();
    $guia->id = $id;
    $guia->titulo = $titulo;
    $guia->subtitulo = $subtitulo;
    $guia->texto = $texto;
    $guia->imagen_path = $imagen_path;

    // Actualiza el registro en la base de datos
    $guia->update();

    // Muestra un mensaje de éxito
    echo "<div class='alert alert-black' role='alert'>Actualización exitosa. <a href='./?view=mapa/index' class='btn btn-primary'>Ir a la página de inicio</a></div>";
} else {
    // Obtener los datos de la guía con id = 1
    $guia = GuiaData::getById($id);
}
?>
<!DOCTYPE html>
<html lang="es">
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Guía</h1>
        <?php if (isset($guia) && $guia): ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="1">

            <div class="form-group">
                <label for="titulo">Título:</label>
                <textarea id="titulo" name="titulo" class="form-control" rows="2"><?php echo htmlspecialchars($guia->titulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="subtitulo">Subtítulo:</label>
                <textarea id="subtitulo" name="subtitulo" class="form-control" rows="2"><?php echo htmlspecialchars($guia->subtitulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea id="texto" name="texto" class="form-control" rows="10"><?php echo htmlspecialchars($guia->texto); ?></textarea>
            </div>

            <div class="form-group">
                <label for="imagen_path">Seleccionar Imagen</label>
                <input type="file" id="imagen_path" name="imagen_path" class="file-input">
                <label for="imagen_path" class="file-label">Seleccionar Archivo</label>
                
                <?php if ($guia->imagen_path): ?>
                    <div class="mt-3">
                        <h4>Imagen Actual:</h4>
                        <img src="<?php echo htmlspecialchars($guia->imagen_path); ?>" height="40%" width="50%" class="img-fluid" alt="Imagen de <?php echo htmlspecialchars($guia->titulo); ?>">
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn" style="background-color: #757575; color:azure">Actualizar</button>
        </form>
        <?php else: ?>
            <p>No se encontró la guía o no se proporcionó un ID válido.</p>
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

