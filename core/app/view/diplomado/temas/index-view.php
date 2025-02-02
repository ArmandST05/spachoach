<?php
$temas = TemaData::getAll();
$materias = MateriaData::getAll(); // Asegúrate de obtener todas las materias para el formulario de edición
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temas</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Temas</h1>

        <!-- Formulario para agregar temas -->
        <form id="agregarTemaForm" enctype="multipart/form-data">
            <div class="row mb-4">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="nombre_tema" placeholder="Nombre del tema" required>
                </div>
                <div class="col-md-6">
                    <select class="form-control" name="id_materia" required>
                        <option value="">Seleccione la materia</option>
                        <?php foreach($materias as $materia): ?>
                            <option value="<?php echo $materia->id; ?>"><?php echo $materia->nombre_materia; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <textarea class="form-control" name="descripcion" placeholder="Descripción del tema" required></textarea>
                </div>
                <div class="col-md-6">
                    <input type="file" class="form-control" name="archivo">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-block" style="background-color: #52768c; color: white;">Agregar Tema</button>
                </div>
            </div>
        </form>
        <br>

        <!-- Tabla de Temas -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    
                    <th>Nombre del Tema</th>
                    <th>Descripción</th>
                    <th>Materia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="temasTableBody">
                <?php foreach($temas as $tema): ?>
                    
                        
                        <td><?php echo htmlspecialchars($tema->nombre_tema); ?></td>
                        <td><?php echo htmlspecialchars($tema->descripcion); ?></td>
                        <td><?php echo htmlspecialchars(MateriaData::getById($tema->id_materia)->nombre_materia); ?></td>
                        <td>
                        <a href="./?view=diplomado/temas/edit&id=<?php echo $tema->id; ?>">
                            <button class="btn btn-warning btn-sm editTema" data-id="<?php echo $tema->id; ?>">Editar</button>
                        </a>

                        <a href="index.php?action=temas/delete&id=<?php echo $tema->id; ?>" class="btn btn-danger btn-sm" onClick="return confirmDelete()">
                            Eliminar
                        </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
$(document).ready(function () {
    $("#agregarTemaForm").submit(function (e) {
        e.preventDefault(); // ⬅️ Evita recargar la página

        var formData = new FormData(this);

        $.ajax({
            url: "./?action=temas/add", // ✅ URL correcta
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log("🔍 Respuesta cruda del servidor:", response);
                    var data = JSON.parse(response); // Convierte a JSON

                        alert("✅ Tema agregado correctamente");
                        location.reload();
            },
           
        });
    });
});

$(document).ready(function () {
    // Event listener para el botón de eliminar
    $('.deleteTema').click(function () {
        var temaId = $(this).data('id'); // Obtén el ID del tema a eliminar

        // Confirmación antes de eliminar
        if (confirm("¿Seguro que deseas eliminar este tema?")) {
            // Realizar la solicitud AJAX
            $.ajax({
                url: './?action=temas/delete', // URL del archivo PHP que maneja la eliminación
                type: 'POST',
                data: { id: temaId }, // Enviar el ID del tema a eliminar
                success: function (response) {
                    alert(response); // Muestra mensaje de éxito
                    $('#tema-' + temaId).remove(); // Elimina la fila de la tabla con el ID del tema
                },
                error: function () {
                    alert('Hubo un error al eliminar el tema.');
                }
            });
        }
    });
});


    </script>
</body>
</html>
