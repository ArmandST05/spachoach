<?php

$response = ["success" => false, "message" => "Ocurrió un error"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['nombre_tema']) && !empty($_POST['id_materia']) && !empty($_POST['descripcion'])) {
        $tema = new TemaData();
        $tema->nombre_tema = $_POST['nombre_tema'];
        $tema->id_materia = $_POST['id_materia'];
        $tema->descripcion = $_POST['descripcion'];
        $tema->file_path = ""; // Si quieres manejar archivos, agrégalo aquí

        $id = $tema->add(); // 📌 Ahora `add()` devuelve el ID del nuevo tema

        if ($id) {
            $materia = MateriaData::getById($tema->id_materia);
            $response = [
                "success" => true,
                "id" => $id,
                "nombre_tema" => $tema->nombre_tema,
                "descripcion" => $tema->descripcion,
                "nombre_materia" => $materia->nombre_materia ?? "Desconocida"
            ];
        } else {
            $response["message"] = "No se pudo guardar el tema.";
        }
    } else {
        $response["message"] = "Faltan datos obligatorios.";
    }
}

echo json_encode($response);
exit;
