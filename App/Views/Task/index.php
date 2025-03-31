<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách công việc</title>
    <link rel="stylesheet" href="/dist/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/public/js/Task.js"></script>
</head>
<body class="p-6 bg-gray-100">
    <a href="/Logout" class="text-red-500 font-bold">Logout</a>
    <h2 class="text-2xl font-bold mb-4">Danh sách công việc</h2>

    <button id="show-form" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">
    Thêm mới
    </button>
<div id="task-form-container" class="hidden">
    <h3 class="text-xl font-semibold mb-2">Thêm công việc mới</h3>
    <form id="task-form" class="bg-white p-4 shadow-md rounded-lg flex flex-col gap-2 max-w-md">
        <input type="text" id="title" placeholder="Tiêu đề" required class="border p-2 rounded">
        <input type="text" id="description" placeholder="Mô tả" class="border p-2 rounded">
        <input type="date" id="start_date" class="border p-2 rounded">
        <input type="time" id="start_time" class="border p-2 rounded">
        <input type="date" id="end_date" class="border p-2 rounded">
        <input type="time" id="end_time" class="border p-2 rounded">
        <select id="status" class="border p-2 rounded">
            <?php foreach ($statuses as $key => $label): ?>
                <option value="<?= $key ?>"><?= $label ?></option>
            <?php endforeach; ?>
        </select>
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Thêm</button>
            <button type="button" id="hide-form" class="bg-gray-400 text-white p-2 rounded hover:bg-gray-500">Hủy</button>
        </div>
    </form>
</div>
 <h2 class="text-2xl font-bold mt-6">Danh sách công việc</h2>
    <table class="w-full bg-white shadow-md rounded-lg mt-4">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Tiêu đề</th>
                <th class="p-2">Mô tả</th>
                <th class="p-2">Ngày bắt đầu</th>
                <th class="p-2">Giờ bắt đầu</th>
                <th class="p-2">Ngày kết thúc</th>
                <th class="p-2">Giờ kết thúc</th>
                <th class="p-2">Trạng thái</th>
                <th class="p-2">Hành động</th>
            </tr>
        </thead>
    <tbody id="task-list" class="divide-y">
        <?php foreach ($tasks as $task): ?>
                <td class="hidden"><?= $task->id ?></td>
                <td contenteditable="true" class="editable title"><?= htmlspecialchars($task->title) ?></td>
                <td contenteditable="true" class="editable description"><?= htmlspecialchars($task->description) ?></td>
                <td><input type="date" class="editable start_date" value="<?= $task->start_date ?>"></td>
                <td><input type="time" class="editable start_time" value="<?= $task->start_time ?>"></td>
                <td><input type="date" class="editable end_date" value="<?= $task->end_date ?>"></td>
                <td><input type="time" class="editable end_time" value="<?= $task->end_time ?>"></td>
                <td>
                    <select class="editable status border p-2 rounded">
                        <option value="pending" <?= $task->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="in_progress" <?= $task->status == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="completed" <?= $task->status == 'completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                </td>
                <td><button class="delete-task">Xóa</button></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>