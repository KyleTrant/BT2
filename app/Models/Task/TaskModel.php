<?php
require_once __DIR__ . '/../BaseModel.php';
require_once __DIR__ . '/TaskInput.php';
class Task extends BaseModel {
    protected static $table = 'tasks';
    protected static $fillable = ['id','user_id', 'title', 'description', 'start_time', 'end_time', 'start_date', 'end_date', 'status'];
    protected static $timestamps = true;
    public static function getByUserId($userId) {
        $db = Database::getInstance();
        $db->connect();
        $sql = "SELECT * FROM " . static::$table . " WHERE user_id = ?";
        $stmt = $db->query($sql, [$userId]);
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $db->disConnect();
        return array_map(fn($item) => new static($item), $results);
    }
    public static function getInput(TaskInput $data) {
        $db = Database::getInstance();
        $whereClauses = [];
        $params = [];
        if (!empty($data->titleLike)) {
            $whereClauses[] = "title LIKE ?";
            $params[] = "%" . $data->titleLike . "%";
        }
        if ($data->status) {
            $whereClauses[] = "status = ?";
            $params[] = $data->status;
        }
        if ($data->userId) {
            $whereClauses[] = "user_id = ?";
            $params[] = $data->userId;
        }
        if ($data->startDateMin) {
            $whereClauses[] = "start_date >= ?";
            $params[] = $data->startDateMin;
        }
        if ($data->startDateMax) {
            $whereClauses[] = "start_date <= ?";
            $params[] = $data->startDateMax;
        }
        if ($data->endDateMin) {
            $whereClauses[] = "end_date >= ?";
            $params[] = $data->endDateMin;
        }
        if ($data->endDateMax) {
            $whereClauses[] = "end_date <= ?";
            $params[] = $data->endDateMax;
        }
        if ($data->priorityMin) {
            $whereClauses[] = "priority >= ?";
            $params[] = $data->priorityMin;
        }
        if ($data->priorityMax) {
            $whereClauses[] = "priority <= ?";
            $params[] = $data->priorityMax;
        }
        $whereClause = implode(' AND ', $whereClauses);
        $sql = "SELECT * FROM " . static::$table;
        if ($whereClause) {
            $sql .= " WHERE " . $whereClause;
        }
        $stmt = $db->query($sql, $params);
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $db->disConnect();
        return array_map(fn($item) => new static($item), $results);
    }
}
