<?php
// Recupera el registro con id = 1
$glosario = GlosarioData::getById(1);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación</title>
    
    <!-- Bootstrap CSS -->
    
    <style>
        .pdf-viewer {
            width: 100%;
            height: 1000px; /* Ajusta la altura según tus necesidades */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
    <a href="./?view=glosario/edit">
        <button type="button" class="btn" style="background-color: black; color: white;" >Editar</button>
        </a>
        <?php if ($glosario): ?>
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title"><?php echo htmlspecialchars($glosario->titulo); ?></h1>
                    <h3 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($glosario->subtitulo); ?></h3>
                    <p class="card-text"><?php echo htmlspecialchars($glosario->texto); ?></p>
                </div>
                <div class="pdf-viewer">
                    <embed src="<?php echo htmlspecialchars($glosario->pdf_path); ?>" type="application/pdf" width="100%" height="100%">
                </div>
            </div>
        <?php else: ?>
            <p>No se encontró la guía.</p>
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
