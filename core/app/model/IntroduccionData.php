<?php
class IntroduccionData {
    public static $tablename = "introduccion";

    public function __construct(){
        $this->titulo = "";
        $this->subtitulo = "";
        $this->texto = "";
        $this->pdf_path = "";
    }

    public function add(){
        $sql = "INSERT INTO ".self::$tablename." (titulo, subtitulo, texto, pdf_path) ";
        $sql .= "VALUE (\"$this->titulo\", \"$this->subtitulo\", \"$this->texto\", \"$this->pdf_path\")";
        Executor::doit($sql);
    }

    public function update(){
        $sql = "UPDATE ".self::$tablename." SET titulo=\"$this->titulo\", subtitulo=\"$this->subtitulo\", texto=\"$this->texto\", pdf_path=\"$this->pdf_path\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new IntroduccionData());
    }
}
?>
