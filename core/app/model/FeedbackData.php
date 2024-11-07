<?php

class FeedbackData {
    public static $tablename = "feedback";

    public function __construct() {
        $this->titulo = "";
        $this->subtitulo = "";
        $this->texto = "";
        $this->pdf_path = "";
    }

  

    // Método para actualizar un registro existente
    public function update() {
        // Construir la consulta SQL directamente con los datos
        $sql = "UPDATE " . self::$tablename . " SET titulo='$this->titulo', subtitulo='$this->subtitulo',texto='$this->texto', pdf_path='$this->pdf_path' WHERE id=$this->id";
        Executor::doit($sql);
    }

    // Método para obtener un registro por ID
    public static function getById($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new FeedbackData());
    }

    // Método para obtener todos los registros
    public static function getAll() {
        $sql = "SELECT * FROM " . self::$tablename . " ORDER BY id DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new FeedbackData());
    }

    // Método para eliminar un registro por ID
    public static function deleteById($id) {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=$id";
        Executor::doit($sql);
    }
}

?>
