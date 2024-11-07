<?php
class MateriaData {
    public static $tablename = "materias"; // Nombre de la tabla en la base de datos

    public function __construct() {
        $this->nombre_materia = "";
        $this->descripcion = "";
        $this->id_modulo = 0;
    }

    // Método para agregar una nueva materia
    public function add() {
        $sql = "INSERT INTO " . self::$tablename . " (nombre_materia, descripcion, id_modulo) ";
        $sql .= "VALUES (\"$this->nombre_materia\", \"$this->descripcion\", $this->id_modulo)";
        Executor::doit($sql);
    }

    // Método para actualizar una materia existente
    public function update() {
        $sql = "UPDATE " . self::$tablename . " SET nombre_materia=\"$this->nombre_materia\", descripcion=\"$this->descripcion\", id_modulo=$this->id_modulo WHERE id=$this->id";
        Executor::doit($sql);
    }

    // Obtener materia por ID
    public static function getById($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new MateriaData());
    }

    // Obtener todas las materias con información de su módulo
    public static function getAll() {
        $sql = "SELECT m.*, modulos.nombre_modulo 
                FROM " . self::$tablename . " m
                JOIN modulos ON m.id_modulo = modulos.id";
        $query = Executor::doit($sql);
        return Model::many($query[0], new MateriaData());
    }

    // Obtener materias por ID de módulo (Función solicitada)
    public static function getByModuleId($moduleId) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id_modulo=$moduleId";
        $query = Executor::doit($sql);
        return Model::many($query[0], new MateriaData());
    }

    // Eliminar materia por ID
    public static function deleteById($id) {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=$id";
        Executor::doit($sql);
    }
}
?>
