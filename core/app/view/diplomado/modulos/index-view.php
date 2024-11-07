<?php

// Manejo de la inserción de nuevos módulos
if(isset($_POST['moduleName']) && !empty($_POST['moduleName'])){
    $newModule = new ModuleData();
    $newModule->nombre_modulo = $_POST['moduleName'];
    $newModule->add();

    echo "<script>
            window.location.href = './?view=diplomado/modulos/index';
          </script>";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);

        // Crea una instancia del modelo y elimina el registro
        $tema = new ModuleData();
        $tema->deleteById($id);

        // Redirige a la página actual para evitar el reenvío del formulario
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
}

// Obtiene todos los módulos desde la base de datos
$modules = ModuleData::getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulos</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Módulos</h1>
        
        <!-- Formulario para agregar módulos -->
        <form method="POST" action="">
            <div class="row mb-4">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="moduleName" id="moduleName" placeholder="Nombre del módulo" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-block">Agregar Módulo</button>
                </div>
            </div>
        </form>

        <!-- Tabla de Módulos -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Módulo</th>
                    <th>Materias</th> <!-- Columna para mostrar las materias -->
                    <th>Acciones</th> <!-- Columna para los botones de eliminar -->
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se muestran los módulos de la base de datos -->
                <?php if(count($modules) > 0): ?>
                    <?php foreach($modules as $module): ?>
                        <tr>
                            <td><?php echo $module->id; ?></td>
                            <td><?php echo $module->nombre_modulo; ?></td>
                            <td>
                                <?php
                                // Obtén las materias para el módulo actual
                                $materias = MateriaData::getByModuleId($module->id);
                                if(count($materias) > 0):
                                    echo '<ul>';
                                    foreach($materias as $materia):
                                        echo '<li>' . htmlspecialchars($materia->nombre_materia) . '</li>';
                                    endforeach;
                                    echo '</ul>';
                                else:
                                    echo 'No hay materias asignadas';
                                endif;
                                ?>
                            </td>
                            <td>
                            <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $module->id; ?>">
                                <button type="submit" class="btn delete-btn" style="background-color: #2471a3; color: white;" onclick="return confirm('¿Estás seguro de que deseas eliminar este modulo?');">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No hay módulos disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
