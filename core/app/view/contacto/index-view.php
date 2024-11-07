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
        FeedbackData::deleteById($id);

        // Redirige a la página principal
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
}

// Obtener los contenidos
$feedbacks = FeedbackData::getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retroalimentación</title>
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
        .card-header .delete-btn,
        .card-header .view-btn {
            position: absolute;
            top: 10px;
            font-size: 18px;
        }
        .card-header .edit-btn {
            margin-top: 20px;
            right: 40px; 
            background-color: #bdc3c7;
        }
        .card-header .view-btn {
            margin-top: 20px;
            right: 0; 
            background-color: #3498db;
        }
        .card-title, .card-subtitle, .card-text {
            margin-bottom: 15px; /* Añadir margen en la parte inferior de los textos dentro de la card */
        }
       
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row mt-4">
            <?php foreach ($feedbacks as $feedback): ?>
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title"><?php echo htmlspecialchars($feedback->titulo); ?></h2>
                            <?php if ($user_type != 'a'): ?>
                                <button class="btn edit-btn" onclick="window.location.href='./?view=contacto/edit&id=<?php echo $feedback->id; ?>';">
                                    Editar
                                </button>
                            <?php endif; ?>
                            
                        </div>
                        <div class="card-body">
                            <h3 class="card-subtitle mb-2 text-muted" style="color: black;"><?php echo htmlspecialchars($feedback->subtitulo); ?></h3>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($feedback->texto)); ?></p>
                            <?php if (!empty($feedback->pdf_path)) : ?>
                                <a href="<?php echo htmlspecialchars($feedback->pdf_path); ?>" target="_blank" class="btn btn-info">Ver PDF</a>
                            <?php endif; ?>
                          
                        </div>
                        
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
