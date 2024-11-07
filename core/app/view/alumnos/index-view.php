<?php

// Manejo de la eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);

        // Crea una instancia del modelo y elimina el registro
        $alumno = new AlumnoData();
        $alumno->deleteById($id);

        // Redirige a la página actual para evitar el reenvío del formulario
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
}

// Obtener los alumnos
$inscripciones = AlumnoData::getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alumnos</title>
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
        body {
    zoom: 0.95;
}
    </style>
</head>
<body>
    <h1>
        Lista de alumnos
    </h1>
    <div class="container mt-5">
        <div class="header-container">
            <div class="fixed-text">
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Domicilio</th>
                    <th>Teléfono</th>
                    <th>Contacto de Emergencia</th>
                    <th>Medio de Contacto</th>
                    <th>Formato de Diplomado</th>
                    <th>Reseña Profesional</th>
                    <th>Expectativas del Curso</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($inscripciones) > 0): ?>
                    <?php foreach ($inscripciones as $inscripcion): ?>
                        <tr>
                            <td>
                                <button class="btn edit-btn"  style="background-color: #2471a3; color: white;" onclick="window.location.href='./?view=alumnos/edit&id=<?php echo $inscripcion->id; ?>';">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td>
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $inscripcion->id; ?>">
                                    <button type="submit"  style="background-color: #5499c7; color: white;" class="btn delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar este alumno?');">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                            <td><?php echo htmlspecialchars($inscripcion->id); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion->nombre); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion->correo); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion->fecha_nacimiento); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion->domicilio); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion->telefono); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion->contacto_emergencia); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion->medio_contacto); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion->formato_diplomado); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion->resena_profesional); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion->expectativas_curso); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="13" class="text-center">No hay alumnos inscritos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

   <!-- Bootstrap JS and dependencies -->
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
