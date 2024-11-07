<?php
class BienvenidaData {
    public static $tablename = "bienvenida";

    public function __construct(){
        $this->titulo = "";
        $this->subtitulo = "";
        $this->texto = "";
    }

    public function add(){
        $sql = "INSERT INTO ".self::$tablename." (titulo, subtitulo, texto) ";
        $sql .= "VALUES (\"$this->titulo\", \"$this->subtitulo\", \"$this->texto\")";
        Executor::doit($sql);
    }

    public function update(){
        $sql = "UPDATE ".self::$tablename." SET titulo=\"$this->titulo\", subtitulo=\"$this->subtitulo\", texto=\"$this->texto\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new BienvenidaData());
    }
}
?>
