<?php

// Verifica si el usuario está logueado
$get_name = 'Invitado'; // Valor por defecto
$user_type = ''; 

if (isset($_SESSION['user_id'])) {
    $user = UserData::getLoggedIn();
    if ($user) {
        $get_name = htmlspecialchars($user->name); 
        $user_type = $user->user_type;
    }
}



// Obtener el ID de la materia desde la URL
$materiaId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si el ID parece ser de un tema, buscar la materia correspondiente
if ($materiaId > 0) {
    $materia = MateriaData::getById($materiaId);
} elseif (isset($_GET['tema_id'])) {
    $tema = TemaData::getById(intval($_GET['tema_id']));
    if ($tema) {
        $materiaId = $tema->materia_id;
        $materia = MateriaData::getById($materiaId);
    }
} else {
    $materia = null;
}

if (!$materia) {
    echo "⚠️ Materia no encontrada.";
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
    <style>
        .card { border-radius: 8px; background-color: #808b96; color: #fff; margin-bottom: 20px; }
        .card-header { position: relative; padding: 15px; }
        .card-body { padding: 15px; }
        .edit-btn, .delete-btn { position: absolute; top: 10px; font-size: 18px; }
        .edit-btn { right: 80px; background-color: #5499c7; }
        .delete-btn { right: 30px; background-color: #2471a3; }
        .imgs { height: 100%; width: 100%; object-fit: cover; }
        body { zoom: 0.90; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Temas de la Materia: <?php echo htmlspecialchars($materia->nombre_materia); ?></h1>

        <?php if (!empty($temas)): ?>
            <div class="row">
                <?php foreach ($temas as $tema): ?>
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title"><?php echo htmlspecialchars($tema->nombre_tema); ?></h2>

                                <?php if ($user_type != 'a'): // Solo si el usuario no es alumno ?>
                                    <button class="btn edit-btn" onclick="window.location.href='./?view=diplomado/temas/edit&id=<?php echo $tema->id; ?>';">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    <form action="" method="post" style="display: inline;">
                                        <input type="hidden" name="id" value="<?php echo $tema->id; ?>">
                                        <button type="button" class="btn delete-btn" onclick="deleteTema(<?php echo $tema->id; ?>)">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>

                            <div class="card-body">
                                <h3 class="card-subtitle mb-2 text-muted" style="color: black;"><?php echo htmlspecialchars($tema->descripcion); ?></h3>
                                <h3 class="card-subtitle mb-2 text-muted">
    <a href="<?php echo htmlspecialchars($tema->link); ?>" target="_blank" style="color: black;">
        <?php echo htmlspecialchars($tema->link); ?>
    </a>
</h3>

                                <?php if ($tema->file_path): ?>
                                    <div class="mt-4">
                                        <h6>Vista Previa del Archivo:</h6>
                                        <?php 
                                        $fileExtension = strtolower(pathinfo($tema->file_path, PATHINFO_EXTENSION));
                                        if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])): ?>
                                            <img class="imgs" src="<?php echo htmlspecialchars($tema->file_path); ?>" alt="Vista previa">
                                        <?php elseif ($fileExtension === 'pdf'): ?>
                                            <embed src="<?php echo htmlspecialchars($tema->file_path); ?>" type="application/pdf" width="100%" height="600px">
                                        <?php elseif (in_array($fileExtension, ['mp4', 'avi', 'mkv'])): ?>
                                            <div class="video-container">
                                                <div class="video-item">
                                                    <video width="100%" height="600px" controls>
                                                        <source src="<?php echo htmlspecialchars($tema->file_path); ?>" type="video/<?php echo $fileExtension; ?>">
                                                    </video>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <p>Vista previa no disponible.</p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No hay temas disponibles.</p>
        <?php endif; ?>
    </div>
</body>
<script>
function deleteTema(temaId) {
    const swalWithBootstrapButtons = Swal.mixin({
        buttonsStyling: true
    });

    swalWithBootstrapButtons.fire({
        title: '¿Estás seguro de eliminar el tema?',
        text: "¡No podrás revertirlo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: '¡No, cancelarlo!',
        reverseButtons: true
    }).then((result) => {
        if (result.value === true) {
            window.location.href = "index.php?action=temas/delete-by-details&id=" + temaId;
        }
    });
}

</script>
</html>
