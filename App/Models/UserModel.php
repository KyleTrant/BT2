<?php
namespace App\Models;
use Shared\Database\Database;
class UserModel extends BaseModel {
    protected static $table = 'users';
    protected static $fillable = ['name', 'email', 'password'];
    protected static $timestamps = true;
    public function tasks() {
       TaskModel::getByUserId($this->id);
    }
    public static function findUser(string $gmail){
        $db =Database::getInstance();
        $db->connect();
        $sql = "SELECT * FROM " . static::$table . " WHERE gmail = ?";
        $stmt = $db->query($sql, [$gmail]);
        $result = $stmt->get_result()->fetch_assoc();
        $db->disConnect();
        return $result ? new static($result) : null;
    } 
}
