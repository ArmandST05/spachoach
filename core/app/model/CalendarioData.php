<?php
class CalendarioData {
    public static $tablename = "calendario";

    public function __construct(){
        $this->titulo = "";
        $this->subtitulo = "";
        $this->texto = "";
        $this->imagen_path = "";
    }

    // Método para agregar un nuevo registro
    public function add(){
        // Construir la consulta SQL directamente con los datos
        $sql = "INSERT INTO ".self::$tablename." (titulo, subtitulo, texto, imagen_path) VALUES ('$this->titulo', '$this->subtitulo', '$this->texto', '$this->imagen_path')";
        Executor::doit($sql);
    }

    // Método para actualizar un registro existente
    public function update(){
        // Construir la consulta SQL directamente con los datos
        $sql = "UPDATE ".self::$tablename." SET titulo='$this->titulo', subtitulo='$this->subtitulo', texto='$this->texto', imagen_path='$this->imagen_path' WHERE id=$this->id";
        Executor::doit($sql);
    }

    // Método para obtener un registro por ID
    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new CalendarioData());
    }

    // Método para obtener todos los registros
    public static function getAll(){
        $sql = "SELECT * FROM ".self::$tablename." ORDER BY id DESC";
        echo $sql;
        $query = Executor::doit($sql);
        return Model::one($query[0], new CalendarioData());    }
}
?>
