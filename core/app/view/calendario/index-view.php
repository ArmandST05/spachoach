<?php
// Recupera el registro con id = 1
$calendario = CalendarioData::getById(1);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de actividades</title>
    
    <!-- Bootstrap CSS -->
    
    <style>
        .img-cal {
            width: 100%;
            height: 100%; /* Ajusta la altura automáticamente para mantener la proporción de la imagen */
        }
        body {
    zoom: 0.90;
}
    </style>
</head>
<body>
    <div class="container mt-5">
        <?php if ($calendario): ?>
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title"><?php echo htmlspecialchars($calendario->titulo); ?></h1>
                    <h3 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($calendario->subtitulo); ?></h3>
                    <p class="card-text"><?php echo htmlspecialchars($calendario->texto); ?></p>
                    
                </div>
                <img class="img-cal" src="<?php echo htmlspecialchars($calendario->imagen_path); ?>" class="card-img-top" alt="Imagen de <?php echo htmlspecialchars($guia->titulo); ?>">

            </div>
        <?php else: ?>
            <p>No se encontró la iamgen</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
