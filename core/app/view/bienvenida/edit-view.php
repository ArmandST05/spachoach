<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén los datos del formulario
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $texto = $_POST['texto'];

    // Crea una instancia del modelo y asigna los datos
    $bienvenida = new BienvenidaData();
    $bienvenida->id = $id;
    $bienvenida->titulo = $titulo;
    $bienvenida->subtitulo = $subtitulo;
    $bienvenida->texto = $texto;

    // Actualiza el registro en la base de datos
    $bienvenida->update();

    // Muestra un mensaje de éxito
    echo "<div class='alert alert-success' role='alert'>Actualización exitosa. <a href='./?view=bienvenida/index' class='btn btn-primary'>Ir a la página de inicio</a></div>";
} else {
    $bienvenida = BienvenidaData::getById(1);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Bienvenida</title>
    <!-- Enlace a los estilos de Bootstrap -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Bienvenida</h1>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($bienvenida->id); ?>">

            <div class="form-group">
                <label for="titulo">Título:</label>
                <textarea id="titulo" name="titulo" class="form-control" rows="2"><?php echo htmlspecialchars($bienvenida->titulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="subtitulo">Subtítulo:</label>
                <textarea id="subtitulo" name="subtitulo" class="form-control" rows="2"><?php echo htmlspecialchars($bienvenida->subtitulo); ?></textarea>
            </div>

            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea id="texto" name="texto" class="form-control" rows="10"><?php echo htmlspecialchars($bienvenida->texto); ?></textarea>
            </div>

            <button type="submit" class="btn" style="background-color: #757575; color:azure">Actualizar</button>
        </form>
    </div>

   <!-- Scripts de Bootstrap -->
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
