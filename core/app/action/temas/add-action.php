<?php
$response = ["success" => false, "message" => "Ocurrió un error"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre_tema = $_POST['nombre_tema'];
    $id_materia = $_POST['id_materia'];
    $descripcion = trim($_POST['descripcion']); // Quita espacios innecesarios y respeta los saltos de línea
    $link = isset($_POST['link']) ? $_POST['link'] : null;
    $file_path = ''; // Inicializamos el file_path vacío

    // Directorio donde se guardarán los archivos subidos
    $uploadFileDir = realpath(dirname(__FILE__)) . '/uploaded_files/';
    if (!file_exists($uploadFileDir)) {
        mkdir($uploadFileDir, 0777, true); // Creamos el directorio si no existe
    }

    // Manejo de la carga del archivo
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['archivo']['tmp_name'];
        $fileName = $_FILES['archivo']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validar la extensión del archivo (tipos permitidos)
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx');
        if (in_array($fileExtension, $allowedExtensions)) {
            $dest_path = $uploadFileDir . $fileName; // Establecemos la ruta de destino

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $file_path = 'core/app/action/temas/uploaded_files/' . $fileName; // Guarda la ruta relativa del archivo
            } else {
                $response["message"] = 'Ocurrió un error al mover el archivo al directorio de destino.';
            }
        } else {
            $response["message"] = 'Solo se permiten archivos de imagen, PDF, Word y Excel.';
        }
    } else {
        // Si no se subió un nuevo archivo, conserva la ruta del archivo existente
        $file_path = ''; // Si no hay archivo nuevo, dejamos vacío
    }

    // Crear la instancia del modelo de Tema
    $tema = new TemaData();
    $tema->nombre_tema = $nombre_tema;
    $tema->id_materia = $id_materia;
    $tema->descripcion = $descripcion;
    $tema->file_path = $file_path;
    $tema->link = $link; // Guardar el enlace en la base de datos

    // Guardar los datos en la base de datos
    $id = $tema->add(); // Método que guarda el nuevo tema y devuelve el ID generado

    if ($id) {
        $materia = MateriaData::getById($id_materia);
        $response = [
            "success" => true,
            "id" => $id,
            "nombre_tema" => $nombre_tema,
            "descripcion" => $descripcion,
            "nombre_materia" => $materia->nombre_materia ?? "Desconocida",
            "file_path" => $file_path, // Retorna también la ruta del archivo
            "link" => $link
        ];
    } else {
        $response["message"] = "No se pudo guardar el tema.";
    }
}

echo json_encode($response);
exit;
