<?php
$tema = TemaData::getById($_GET["id"]);
$tema->delete();

Core::alert("¡Eliminado exitosamente!");
print "<script>window.location='index.php?view=diplomado/temas/index';</script>";
?>