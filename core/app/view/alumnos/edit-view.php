<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $contacto_emergencia = $_POST['contacto_emergencia'];
    $medio_contacto = $_POST['medio_contacto'];
    $formato_diplomado = $_POST['formato_diplomado'];
    $resena_profesional = $_POST['resena_profesional'];
    $expectativas_curso = $_POST['expectativas_curso'];

    // Crea una instancia del modelo y asigna los datos
    $alumno = new AlumnoData();
    $alumno->id = $id;
    $alumno->nombre = $nombre;
    $alumno->correo = $correo;
    $alumno->fecha_nacimiento = $fecha_nacimiento;
    $alumno->domicilio = $domicilio;
    $alumno->telefono = $telefono;
    $alumno->contacto_emergencia = $contacto_emergencia;
    $alumno->medio_contacto = $medio_contacto;
    $alumno->formato_diplomado = $formato_diplomado;
    $alumno->resena_profesional = $resena_profesional;
    $alumno->expectativas_curso = $expectativas_curso;

    // Actualiza el registro en la base de datos
    $alumno->update();

    // Muestra un mensaje de éxito
    print "<script>window.location='index.php?view=alumnos/index';</script>";

} else {
    $id = $_GET['id'];
    $alumno = AlumnoData::getById($id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno</title>
    <!-- Enlace a los estilos de Bootstrap -->
    <style>
        /* Estilo personalizado para los inputs */
        label {
            font-size: large;
        }
        body {
    zoom: 0.95;
}
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Alumno</h1>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($alumno->id); ?>">

            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($alumno->nombre); ?>">
            </div>

            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control" value="<?php echo htmlspecialchars($alumno->correo); ?>">
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" value="<?php echo htmlspecialchars($alumno->fecha_nacimiento); ?>">
            </div>

            <div class="form-group">
                <label for="domicilio">Domicilio:</label>
                <input type="text" id="domicilio" name="domicilio" class="form-control" value="<?php echo htmlspecialchars($alumno->domicilio); ?>">
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($alumno->telefono); ?>">
            </div>

            <div class="form-group">
                <label for="contacto_emergencia">Contacto de Emergencia:</label>
                <input type="text" id="contacto_emergencia" name="contacto_emergencia" class="form-control" value="<?php echo htmlspecialchars($alumno->contacto_emergencia); ?>">
            </div>

            <div class="form-group">
                <label for="medio_contacto">Medio de Contacto:</label>
                <input type="text" id="medio_contacto" name="medio_contacto" class="form-control" value="<?php echo htmlspecialchars($alumno->medio_contacto); ?>">
            </div>

            <div class="form-group">
                <label for="formato_diplomado">Formato de Diplomado:</label>
                <input type="text" id="formato_diplomado" name="formato_diplomado" class="form-control" value="<?php echo htmlspecialchars($alumno->formato_diplomado); ?>">
            </div>

            <div class="form-group">
                <label for="resena_profesional">Reseña Profesional:</label>
                <input type="text" id="resena_profesional" name="resena_profesional" class="form-control" value="<?php echo htmlspecialchars($alumno->resena_profesional); ?>">
            </div>

            <div class="form-group">
                <label for="expectativas_curso">Expectativas del Curso:</label>
                <input type="text" id="expectativas_curso" name="expectativas_curso" class="form-control" value="<?php echo htmlspecialchars($alumno->expectativas_curso); ?>">
            </div>

            <button type="submit" class="btn btn-primary" style="background-color: black; color: white;">Actualizar</button>
        </form>
    </div>

   <!-- Bootstrap JS and dependencies -->
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
