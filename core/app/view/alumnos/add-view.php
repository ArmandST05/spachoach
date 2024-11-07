<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inscripción</title>
    <style>
        .table td, .table th {
            padding: 0.3rem;
        }
        .disabled-input {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
<?php


// Obtén el usuario logueado
$user = UserData::getLoggedIn();
$user_id = $user->id;

// Verifica si el usuario está registrado en la tabla de inscripciones
$inscripcion_registrada = false;
$inscripcion = null;

$nombre_usuario = UserData::getNameById($user->id);

if ($user) {
    $inscripcion_data = AlumnoData::isUserRegistered($user_id);
    
    if ($inscripcion_data->count > 0) {
        $inscripcion_registrada = true;
        $inscripcion = AlumnoData::getUser($user_id);
        
    }
}

// Manejo del formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén los datos del formulario
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

    // Si el usuario está registrado, actualiza la inscripción; de lo contrario, agrega una nueva inscripción
    if ($inscripcion_registrada) {
        // Aquí puedes agregar lógica para actualizar la inscripción existente si es necesario
        // Ejemplo:
        $inscripcion->nombre = $nombre;
        $inscripcion->correo = $correo;
        $inscripcion->fecha_nacimiento = $fecha_nacimiento;
        $inscripcion->domicilio = $domicilio;
        $inscripcion->telefono = $telefono;
        $inscripcion->contacto_emergencia = $contacto_emergencia;
        $inscripcion->medio_contacto = $medio_contacto;
        $inscripcion->formato_diplomado = $formato_diplomado;
        $inscripcion->resena_profesional = $resena_profesional;
        $inscripcion->expectativas_curso = $expectativas_curso;
        // Actualizar en la base de datos
        $inscripcion->update();  // Asegúrate de tener el método `update` en tu clase `AlumnoData`
    } else {
        // Crea una nueva inscripción
        $fecha_inscripcion = date('Y-m-d'); // O la fecha actual
        $alumno = new AlumnoData();
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
        $alumno->fecha_inscripcion = $fecha_inscripcion;
        $alumno->user_id = $user_id;
        $alumno->add();  // Llama al método add para agregar la inscripción a la base de datos
    }

    // Redirige o muestra un mensaje de éxito
    echo "Inscripción registrada con éxito";
}
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
        
            <h2>Formulario de Inscripción</h2>
            <br>

            <?php if (!$inscripcion_registrada): ?>
                <!-- Formulario para usuarios no registrados -->
                
                <form class="form-horizontal" method="post" action="" role="form" id="notRegistered">
                    <div class="form-group row">
                        <label for="nombre" class="col-sm-3 col-form-label">Nombre*</label>
                        <div class="col-sm-9">
                        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($nombre_usuario); ?>"required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="correo" class="col-sm-3 col-form-label">Correo*</label>
                        <div class="col-sm-9">
                            <input type="email" name="correo" class="form-control" id="correo" placeholder="Correo" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fecha_nacimiento" class="col-sm-3 col-form-label">Fecha de Nacimiento*</label>
                        <div class="col-sm-9">
                            <input type="date" name="fecha_nacimiento" class="form-control" id="fecha_nacimiento" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="domicilio" class="col-sm-3 col-form-label">Domicilio*</label>
                        <div class="col-sm-9">
                            <input type="text" name="domicilio" class="form-control" id="domicilio" placeholder="Domicilio" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telefono" class="col-sm-3 col-form-label">Teléfono*</label>
                        <div class="col-sm-9">
                            <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Teléfono" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contacto_emergencia" class="col-sm-3 col-form-label">Contacto de Emergencia*</label>
                        <div class="col-sm-9">
                            <input type="text" name="contacto_emergencia" class="form-control" id="contacto_emergencia" placeholder="Contacto de Emergencia" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="medio_contacto" class="col-sm-3 col-form-label">Medio de Contacto de tu Preferencia*</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="medio_contacto" id="medio_contacto" required>
                                <option value="">-- SELECCIONE --</option>
                                <option value="Llamada telefonica">Llamada telefónica</option>
                                <option value="Mensaje de texto whats app">Mensaje de texto WhatsApp</option>
                                <option value="Correo electronico">Correo electrónico</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="formato_diplomado" class="col-sm-3 col-form-label">Formato de Diplomado*</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="formato_diplomado" id="formato_diplomado" required>
                                <option value="">-- SELECCIONE --</option>
                                <option value="On line">On line</option>
                                <option value="Presencial">Presencial</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="resena_profesional" class="col-sm-3 col-form-label">Reseña Profesional*</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="resena_profesional" id="resena_profesional" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="expectativas_curso" class="col-sm-3 col-form-label">Expectativas del Curso*</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="expectativas_curso" id="expectativas_curso" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </form>





                
            <?php else: ?>
                <!-- Formulario para usuarios registrados -->
                <?php if ($inscripcion_registrada): ?>
    <!-- Formulario para usuarios registrados -->
    <form class="form-horizontal" method="post" action="" role="form" id="isRegistered">
        <div class="form-group row">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre*</label>
            <div class="col-sm-9">
                <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo htmlspecialchars($inscripcion->nombre); ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="correo" class="col-sm-3 col-form-label">Correo*</label>
            <div class="col-sm-9">
                <input type="email" name="correo" class="form-control disabled-input" id="correo" value="<?php echo htmlspecialchars($inscripcion->correo); ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="fecha_nacimiento" class="col-sm-3 col-form-label">Fecha de Nacimiento*</label>
            <div class="col-sm-9">
                <input type="date" name="fecha_nacimiento" class="form-control disabled-input" id="fecha_nacimiento" value="<?php echo htmlspecialchars($inscripcion->fecha_nacimiento); ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="domicilio" class="col-sm-3 col-form-label">Domicilio*</label>
            <div class="col-sm-9">
                <input type="text" name="domicilio" class="form-control disabled-input" id="domicilio" value="<?php echo htmlspecialchars($inscripcion->domicilio); ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="telefono" class="col-sm-3 col-form-label">Teléfono*</label>
            <div class="col-sm-9">
                <input type="text" name="telefono" class="form-control disabled-input" id="telefono" value="<?php echo htmlspecialchars($inscripcion->telefono); ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="contacto_emergencia" class="col-sm-3 col-form-label">Contacto de Emergencia*</label>
            <div class="col-sm-9">
                <input type="text" name="contacto_emergencia" class="form-control disabled-input" id="contacto_emergencia" value="<?php echo htmlspecialchars($inscripcion->contacto_emergencia); ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="medio_contacto" class="col-sm-3 col-form-label">Medio de Contacto de tu Preferencia*</label>
            <div class="col-sm-9">
                <select class="form-control disabled-input" name="medio_contacto" id="medio_contacto" disabled>
                    <option value="">-- SELECCIONE --</option>
                    <option value="Llamada telefonica" <?php echo ($inscripcion->medio_contacto == 'Llamada telefonica') ? 'selected' : ''; ?>>Llamada telefónica</option>
                    <option value="Mensaje de texto whats app" <?php echo ($inscripcion->medio_contacto == 'Mensaje de texto whats app') ? 'selected' : ''; ?>>Mensaje de texto WhatsApp</option>
                    <option value="Correo electronico" <?php echo ($inscripcion->medio_contacto == 'Correo electronico') ? 'selected' : ''; ?>>Correo electrónico</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="formato_diplomado" class="col-sm-3 col-form-label">Formato de Diplomado*</label>
            <div class="col-sm-9">
                <select class="form-control disabled-input" name="formato_diplomado" id="formato_diplomado" disabled>
                    <option value="">-- SELECCIONE --</option>
                    <option value="On line" <?php echo ($inscripcion->formato_diplomado == 'On line') ? 'selected' : ''; ?>>On line</option>
                    <option value="Presencial" <?php echo ($inscripcion->formato_diplomado == 'Presencial') ? 'selected' : ''; ?>>Presencial</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="resena_profesional" class="col-sm-3 col-form-label">Reseña Profesional*</label>
            <div class="col-sm-9">
                <textarea class="form-control disabled-input" name="resena_profesional" id="resena_profesional" rows="3" disabled><?php echo htmlspecialchars($inscripcion->resena_profesional); ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="expectativas_curso" class="col-sm-3 col-form-label">Expectativas del Curso*</label>
            <div class="col-sm-9">
                <textarea class="form-control disabled-input" name="expectativas_curso" id="expectativas_curso" rows="3" disabled><?php echo htmlspecialchars($inscripcion->expectativas_curso); ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
                <button type="button" class="btn" id="editButton" style="background-color: black; color: white;">Editar</button>
                <button type="submit" class="btn" id="submitButton" style="display:none; background-color: black; color: white;">Guardar</button>
            </div>
        </div>
    </form>
    
    <script>
        document.getElementById('editButton').addEventListener('click', function() {
            var inputs = document.querySelectorAll('#isRegistered input, #isRegistered select, #isRegistered textarea');
            inputs.forEach(function(input) {
                input.disabled = false;
                input.classList.remove('disabled-input');
            });
            document.getElementById('editButton').style.display = 'none';
            document.getElementById('submitButton').style.display = 'block';
        });
    </script>

<?php else: ?>
    <p>No se encontraron datos para este usuario.</p>
<?php endif; ?>

            <?php endif; ?>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </div>
    </div>
</div>
</body>
</html>