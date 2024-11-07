<?php
$introduccion = IntroduccionData::getById(1); // Usa el ID adecuado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alumnos</title>
    <style>
        p {
            text-align: justify;
            font-size: large;
        }
        body {
    zoom: 0.90;
}
    </style>
</head>

<body>
<div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?php echo htmlspecialchars($introduccion->titulo); ?></h2>
                <h5 class="card-subtitle text-muted"><?php echo nl2br(htmlspecialchars($introduccion->subtitulo)); ?></h5>
            </div>
            <div class="card-body">
                <p class="card-text"><?php echo nl2br(htmlspecialchars($introduccion->texto)); ?></p>
            </div>
            <?php if (!empty($introduccion->pdf_path)) : ?>
                <div class="card-footer">
                    <h5 class="card-title">Vista Previa del PDF</h5>
                    <embed src="<?php echo htmlspecialchars($introduccion->pdf_path); ?>" type="application/pdf" width="100%" height="400px" />
                    <?php if (!file_exists($introduccion->pdf_path)) : ?>
                        <div class="alert alert-warning" role="alert">
                            El archivo PDF no existe en la ruta especificada: <?php echo htmlspecialchars($introduccion->pdf_path); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="alert alert-info" role="alert">
                    No se ha subido ningún archivo PDF.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
