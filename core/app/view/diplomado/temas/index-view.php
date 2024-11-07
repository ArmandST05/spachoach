<?php
// Manejo de solicitudes POST para agregar o actualizar un tema
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica si se está agregando un nuevo tema
    if (isset($_POST['add'])) {
        // Obtén los datos del formulario para agregar un nuevo tema
        $nombre_tema = $_POST['nombre_tema'];
        $descripcion = $_POST['descripcion'];
        $id_materia = $_POST['id_materia'];
        $file_path = '';

        // Directorio donde se guardarán los archivos subidos
        $uploadFileDir = realpath(dirname(__FILE__) . '/../../../view/diplomado/temas/uploaded_files/');
        if (!file_exists($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true); // Crea el directorio si no existe
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
                $dest_path = $uploadFileDir . DIRECTORY_SEPARATOR . $fileName;

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

        // Crea una instancia del modelo y asigna los datos
        $newTema = new TemaData();
        $newTema->nombre_tema = $nombre_tema;
        $newTema->descripcion = $descripcion;
        $newTema->id_materia = $id_materia;
        $newTema->file_path = $file_path;

        // Agrega el registro a la base de datos
        $newTema->add();
        header('Location: ./?view=diplomado/temas/index');
        exit();
    }

    // Verifica si se está actualizando un tema
    if (isset($_POST['update'])) {
        // Obtener datos para actualización
        $temaId = intval($_POST['id']);
        $nombre_tema = $_POST['nombre_tema'];
        $descripcion = $_POST['descripcion'];
        $id_materia = $_POST['id_materia'];
        $file_path = $_POST['current_file_path']; // Mantener archivo actual por defecto

        // Directorio donde se guardarán los archivos subidos
        $uploadFileDir = realpath(dirname(__FILE__) . '/../../../view/diplomado/temas/uploaded_files/');
        if (!file_exists($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true); // Crea el directorio si no existe
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
                $dest_path = $uploadFileDir . DIRECTORY_SEPARATOR . $fileName;

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

        header('Location: ./?view=diplomado/temas/index');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);

        // Crea una instancia del modelo y elimina el registro
        $tema = new TemaData();
        $tema->deleteById($id);

        // Redirige a la página actual para evitar el reenvío del formulario
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
}
// Obtiene todos los temas y materias desde la base de datos
$temas = TemaData::getAll();
$materias = MateriaData::getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temas</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Temas</h1>
        
        <!-- Formulario para agregar temas -->
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="add" value="1">
            <div class="row mb-4">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="nombre_tema" placeholder="Nombre del tema" required>
                </div>
                
                <div class="col-md-6">
                    <select class="form-control" name="id_materia" required>
                        <option value="">Seleccione la materia</option>
                        <?php foreach($materias as $materia): ?>
                            <option value="<?php echo $materia->id; ?>"><?php echo $materia->nombre_materia; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="row mb-4">
                <div class="col-md-6">
                    <textarea class="form-control" name="descripcion" placeholder="Descripción del tema" required></textarea>
                </div>
          
                <div class="col-md-6">
                    <input type="file" class="form-control" name="archivo"  >
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-block" style="background-color: #52768c; color: white;"    >Agregar Tema</button>
                </div>
            </div>
        </form>
        <br>                  
        <!-- Tabla de Temas -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Tema</th>
                    <th>Descripción</th>
                    <th>Materia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($temas) > 0): ?>
                    <?php foreach($temas as $tema): ?>
                        <tr>
                            <td><?php echo $tema->id; ?></td>
                            <td><?php echo htmlspecialchars($tema->nombre_tema); ?></td>
                            <td><?php echo htmlspecialchars($tema->descripcion); ?></td>
                            <td><?php echo htmlspecialchars(MateriaData::getById($tema->id_materia)->nombre_materia); ?></td>
                            <td>
                                <a href="./?view=diplomado/temas/edit&id=<?php echo $tema->id; ?>" class="btn btn-sm"  style="background-color: #479bd1; color: white;">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $tema->id; ?>">
                                <button type="submit" class="btn delete-btn" style="background-color: #2471a3; color: white;" onclick="return confirm('¿Estás seguro de que deseas eliminar este tema?');">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay temas disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
