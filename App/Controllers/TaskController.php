<?php
namespace App\Controllers;
use App\Models\Task\TaskModel;
use App\Enums\TaskStatus;
class TaskController extends BaseController {
    protected $viewDir ="/App/Views/Task/";
    public function Index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /");
            exit;
        }
         $tasks = TaskModel::getByUserId($_SESSION['user_id']);
         $this->view('index', [
            'statuses' => TaskStatus::all(),
             'tasks' => $tasks
         ]);
    }
    public function Create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $data = [
                'user_id'    => $_SESSION['user_id'],
                'title'      => $_POST['title'] ?? '',
                'description'=> $_POST['description'] ?? '',
                'start_date' => $_POST['start_date'] ?? null,
                'start_time'  => $_POST['start_time'] ?? null,
                'end_date'    => $_POST['end_date'] ?? null,
                'end_time'    => $_POST['end_time'] ?? null,
                'status'     => $_POST['status'] ?? 'pending',
            ];
            if(!TaskModel::isValidTimeRange($data['start_date'],$data['start_time'],$data['end_date'],$data['end_time'])){
                echo json_encode(["success" => false, "message" => "Thời gian không hợp lệ"]);
                exit;
            }
            $task = TaskModel::create($data);
            if ($task) {
                echo json_encode(["success" => true, "task" => $task->GetAttributes()]);
            } else {
                echo json_encode(["success" => false, "message" => "Không thể tạo task"]);
            }
            exit;
        }
    }
    public function Update($taskId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $task = TaskModel::find($taskId);
            
            if (!$task || $task->user_id != $_SESSION['user_id']) {
                echo json_encode(['error' => 'Không có quyền chỉnh sửa công việc này']);
                exit;
            }
            $data = [];
            if (!empty($_POST['title'])) $data['title'] = $_POST['title'];
            if (!empty($_POST['description'])) $data['description'] = $_POST['description'];
            if (!empty($_POST['status'])) $data['status'] = $_POST['status'];
            if (!empty($_POST['start_date'])) $data['start_date'] = $_POST['start_date'];
            if (!empty($_POST['start_time'])) $data['start_time'] = $_POST['start_time'];
            if (!empty($_POST['end_date'])) $data['end_date'] = $_POST['end_date'];
            if (!empty($_POST['end_time'])) $data['end_time'] = $_POST['end_time'];
    
            if (!empty($data)) {
                TaskModel::update($taskId, $data);
                echo json_encode(['success' => 'Cập nhật thành công']);
            } else {
                echo json_encode(['error' => 'Không có dữ liệu để cập nhật']);
            }
            exit;
        }
    }
    public function delete($taskId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $task = TaskModel::find($taskId);
            if (!$task || $task->user_id != $_SESSION['user_id']) {
                echo json_encode(['error' => 'Không có quyền xóa công việc này']);
                exit;
            }
            TaskModel::delete($taskId);
            echo json_encode(['success' => 'Xóa thành công']);
        }
    }

}