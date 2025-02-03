<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar que los campos del formulario están disponibles
    if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['texto'])) {
        // Obtener los datos del formulario
        $titulo = $_POST['nombre'];
        $subtitulo = $_POST['descripcion'];
        $texto = $_POST['texto'];
        $file_path = ''; // Para la ruta del archivo, la inicializamos en blanco

        // Si el archivo fue cargado, gestionarlo
        if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['file_path']['tmp_name'];
            $fileName = $_FILES['file_path']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validación de la extensión del archivo
            $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileExtension, $allowedExtensions)) {
                // Directorio de subida
                $uploadFileDir = realpath(dirname(__FILE__)) . '/uploaded_files/';
                if (!file_exists($uploadFileDir)) {
                    mkdir($uploadFileDir, 0775, true);
                }

                // Ruta de destino para guardar el archivo
                $dest_path = $uploadFileDir . $fileName;
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $file_path = 'uploaded_files/' . $fileName; // Asigna la ruta relativa del archivo
                }
            } else {
                echo 'Error: Solo se permiten archivos PDF, JPG, JPEG, PNG, GIF.';
            }
        }

        // Aquí agregaríamos la lógica para la inserción de datos en la base de datos
        // Asegúrate de tener tu conexión a la base de datos configurada correctamente

        // Suponiendo que tienes una clase `FuenteData` con el método `add`:
        $fuentes = new FuenteData();
        $fuentes->titulo = $titulo;
        $fuentes->subtitulo = $subtitulo;
        $fuentes->texto = $texto;
        $fuentes->file_path = $file_path;

        $fuentes->add(); // Inserta los datos en la base de datos

        // Puedes redirigir a una página de éxito o recargar la página
        echo 'Datos agregados correctamente.';
    } else {
        echo 'Error: Faltan campos obligatorios en el formulario.';
    }
}
?>
