<?php

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de materia inválido.");
}

$id_materia = $_GET['id'];

// Obtener la información de la materia seleccionada
$materia = MateriaData::getById($id_materia);

if (!$materia) {
    die("No se encontró la materia.");
}

// Obtener los temas asignados a esta materia
$temas = TemaData::getByMateriaId($id_materia);
?>

<h1><?php echo htmlspecialchars($materia->nombre_materia); ?></h1>

<h3><strong>Descripción:</strong> <?php echo htmlspecialchars($materia->descripcion); ?></h3>

<h2>Temas de esta materia</h2>

<ul>
    <?php if (count($temas) > 0): ?>
        <?php foreach ($temas as $tema): ?>
            <li>
                <strong><?php echo htmlspecialchars($tema->nombre_tema); ?></strong>
                <p><?php echo htmlspecialchars($tema->descripcion); ?></p>

                <!-- Sección para el archivo del tema -->
                <?php if (!empty($tema->file_path)): ?>
                    <p><strong>Archivo:</strong> 
                        <a href="<?php echo htmlspecialchars($tema->file_path); ?>" target="_blank">Descargar archivo</a>
                    </p>
                <?php else: ?>
                    <p><strong>Archivo:</strong> No hay archivo disponible.</p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay temas disponibles para esta materia.</p>
    <?php endif; ?>
</ul>
