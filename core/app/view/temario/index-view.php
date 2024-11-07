<?php
// Incluye archivos necesarios para conectarse a la base de datos y cargar los datos

// Obtén todos los módulos
$modulos = ModuleData::getAll(); // Asume que tienes un método similar para obtener todos los módulos

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temario</title>
    <!-- Enlace a los estilos de Bootstrap -->
    <style>
        .module {
            margin-bottom: 20px;
        }
        .materia {
            margin-left: 20px;
            margin-bottom: 15px;
        }
        .tema {
            margin-left: 40px;
        }
        .tema a {
            text-decoration: none;
            color: #007bff;
        }
        .tema a:hover {
            text-decoration: underline;
        }
       
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Temario</h1>
        
        <?php foreach ($modulos as $modulo): ?>
            <div class="module">
                <h2><?php echo htmlspecialchars($modulo->nombre_modulo); ?></h2>
                
                <?php
                // Obtener materias del módulo actual
                $materias = MateriaData::getByModuleId($modulo->id);
                foreach ($materias as $materia):
                ?>
                    <div class="materia">
                        <h3><?php echo htmlspecialchars($materia->nombre_materia); ?></h3>
                        
                        <?php
                        // Obtener temas de la materia actual
                        $temas = TemaData::getByMateriaId($materia->id);
                        foreach ($temas as $tema):
                        ?>
                            <div class="tema">
                                <h4><a href="./?view=diplomado/temas/details&id=<?php echo urlencode($tema->id); ?>"><?php echo htmlspecialchars($tema->nombre_tema); ?></a></h4>
                                
                            </div>
                        <?php endforeach; ?>
                        
                    </div>
                <?php endforeach; ?>
                
            </div>
        <?php endforeach; ?>

    </div>

    <!-- Enlace a los scripts de Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
