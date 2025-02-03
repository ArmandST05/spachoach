<?php

// Manejar la inserción de nuevas materias
if(isset($_POST['materiaName']) && !empty($_POST['materiaName']) && isset($_POST['descripcion']) && isset($_POST['moduleId'])){
    $newMateria = new MateriaData();
    $newMateria->nombre_materia = $_POST['materiaName'];
    $newMateria->descripcion = $_POST['descripcion'];
    $newMateria->id_modulo = $_POST['moduleId'];
    $newMateria->add();

    // Redirigir a la ruta específica después de la inserción
    echo "<script>
            window.location.href = './?view=diplomado/materias/index';
          </script>";
    exit();
}

// Manejar la actualización de una materia
if(isset($_POST['editMateriaId']) && isset($_POST['editMateriaName']) && isset($_POST['editDescripcion']) && isset($_POST['editModuleId'])){
    $materia = MateriaData::getById($_POST['editMateriaId']);
    $materia->nombre_materia = $_POST['editMateriaName'];
    $materia->descripcion = $_POST['editDescripcion'];
    $materia->id_modulo = $_POST['editModuleId'];
    $materia->update();

    // Redirigir a la ruta específica después de la actualización
    echo "<script>
            window.location.href = './?view=diplomado/materias/index';
          </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);

        // Crea una instancia del modelo y elimina el registro
        $tema = new MateriaData();
        $tema->deleteById($id);

        // Redirige a la página actual para evitar el reenvío del formulario
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
}
// Obtiene todas las materias desde la base de datos
$materias = MateriaData::getAll();

// Obtiene todos los módulos para el selector
$modulos = ModuleData::getAll();

// Verifica si se debe mostrar el formulario de edición
$editId = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
$editMateria = $editId ? MateriaData::getById($editId) : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias</title>
    <style>
        .hidden-form {
            display: none;
        }
        .same-height-btn {
    height: 30px; /* Ajusta este valor a tu gusto */
    line-height: 1.2; /* Ajuste para alinear el texto dentro del botón */
    padding: 8px 12px; /* Añade un poco de relleno si es necesario */
}

    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Materias</h1>
        
        <!-- Botón para habilitar el formulario de agregar materia -->
        <button id="showFormBtn" class="btn btn-primary mb-4" style="background-color: #52768c; color: white;">Agregar Nueva Materia</button>
        <br><br>

        <!-- Formulario para agregar materias -->
        <form id="materiaForm" method="POST" action="" class="hidden-form">
            <div class="row mb-4">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="materiaName" id="materiaName" placeholder="Nombre de la materia" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción" required>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="moduleId" required>
                        <option value="">Selecciona un módulo</option>
                        <?php foreach($modulos as $modulo): ?>
                            <option value="<?php echo $modulo->id; ?>"><?php echo $modulo->nombre_modulo; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-block" style="background-color: #2471a3; color: white;">Agregar Materia</button>
                </div>
            </div>
        </form>

        <!-- Formulario para editar materia -->
        <?php if($editMateria): ?>
        <form id="editMateriaForm" method="POST" action="">
            <input type="hidden" name="editMateriaId" value="<?php echo $editMateria->id; ?>">
            <div class="row mb-4">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="editMateriaName" value="<?php echo $editMateria->nombre_materia; ?>" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="editDescripcion" value="<?php echo $editMateria->descripcion; ?>" required>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="editModuleId" required>
                        <option value="">Selecciona un módulo</option>
                        <?php foreach($modulos as $modulo): ?>
                            <option value="<?php echo $modulo->id; ?>" <?php echo $modulo->id == $editMateria->id_modulo ? 'selected' : ''; ?>>
                                <?php echo $modulo->nombre_modulo; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-block" style="background-color: #2471a3; color: white;">Actualizar Materia</button>
                    <button type="button" id="cancelEditBtn" class="btn btn-block" style="background-color: #5499c7; color: white;">Cancelar</button>
                </div>
            </div>
        </form>
        <?php endif; ?>

        <br><br>
        
        <!-- Tabla de Materias -->
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Nombre de la Materia</th>
                    <th>Descripción</th>
                    <th>Módulo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
    <?php if(count($materias) > 0): ?>
        <?php foreach($materias as $materia): ?>
            <tr>
                <td><?php echo $materia->nombre_materia; ?></td>
                <td><?php echo $materia->descripcion; ?></td>
                <td><?php echo $materia->nombre_modulo; ?></td> <!-- Mostrar el nombre del módulo -->
                <td>
    <a href="?view=diplomado/materias/index&edit=<?php echo $materia->id; ?>" 
       class="btn btn-sm same-height-btn" 
       style="background-color: #479bd1; color: white;"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    
    <!-- Formulario para eliminar una materia -->
    <form action="" method="post" style="display: inline;">
        <input type="hidden" name="id" value="<?php echo $materia->id; ?>">
        <button type="submit" 
                class="btn delete-btn same-height-btn" 
                style="background-color: #2471a3; color: white;" 
                onclick="return confirm('¿Estás seguro de que deseas eliminar esta materia?');">
            <i class="fa fa-trash" aria-hidden="true"></i>
        </button>
    </form>
</td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" class="text-center">No hay materias disponibles.</td>
        </tr>
    <?php endif; ?>
</tbody>

        </table>
    </div>

    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript para mostrar y ocultar los formularios
        document.getElementById('showFormBtn').addEventListener('click', function() {
            document.getElementById('materiaForm').classList.toggle('hidden-form');
            document.getElementById('editMateriaForm').classList.add('hidden-form'); // Asegura que el formulario de edición esté oculto
        });

        document.getElementById('cancelEditBtn').addEventListener('click', function() {
            document.getElementById('editMateriaForm').classList.add('hidden-form');
        });
    </script>
</body>
</html>
