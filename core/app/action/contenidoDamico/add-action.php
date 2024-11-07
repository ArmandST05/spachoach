<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén los datos del formulario
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
        $fileSize = $_FILES['video_path']['size'];
        $fileType = $_FILES['video_path']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validar la extensión del archivo
        $allowedExtensions = array('mp4', 'avi', 'mov', 'wmv');
        if (in_array($fileExtension, $allowedExtensions)) {
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $video_path = $dest_path; // Guarda la ruta del archivo en la base de datos
            } else {
                echo 'Ocurrió un error al mover el archivo al directorio de destino.';
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
    $contenido_dinamico->video_path = $video_path;

    // Agrega el registro a la base de datos
    $contenido_dinamico->add();

    // Redirige a la página principal
    header('Location: index.php');
    exit();
}
?>
