<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $texto = $_POST['texto'];
    
    // Verificar si se ha subido un archivo PDF
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == UPLOAD_ERR_OK) {
        $pdf_path = 'uploads/' . basename($_FILES['pdf']['name']);
        move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf_path);
    } else {
        // Si no se sube un archivo, usar el valor anterior
        $pdf_path = $_POST['existing_pdf'];
    }

    // Crear una instancia del modelo y asignar los datos
    $feedback = new feedbackData();
    $feedback->id = $id;
    $feedback->titulo = $titulo;
    $feedback->subtitulo = $subtitulo;
    $feedback->texto = $texto;
    $feedback->pdf_path = $pdf_path;

    // Actualizar el registro en la base de datos
    $feedback->update();

    // Muestra un mensaje de éxito
} else {
    // Obtener los datos de la evaluación con el ID proporcionado
    $feedback = FeedbackData::getById(1);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Retroalimentación</title>
    <!-- Bootstrap CSS -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Retroalimentación</h1>
        <?php if (isset($feedback) && $feedback): ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($feedback->id); ?>">
            <input type="hidden" name="existing_pdf" value="<?php echo htmlspecialchars($feedback->pdf_path); ?>">

            <div class="form-group">
                <label for="titulo">Título:</label>
                <textarea id="titulo" name="titulo" class="form-control" rows="2"><?php echo htmlspecialchars($feedback->titulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="subtitulo">Subtítulo:</label>
                <textarea id="subtitulo" name="subtitulo" class="form-control" rows="2"><?php echo htmlspecialchars($feedback->subtitulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea id="texto" name="texto" class="form-control" rows="10"><?php echo htmlspecialchars($feedback->texto); ?></textarea>
            </div>

            <div class="form-group">
                <label for="pdf">Archivo PDF:</label>
                <input type="file" id="pdf" name="pdf" class="form-control">
                <?php if (!empty($feedback->pdf_path)): ?>
                    <a href="<?php echo htmlspecialchars($feedback->pdf_path); ?>" target="_blank">Ver archivo PDF actual</a>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn" style="background-color: #757575; color:azure">Actualizar</button>
        </form>
        <?php else: ?>
            <p>No se encontró la evaluación o no se proporcionó un ID válido.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
      <!-- Bootstrap JS and dependencies -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
