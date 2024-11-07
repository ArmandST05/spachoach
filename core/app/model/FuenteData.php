<?php
class FuenteData {
    public static $tablename = "fuentes";

    public function __construct() {
        $this->titulo = "";
        $this->subtitulo = "";
        $this->texto = ""; // Inicializa la propiedad texto
        $this->file_path = ""; // Inicializa la propiedad file_path
    }


    // Método para agregar un nuevo registro
    public function add() {
        $sql = "INSERT INTO " . self::$tablename . " (titulo, subtitulo, texto, file_path) VALUES ('$titulo', '$subtitulo', '$texto', '$file_path')";
        Executor::doit($sql);
    }

    // Método para actualizar un registro existente
    public function update() {
        $sql = "UPDATE " . self::$tablename . " SET titulo='$this->titulo', subtitulo='$this->subtitulo', texto='$this->texto' WHERE id=$this->id";
        Executor::doit($sql);
    }

    // Método para eliminar un registro por ID
    public function deleteById($id) {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=$id";
        Executor::doit($sql);
    }

    // Método para obtener un registro por ID
    public static function getById($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new FuenteData());
    }

    // Método para obtener todos los registros
    public static function getAll(){
        $sql = "SELECT * FROM ".self::$tablename." ORDER BY id ASC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new GlosarioData());
    }
}
?>
