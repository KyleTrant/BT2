<?php
require_once __DIR__ .'/../../Shared/Database/Database.php';
abstract class BaseModel{
    protected $attributes = []; 
    protected static $table = '';
    protected static $fillable = [];
    protected static $timestamps = true;
    public function __construct($data = [])
    {
        $this->fill($data); 
    }
    protected function fill($data) {
        foreach ($data as $key => $value) {
            if (in_array($key, static::$fillable)) {
                $this->attributes[$key] = $value;
                $this->$key = $value;
            }
        }
    }
    public function getAttributes() {
        return $this->attributes;
    }
    public static function GetAll() {
        $db = Database::getInstance();
        $db->connect();
        /**
         Array (
    [0] => Array ( [id] => 1, [name] => Alice, [email] => alice@example.com )
    [1] => Array ( [id] => 2, [name] => Bob, [email] => bob@example.com )
                )
         **/
        $results = $db->query("SELECT * FROM " . static::$table)->get_result()->fetch_all(MYSQLI_ASSOC);
        $db->disConnect();
        return array_map(fn($item) => new static($item), $results);
    }
    public static function find($id) {
        $db = Database::getInstance();
        $db->connect();
        $sql = "SELECT * FROM " . static::$table . " WHERE id = ?";
        $stmt = $db->query($sql, [$id]);
        $result = $stmt->get_result()->fetch_assoc();
        $db->disConnect();
        return $result ? new static($result) : null;
    }

    public static function create($data) {
        $db = Database::getInstance();
        $db->connect();
        $filteredData = array_intersect_key($data, array_flip(static::$fillable));
        if (empty($filteredData)) {
            return null;
        }
        $columns = implode(', ', array_keys($filteredData));
        $placeholders = implode(', ', array_fill(0, count($filteredData), '?'));
        $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";
        $db->query($sql, array_values($filteredData));
        $id = $db->getConnection()->insert_id;
        $db->disConnect();
        return static::find($id);
    }
    public static function update($id, $data) {
        $db = Database::getInstance();
        $db->connect();
        $filteredData = array_intersect_key($data, array_flip(static::$fillable));
        
        if (static::$timestamps) {
            $filteredData['updated_at'] = date('Y-m-d H:i:s');
        }
        if (empty($filteredData)) {
            return static::find($id);
        }
        $setString = implode(', ', array_map(fn($key) => "$key = ?", array_keys($filteredData)));
        $sql = "UPDATE " . static::$table . " SET $setString WHERE id = ?";
        $filteredData['id'] = $id;
        $db->query($sql, array_values($filteredData));
        $db->disConnect();
        return static::find($id);
    }
    public static function delete($id) {
        $db = Database::getInstance();
        $db->connect();
        $sql = "DELETE FROM " . static::$table . " WHERE id = ?";
        $db->query($sql, [$id]);
        $db->disConnect();
    }

}