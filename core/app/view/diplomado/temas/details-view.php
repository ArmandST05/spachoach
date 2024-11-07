<?php
// Obtener el ID de la materia desde la URL
$materiaId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener la información de la materia
$materia = MateriaData::getById($materiaId);

if (!$materia) {
    echo "Materia no encontrada.";
    exit();
}

// Obtener los temas asociados a la materia
$temas = TemaData::getByMateriaId($materiaId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temas de la Materia: <?php echo htmlspecialchars($materia->nombre_materia); ?></title>
    <!-- Bootstrap CSS -->
    <style>
        .card {
            border-radius: 8px;
            background-color: #808b96; 
            color: #fff;
            margin-bottom: 20px;
        }
        .card-header {
            position: relative;
            padding: 15px;
        }
        .card-body {
            padding: 15px;
        }
        .card-header .edit-btn,
        .card-header .delete-btn {
            position: absolute;
            top: 10px;
            font-size: 18px;
        }
        .card-header .edit-btn {
            right: 80px;
            background-color: #5499c7;
        }
        .card-header .delete-btn {
            right: 30px;
            background-color: #2471a3;
        }
        .card-title, .card-subtitle, .card-text {
            margin-bottom: 15px;
        }
        .video-container {
            display: flex;
            justify-content: center;
        }
        .video-item {
            width: 100%;
            max-width: 750px;
        }
        .imgs {
    height: 100%; /* Altura fija */
    width: 100%; /* Ajusta el ancho para mantener proporciones */
    object-fit: cover; /* Ajusta la imagen para que cubra el espacio, manteniendo el aspecto */
} body {
    zoom: 0.90;
}
  </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Temas de la Materia: <?php echo htmlspecialchars($materia->nombre_materia); ?></h1>
        
        <?php if (count($temas) > 0): ?>
            <div class="row">
                <?php foreach ($temas as $tema): ?>
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title"><?php echo htmlspecialchars($tema->nombre_tema); ?></h2>
                                <!-- Botón de edición (opcional si se permite editar) -->
                                <button class="btn edit-btn" onclick="window.location.href='./?view=diplomado/temas/edit&id=<?php echo $tema->id; ?>';">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                                <!-- Formulario de eliminación -->
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $tema->id; ?>">
                                    <button type="submit" class="btn delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar este tema?');">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="card-body">
                                <h3 class="card-subtitle mb-2 text-muted" style="color: black;"><?php echo htmlspecialchars($tema->descripcion); ?></h3>

                                <?php if ($tema->file_path): ?>
                                    <div class="mt-4">
                                        <h6>Vista Previa del Archivo:</h6>
                                        <?php
                                        $fileExtension = strtolower(pathinfo($tema->file_path, PATHINFO_EXTENSION));
                                        ?>
                                        <?php if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])): ?>
                                            <img class="imgs" width="100%" src="<?php echo htmlspecialchars($tema->file_path); ?>" class="img-fluid" alt="Vista previa del archivo" style=" object-fit: cover;">
                                        <?php elseif (in_array($fileExtension, ['pdf'])): ?>
                                            <embed   src="<?php echo htmlspecialchars($tema->file_path); ?>" type="application/pdf" width="100%" height="600px">
                                        <?php elseif (in_array($fileExtension, ['mp4', 'avi', 'mkv'])): ?>
                                            <div class="video-container">
                                                <div class="video-item">
                                                    <video width="100%" height="600px" controls>
                                                        <source src="<?php echo htmlspecialchars($tema->file_path); ?>" type="video/<?php echo $fileExtension; ?>">
                                                        Tu navegador no soporta la etiqueta de video.
                                                    </video>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <p>Vista previa no disponible para este tipo de archivo.</p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No hay temas disponibles para esta materia.</p>
        <?php endif; ?>
        
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>
