<?php
// action/contenidoDinamico/delete-action.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = $_POST['id'];

        // Llamar al método deleteById de la clase TemaData para eliminar el tema
        TemaData::deleteById($id); // Elimina el tema según su ID

        echo 'Tema eliminado con éxito';
    } else {
        echo 'ID inválido';
    }
} else {
    echo 'Método de solicitud no permitido';
}

