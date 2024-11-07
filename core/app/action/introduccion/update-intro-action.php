<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $texto = $_POST['texto'];

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
            // Directorio donde se guardarán los archivos subidos
            $uploadFileDir = './uploaded_files/';
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                echo 'Archivo subido exitosamente.';
            } else {
                echo 'Ocurrió un error al mover el archivo al directorio de destino.';
            }
        } else {
            echo 'Solo se permiten archivos PDF.';
        }
    } else {
        echo 'No se ha subido ningún archivo o ha ocurrido un error en la carga.';
    }

    // Actualiza los otros campos en la base de datos
    $introduccion = new IntroduccionData();
    $introduccion->id = $id;
    $introduccion->titulo = $titulo;
    $introduccion->subtitulo = $subtitulo;
    $introduccion->texto = $texto;
    $introduccion->pdf_path = isset($dest_path) ? $dest_path : '';

    $introduccion->update();
}
?>
