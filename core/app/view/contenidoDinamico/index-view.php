<?php
// Verifica si el usuario está logueado
if (isset($_SESSION['user_id'])) {
    // Obtiene el usuario logueado
    $user = UserData::getLoggedIn();
    
    // Verifica si se recuperó el usuario correctamente
    if ($user) {
        $get_name = htmlspecialchars($user->name); // Escapa el nombre para evitar XSS
        $user_type = $user->user_type; // Obtiene el tipo de usuario
    } else {
        $get_name = 'Desconocido'; // Valor por defecto si no se encuentra el usuario
        $user_type = ''; // Valor por defecto si no se encuentra el tipo de usuario
    }
} else {
    $get_name = 'Invitado'; // Valor por defecto si no hay usuario logueado
    $user_type = ''; // Valor por defecto si no hay usuario logueado
}

// Manejo de la eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);

        // Crea una instancia del modelo y elimina el registro
        $contenido_dinamico = new ContenidoDinamicoData();
        $contenido_dinamico->deleteById($id);

        // Redirige a la página principal
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
}

// Obtener los contenidos
$contenidos = ContenidoDinamicoData::getAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenido Dinámico</title>
    <style>
        /* Tus estilos CSS */
        .fixed-text {
            margin-bottom: 20px;
            font-size: large;
            text-align: justify;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .video-container {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            justify-content: center;
        }
        .video-item {
            align-items: center;
            flex: 0 0 auto;
            width: 100%;
            max-width: 750px;
            margin-right: 10px;
        }
        .card {
            border-radius: 8px;
            background-color: #808b96; 
            color: #fff;
            margin-bottom: 20px;
        }
        .card-header, .card-body {
            padding: 15px;
        }
        .progress-bar {
            width: 100%;
            margin-top: 10px;
            height: 10px;
            background-color: #ddd;
        }
        .progress-bar::-webkit-progress-bar {
            background-color: #ddd;
            border-radius: 4px;
        }
        .progress-bar::-webkit-progress-value {
            background-color: #5499c7;
            border-radius: 4px;
        }
        body {
            zoom: 0.90;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="header-container">
        <?php if ($user_type != 'a'): ?>
            <button type="button" class="btn" style="background-color: black; color:#fff;" onclick="window.location.href='./?view=contenidoDinamico/add';">NUEVO</button>
        <?php endif; ?>
    </div>

    <div class="row mt-4">
        <?php foreach ($contenidos as $contenido): ?>
            <?php
            $hoy = date("Y-m-d"); 
            $fecha_inicio_formateada = date("d/m/Y", strtotime($contenido->fecha_inicio)); 
            $fecha_fin_formateada = date("d/m/Y", strtotime($contenido->fecha_fin)); 
            ?>
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><?php echo htmlspecialchars($contenido->titulo); ?></h2>
                        <?php if ($user_type != 'a'): ?>
                            <button class="btn edit-btn" onclick="window.location.href='./?view=contenidoDinamico/edit&id=<?php echo $contenido->id; ?>';">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </button>
                            <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $contenido->id; ?>">
                                <button type="submit" class="btn delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar este contenido?');">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php if ($user_type != 'a' || ($hoy >= $contenido->fecha_inicio && $hoy <= $contenido->fecha_fin)) : ?>
                    <div class="card-body">
                        <p class="fechas">Disponible de: <?php echo nl2br(htmlspecialchars($contenido->fecha_inicio)) ?> hasta el: <?php echo nl2br(htmlspecialchars($contenido->fecha_fin)) ?></p>
                        <h3 class="card-subtitle mb-2 text-muted" style="color: black;"><?php echo htmlspecialchars($contenido->subtitulo); ?></h3>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($contenido->texto)); ?></p>
                        
                        <?php if (!empty($contenido->video_path)) : ?>
                            <div class="video-container">
                                <div class="video-item">
                                    <video width="100%" controls controlsList="nodownload" oncontextmenu="return false;" id="video_<?php echo $contenido->id; ?>">
                                        <source src="<?php echo htmlspecialchars($contenido->video_path); ?>" type="video/mp4">
                                        Tu navegador no soporta el elemento de video.
                                    </video>
                                    <progress id="progress_<?php echo $contenido->id; ?>" class="progress-bar" value="0" max="100"></progress>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="alert alert-info" role="alert">
                                No se ha subido ningún video.
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php foreach ($contenidos as $contenido): ?>
            const video = document.getElementById("video_<?php echo $contenido->id; ?>");
            const progress = document.getElementById("progress_<?php echo $contenido->id; ?>");

            // Actualizar el progreso durante la reproducción del video
            video.addEventListener("timeupdate", function() {
                const value = (video.currentTime / video.duration) * 100;
                progress.value = value;
            });

            // Reiniciar el progreso cuando el video termina
            video.addEventListener("ended", function() {
                progress.value = 0;
            });
        <?php endforeach; ?>
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
