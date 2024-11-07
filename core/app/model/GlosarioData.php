<?php
class GlosarioData {
    public static $tablename = "glosario";

    public $id;
    public $titulo;
    public $subtitulo;
    public $texto;
    public $pdf_path;

    public function __construct(){
        $this->titulo = "";
        $this->subtitulo = "";
        $this->texto = "";
        $this->pdf_path = "";
    }

    // Método para agregar un nuevo registro
    public function add(){
        $sql = "INSERT INTO ".self::$tablename." (titulo, subtitulo, texto, pdf_path) VALUES ('$this->titulo', '$this->subtitulo', '$this->texto', '$this->pdf_path')";
        Executor::doit($sql);
    }

    // Método para actualizar un registro existente
    public function update(){
        $sql = "UPDATE ".self::$tablename." SET titulo='$this->titulo', subtitulo='$this->subtitulo', texto='$this->texto', pdf_path='$this->pdf_path' WHERE id=$this->id";
        Executor::doit($sql);
    }

    // Método para obtener un registro por ID
    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new GlosarioData());
    }

    // Método para obtener todos los registros
    public static function getAll(){
        $sql = "SELECT * FROM ".self::$tablename." ORDER BY id DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new GlosarioData());
    }
}
?>
