<?php
class ContenidoDinamicoData {
    public static $tablename = "contenido_dinamico";

    public function __construct(){
        $this->titulo = "";
        $this->subtitulo = "";
        $this->texto = "";
        $this->video_path = "";
        $this->fecha_inicio = "";
        $this->fecha_fin = "";
        $this->contenido_activo = 1; // Por defecto el contenido estará visible (1 = visible, 2 = oculto)
    }

    public function add(){
        $sql = "INSERT INTO ".self::$tablename." (titulo, subtitulo, texto, video_path, fecha_inicio, fecha_fin, contenido_activo) ";
        $sql .= "VALUES (\"$this->titulo\", \"$this->subtitulo\", \"$this->texto\", \"$this->video_path\", \"$this->fecha_inicio\", \"$this->fecha_fin\", \"$this->contenido_activo\")";
        Executor::doit($sql);
    }

    public function update(){
        $sql = "UPDATE ".self::$tablename." SET titulo=\"$this->titulo\", subtitulo=\"$this->subtitulo\", texto=\"$this->texto\", video_path=\"$this->video_path\", ";
        $sql .= "fecha_inicio=\"$this->fecha_inicio\", fecha_fin=\"$this->fecha_fin\", contenido_activo=\"$this->contenido_activo\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new ContenidoDinamicoData());
    }

    public static function getAll(){
        $sql = "SELECT * FROM ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new ContenidoDinamicoData());
    }

    public static function deleteById($id) {
        // Obtén la ruta del video asociado con el ID
        $sql = "SELECT video_path FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        $result = $query[0]->fetch_assoc(); // Obtiene el resultado de la consulta
    
        if ($result && !empty($result['video_path'])) {
            $videoPath = $result['video_path'];
    
            // Elimina el registro de la base de datos
            $sql = "DELETE FROM ".self::$tablename." WHERE id=$id";
            Executor::doit($sql);
    
            // Elimina el archivo físico, si existe
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
        } else {
            echo "No se encontró el registro o no hay video asociado.";
        }
    }
}
?>
