<?php
require_once __DIR__ . '/BaseModel.php';
require_once __DIR__ . '/Task/TaskModel.php';
class User extends BaseModel {
    protected static $table = 'users';
    protected static $fillable = ['id','name', 'email', 'password'];
    protected static $timestamps = true;
    public function tasks() {
       Task::getByUserId($this->attributes['id']);
    }
}
