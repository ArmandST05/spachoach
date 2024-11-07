<?php
class UserData {
	public static $tablename = "users";

	public function __construct(){
		$this->name = "";
		$this->lastname = "";
		$this->username = "";
		$this->email = "";
		$this->password = "";
		$this->is_active = "1";
		$this->user_type = "";
		$this->birthdate = "";
		$this->phone = "";
		$this->type_contact = "";
		$this->residence = "";
		$this->emergency_contact = "";
		$this->inscription_date = "NOW()";
		$this->created_at = "NOW()";
		
	}

	public function getUserType(){ 
		return UserTypeData::getByName($this->user_type); 
	}

	public function add(){
		$sql = "INSERT INTO ".self::$tablename." (name, lastname, username, email, password, is_active, user_type, birthdate, phone, type_contact, residence, emergency_contact, inscription_date, created_at) ";
		$sql .= "VALUES (\"$this->name\", \"$this->lastname\", \"$this->username\", \"$this->email\", \"$this->password\", \"$this->is_active\", \"$this->user_type\", \"$this->birthdate\", \"$this->phone\", \"$this->type_contact\", \"$this->residence\", \"$this->emergency_contact\", \"$this->inscription_date\", $this->created_at)";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET name=\"$this->name\", lastname=\"$this->lastname\", username=\"$this->username\", email=\"$this->email\", user_type=\"$this->user_type\", birthdate=\"$this->birthdate\", phone=\"$this->phone\", type_contact=\"$this->type_contact\", residence=\"$this->residence\", emergency_contact=\"$this->emergency_contact\" WHERE id=$this->id";
		Executor::doit($sql);
	}

	public function updateStatus(){
		$sql = "UPDATE ".self::$tablename." SET is_active=$this->is_active WHERE id = $this->id";
		return Executor::doit($sql);
	}

	public function updatePassword(){
		$sql = "UPDATE ".self::$tablename." SET password=\"$this->password\" WHERE id = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id = '$id'";
		$query = Executor::doit($sql);
		return Model::one($query[0], new UserData());
	}

	public static function getLoggedIn(){
		$id = isset($_SESSION["user_id"])  ? $_SESSION["user_id"] : null;
		$sql = "SELECT * FROM ".self::$tablename." WHERE id = '$id'";
		$query = Executor::doit($sql);
		return Model::one($query[0], new UserData());
	}

	public static function getByMail($mail){
		$sql = "SELECT * FROM ".self::$tablename." WHERE is_active=1 AND user_type != 'api' AND email=\"$mail\"";
		$query = Executor::doit($sql);
		return Model::one($query[0], new UserData());
	}

	public static function validateApi($username, $authenticationToken){
		$sql = "SELECT * FROM ".self::$tablename." WHERE is_active=1 AND username='$username' AND authentication_token='$authenticationToken' LIMIT 1";
		$query = Executor::doit($sql);
		return Model::one($query[0], new UserData());
	}

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE is_active=1 AND user_type != 'api' ORDER BY name ASC";
		$query = Executor::doit($sql);
		return Model::many($query[0], new UserData());
	}

	public static function getUnassigned(){
		$sql = "SELECT u.* FROM ".self::$tablename." u LEFT JOIN medics m ON u.id = m.user_id WHERE u.is_active = 1 AND user_type != 'api' AND m.id IS NULL ORDER BY u.name ASC";
		$query = Executor::doit($sql);
		return Model::many($query[0], new UserData());
	}

	public static function getLike($q){
		$sql = "SELECT * FROM ".self::$tablename." WHERE is_active=1 AND user_type != 'api' AND name LIKE '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new UserData());
	}

	public static function deleteById($id){
		$sql = "DELETE FROM ".self::$tablename." WHERE id=$id";
		Executor::doit($sql);
	}

	public function changeStatusById(){
		$sql = "UPDATE ".self::$tablename." SET is_active=\"$this->status_id\" WHERE id=$this->id";
		Executor::doit($sql);
	}

	public static function getNameById($id) {
        $id = intval($id);
        $sql = "SELECT name FROM ".self::$tablename." WHERE id = '$id' AND is_active = 1";
        $query = Executor::doit($sql);
        $result = Model::one($query[0], new UserData());
        return $result ? $result->name : '';
    }

	public static function getIdByName($name) {
        $name = $GLOBALS['conn']->real_escape_string($name);
        $sql = "SELECT id FROM ".self::$tablename." WHERE name = '$name' AND is_active = 1";
        $query = Executor::doit($sql);
        $result = Model::one($query[0], new UserData());
        return $result ? $result->id : 0;
    }
}
?>
