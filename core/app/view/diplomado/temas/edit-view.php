<?php
// Manejo de solicitudes POST para actualizar un tema existente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    // Obtener datos para actualización
    $temaId = intval($_POST['id']);
    $nombre_tema = $_POST['nombre_tema'];
    $descripcion = $_POST['descripcion'];
    $id_materia = $_POST['id_materia'];
    $file_path = $_POST['current_file_path']; // Mantener archivo actual por defecto

    // Directorio donde se guardarán los archivos subidos
    $uploadFileDir = realpath(dirname(__FILE__)) . '/uploaded_files/';
    if (!file_exists($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }

    // Manejo de la carga del archivo
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['archivo']['tmp_name'];
        $fileName = $_FILES['archivo']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validar la extensión del archivo
        $allowedExtensions = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'mp4', 'avi', 'mkv');
        if (in_array($fileExtension, $allowedExtensions)) {
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $file_path = 'core/app/view/diplomado/temas/uploaded_files/' . $fileName; // Guarda la ruta relativa del archivo en la base de datos
            } else {
                echo 'Error al mover el archivo: ' . error_get_last()['message'];
                exit();
            }
        } else {
            echo 'Solo se permiten archivos con extensiones: pdf, doc, docx, jpg, jpeg, png, mp4, avi, mkv.';
            exit();
        }
    }

    // Actualiza el tema en la base de datos
    $tema = TemaData::getById($temaId);
    if ($tema) {
        $tema->nombre_tema = $nombre_tema;
        $tema->descripcion = $descripcion;
        $tema->id_materia = $id_materia;
        $tema->file_path = $file_path;
        $tema->update();
    }

    Core::alert("¡Actualizado exitosamente!");
print "<script>window.location='index.php?view=diplomado/temas/index';</script>";
    exit();
}

// Manejo de solicitudes GET para obtener los datos del tema a editar
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $temaId = intval($_GET['id']);
    $tema = TemaData::getById($temaId);
    $materias = MateriaData::getAll(); // Asegura que estás obteniendo las materias correctamente

    if ($tema && $materias) {
        // Mostrar formulario de edición con los datos actuales del tema
        ?>

        <div class="container mt-5" style="max-width: 800px;">
            <h1 class="mb-4">Editar Tema</h1>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo $tema->id; ?>">
                <input type="hidden" name="current_file_path" value="<?php echo htmlspecialchars($tema->file_path); ?>">

                <div class="form-group">
                    <label for="nombre_tema">Nombre del Tema:</label>
                    <textarea id="nombre_tema" name="nombre_tema" class="form-control" rows="2"><?php echo htmlspecialchars($tema->nombre_tema); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="id_materia">Materia:</label>
                    <select id="id_materia" name="id_materia" class="form-control">
                        <?php foreach ($materias as $materia): ?>
                            <option value="<?php echo $materia->id; ?>" <?php echo $materia->id == $tema->id_materia ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($materia->nombre_materia); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" rows="5"><?php echo htmlspecialchars($tema->descripcion); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="archivo">Archivo:</label>
                    <input type="file" id="archivo" name="archivo" class="form-control-file">
                    <?php if ($tema->file_path): ?>
                        <small>Archivo actual: <?php echo htmlspecialchars($tema->file_path); ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Actualizar Tema</button>
                </div>
            </form>
        </div>

        <?php
    } else {
        echo "Tema o materias no encontrados.";
    }
}
?>
