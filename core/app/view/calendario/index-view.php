<?php
// Recupera el registro con id = 1
$calendario = CalendarioData::getById(1);
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
    <div class="header-container">
           
           <?php if ($user_type != 'a'): ?>
               <button type="button" class="btn" style="background-color: black; color:#fff;" onclick="window.location.href='./?view=calendario/edit';">Editar</button>
           <?php endif; ?>
       </div>

        <?php if ($calendario): ?>
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title"><?php echo htmlspecialchars($calendario->titulo); ?></h1>
                    <h3 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($calendario->subtitulo); ?></h3>
                    <p class="card-text"><?php echo htmlspecialchars($calendario->texto); ?></p>
                    
                </div>
                <img class="img-cal" src="<?php echo htmlspecialchars($calendario->imagen_path); ?>" class="card-img-top" alt="Imagen de <?php echo htmlspecialchars($calendario->titulo); ?>">

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
