<?php
class AlumnoData { 
    public static $tablename = "inscripciones";

    public function __construct(){
        $this->nombre = "";
        $this->correo = "";
        $this->fecha_nacimiento = "";
        $this->domicilio = "";
        $this->telefono = "";
        $this->contacto_emergencia = "";
        $this->medio_contacto = "";
        $this->formato_diplomado = "";
        $this->resena_profesional = "";
        $this->expectativas_curso = "";
        $this->user_id = 0; // Asegúrate de inicializarlo
        $this->fecha_inscripcion = "NOW()";
    }

    public function add() {
        $sql = "INSERT INTO " . self::$tablename . " (nombre, correo, fecha_nacimiento, domicilio, telefono, contacto_emergencia, medio_contacto, formato_diplomado, resena_profesional, expectativas_curso, fecha_inscripcion, user_id) ";
        $sql .= "VALUES (\"$this->nombre\", \"$this->correo\", \"$this->fecha_nacimiento\", \"$this->domicilio\", \"$this->telefono\", \"$this->contacto_emergencia\", \"$this->medio_contacto\", \"$this->formato_diplomado\", \"$this->resena_profesional\", \"$this->expectativas_curso\", \"$this->fecha_inscripcion\", \"$this->user_id\")";
        Executor::doit($sql);
    }
    
    public function update(){
        $sql = "UPDATE ".self::$tablename." SET nombre=\"$this->nombre\", correo=\"$this->correo\", fecha_nacimiento=\"$this->fecha_nacimiento\", domicilio=\"$this->domicilio\", telefono=\"$this->telefono\", contacto_emergencia=\"$this->contacto_emergencia\", medio_contacto=\"$this->medio_contacto\", formato_diplomado=\"$this->formato_diplomado\", resena_profesional=\"$this->resena_profesional\", expectativas_curso=\"$this->expectativas_curso\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function deleteById($id){
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$id";
        Executor::doit($sql);
    }

    public static function getAll(){
        $sql = "SELECT * FROM ".self::$tablename." ORDER BY fecha_inscripcion DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new AlumnoData());
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new AlumnoData());
    }
    public static function getUser($user_id) {
        $sql = "SELECT * FROM ".self::$tablename." WHERE user_id = \"$user_id\"";
        $query = Executor::doit($sql);
        return Model::one($query[0], new AlumnoData());
    }
    

    public static function isUserRegistered($user_id) {
        $sql = "SELECT COUNT(*) as count FROM " . self::$tablename . " WHERE user_id = \"$user_id\"";
        
        $query = Executor::doit($sql);
        return Model::one($query[0], new AlumnoData());
    }


}
?>
