<?php
namespace App\Models\Task;
use App\Models\BaseModel;
use Shared\Database\Database;
class TaskModel extends BaseModel {
    protected static $table = 'tasks';
    protected static $fillable = ['user_id', 'title', 'description', 'start_time', 'end_time', 'start_date', 'end_date', 'status'];
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
        if (!empty($data->status)) {
            $whereClauses[] = "status = ?";
            $params[] = $data->status;
        }
        if ($data->userId) {
            $whereClauses[] = "user_id = ?";
            $params[] = $data->userId;
        }
        if (!empty($data->startDateMin)) {
            $whereClauses[] = "start_date >= ?";
            $params[] = $data->startDateMin;
        }
        if (!empty($data->startDateMax)) {
            $whereClauses[] = "start_date <= ?";
            $params[] = $data->startDateMax;
        }
        if (!empty($data->endDateMin)) {
            $whereClauses[] = "end_date >= ?";
            $params[] = $data->endDateMin;
        }
        if (!empty($data->endDateMax)) {
            $whereClauses[] = "end_date <= ?";
            $params[] = $data->endDateMax;
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
    public static function isValidTimeRange($startDate, $startTime, $endDate, $endTime){
    if (empty($startDate) || empty($startTime) || empty($endDate) || empty($endTime)) {
        return false;
    }
    $startDateTime = strtotime("$startDate $startTime");
    $endDateTime = strtotime("$endDate $endTime");
    if ($startDateTime === false || $endDateTime === false || $startDateTime >= $endDateTime) {
        return false;
    }
    return true; 
}

}
