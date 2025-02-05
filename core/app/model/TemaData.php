<?php
class TemaData {
    public static $tablename = "temas"; // Nombre de la tabla en la base de datos

    public function __construct() {
        $this->nombre_tema = "";
        $this->descripcion = "";
        $this->id_materia = 0;
        $this->file_path = ""; // Inicializar file_path como cadena vacía
        $this->link = ""; // Inicializar link como cadena vacía
    }

    // Método para agregar un nuevo tema
    public function add() {
        $sql = "INSERT INTO " . self::$tablename . " (nombre_tema, descripcion, id_materia, file_path, link) ";
        $sql .= "VALUES (\"$this->nombre_tema\", \"$this->descripcion\", \"$this->id_materia\", \"$this->file_path\", \"$this->link\")";
        Executor::doit($sql);
    }

    // Método para actualizar un tema existente
    public function update() {
        $sql = "UPDATE " . self::$tablename . " SET nombre_tema=\"$this->nombre_tema\", descripcion=\"$this->descripcion\", id_materia=\"$this->id_materia\", file_path=\"$this->file_path\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    // Obtener un tema por ID
    public static function getById($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new TemaData());
    }

    // Obtener todos los temas
    public static function getAll() {
        $sql = "SELECT * FROM " . self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new TemaData());
    }

    // Obtener temas por ID de materia (Función solicitada)
    public static function getByMateriaId($materiaId) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id_materia = $materiaId";
        $query = Executor::doit($sql);
        return Model::many($query[0], new TemaData());
    }

    public static function deleteById($id)
	{
		$sql = "DELETE FROM " . self::$tablename . " WHERE id=$id";
		return Executor::doit($sql);
	}

	public function delete()
	{
		$sql = "DELETE FROM " . self::$tablename . " WHERE id=$this->id";
		return Executor::doit($sql);
	}
    

   
    
}
?>
