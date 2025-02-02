<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$titulo = $_POST['titulo'];
$subtitulo = $_POST['subtitulo'];
$texto = $_POST['texto'];

// Manejar el archivo PDF si se subió uno nuevo
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == UPLOAD_ERR_OK) {
    $pdf_path = 'uploads/' . basename($_FILES['pdf']['name']);
    move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf_path);
} else {
    $pdf_path = $_POST['existing_pdf']; // Mantener el archivo anterior si no se sube uno nuevo
}

// Actualizar en la base de datos
$feedback = new FeedbackData();
$feedback->id = $id;
$feedback->titulo = $titulo;
$feedback->subtitulo = $subtitulo;
$feedback->texto = $texto;
$feedback->pdf_path = $pdf_path;

if ($feedback->update()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
