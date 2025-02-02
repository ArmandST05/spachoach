<?php
$feedback = FeedbackData::getById(1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar contacto</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Editar Contacto</h1>

    <form id="editForm" enctype="multipart/form-data">
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

        <button type="submit" class="btn btn-dark">Actualizar</button>
    </form>

    <div id="responseMessage" class="mt-3"></div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("#editForm").submit(function(event) {
        event.preventDefault(); // Evita la recarga de la página

        var formData = new FormData(this); // Captura los datos del formulario

        $.ajax({
            url: "./?action=contacto/update", // Archivo PHP que procesará la actualización
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#responseMessage").html('<div class="alert alert-success">¡Actualización exitosa!</div>');
                setTimeout(function() {
                    window.location.href = "index.php?view=contacto/index";
                }, 2000); // Redirige después de 2 segundos
            },
            error: function() {
                $("#responseMessage").html('<div class="alert alert-danger">Ocurrió un error al actualizar.</div>');
            }
        });
    });
});
</script>

</body>
</html>
