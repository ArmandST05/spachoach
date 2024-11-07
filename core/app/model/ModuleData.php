<?php
class ModuleData {
    public static $tablename = "modulos";

    public function __construct(){
        $this->id = null;
        $this->nombre_modulo = "";
    }

    public function add(){
        $sql = "INSERT INTO ".self::$tablename." (nombre_modulo) ";
        $sql .= "VALUES (\"$this->nombre_modulo\")";
        Executor::doit($sql);
    }

    public function update(){
        $sql = "UPDATE ".self::$tablename." SET nombre_modulo=\"$this->nombre_modulo\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new ModuleData());
    }

    public static function getAll(){
        $sql = "SELECT * FROM ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new ModuleData());
    }
    public static function deleteById($id){
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$id";
        Executor::doit($sql);
    }
}
?>
