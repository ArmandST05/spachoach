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
    <!-- Enlace a los estilos de Bootstrap -->
    <style>
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
            color: #fff; /* Texto en blanco */
            margin-bottom: 20px; /* Añadir margen en la parte inferior de cada card */
        }
        .card-header {
            position: relative;
            padding: 15px; /* Padding en el header de la card */
        }
        .card-body {
            padding: 15px; /* Padding en el body de la card */
        }
        .card-header .edit-btn,
        .card-header .delete-btn {
            position: absolute;
            top: 10px;
            font-size: 18px;
        }
        .card-header .edit-btn {
            margin-top: 20px;
            right: 80px; 
            background-color: #2471a3;
        }
        .card-header .delete-btn {
            margin-top: 20px;
            right: 30px; 
            background-color: #5499c7;
        }
        .card-title, .card-subtitle, .card-text {
            margin-bottom: 15px; /* Añadir margen en la parte inferior de los textos dentro de la card */
        }
        .fechas{
            text-align: right;
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
                $hoy = date("Y-m-d"); // Fecha actual
                $fecha_inicio_formateada = date("d/m/Y", strtotime($contenido->fecha_inicio)); // Formato dd/mm/aaaa
                $fecha_fin_formateada = date("d/m/Y", strtotime($contenido->fecha_fin)); // Formato dd/mm/aaaa
                ?>
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title"><?php echo htmlspecialchars($contenido->titulo); ?></h2>
                            <?php if ($user_type != 'a'): ?>
                                <button class="btn edit-btn" onclick="window.location.href='./?view=contenidoDinamico/edit&id=<?php echo $contenido->id; ?>';">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                                <!-- Formulario de eliminación -->
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
                        <?php if (!empty($contenido->fecha_inicio) && !empty($contenido->fecha_fin)) : ?>
                        <p class="fechas">Disponible de: <?php echo nl2br(htmlspecialchars($contenido->fecha_inicio)) ?> hasta el: <?php echo nl2br(htmlspecialchars($contenido->fecha_fin)) ?></p>
                        <?php endif; ?>

                            <h3 class="card-subtitle mb-2 text-muted" style="color: black;"><?php echo htmlspecialchars($contenido->subtitulo); ?></h3>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($contenido->texto)); ?></p>
                            <?php if (!empty($contenido->video_path)) : ?>
                                <div class="video-container">
                                    <div class="video-item">
                                        <video width="100%" controls>
                                            <source src="<?php echo htmlspecialchars($contenido->video_path); ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
