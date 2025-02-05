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
                        <div class="form-group">
                            <input type="text" class="form-control" name="nombre_tema" placeholder="Nombre del tema" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" name="id_materia" required>
                                <option value="">Seleccione la materia</option>
                                <?php foreach($materias as $materia): ?>
                                    <option value="<?php echo $materia->id; ?>"><?php echo $materia->nombre_materia; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea class="form-control" name="descripcion" placeholder="Descripción del tema" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" class="form-control" name="archivo">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="url" class="form-control" name="link" placeholder="Enlace relacionado (opcional)">
                        </div>
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
    </div>

    <style>
    /* Limitar el ancho de la tabla y centrarla */
    .table-container {
        max-width: 90%;
        margin: auto;
    }

    /* Ajustar el ancho de las columnas */
    .table th:nth-child(2), .table td:nth-child(2) { 
        width: 30%; /* Descripción más ancha */
    }

    .table th:nth-child(4), .table td:nth-child(4) { 
        width: 25%; /* Links más anchos */
    }

    /* Controlar la altura de las celdas */
    .table td {
        
        height: 50px;
    }

   
   
</style>

<div class="table-container">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre del Tema</th>
                <th>Descripción</th>
                <th>Materia</th>
                <th>Links</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="temasTableBody">
            <?php foreach($temas as $tema): ?>
                <tr>
                    <td><?php echo htmlspecialchars($tema->nombre_tema); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($tema->descripcion)); ?></td>
                    <td><?php echo htmlspecialchars(MateriaData::getById($tema->id_materia)->nombre_materia); ?></td>
                    <td>
                        <?php if (!empty($tema->link)): ?>
                            <a href="<?php echo htmlspecialchars($tema->link); ?>" target="_blank">
                                <?php echo htmlspecialchars($tema->link); ?>
                            </a>
                        <?php else: ?>
                            No disponible
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="./?view=diplomado/temas/edit&id=<?php echo $tema->id; ?>">
                            <button class="btn btn-warning btn-sm editTema" data-id="<?php echo $tema->id; ?>">Editar</button>
                        </a>
                        <button class="btn btn-danger btn-sm" onclick="deleteTema(<?php echo $tema->id; ?>)">
                            Eliminar
                        </button>
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
            window.location.href = "index.php?action=temas/delete&id=" + temaId;
        }
    });
}





    </script>
</body>
</html>
