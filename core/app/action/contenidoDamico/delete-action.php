<?php
// action/contenidoDinamico/delete-action.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = $_POST['id'];
        ContenidoDinamicoData::deleteById($id);
        echo 'Contenido eliminado';
    } else {
        echo 'ID inválido';
    }
} else {
    echo 'Método de solicitud no permitido';
}

