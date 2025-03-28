<?php $title = "Danh sách công việc"; ?>

<h2>Danh sách công việc</h2>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Mô tả</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= $task->id ?></td>
                <td><?= htmlspecialchars($task->title) ?></td>
                <td><?= htmlspecialchars($task->description) ?></td>
                <td><?= $task->start_date ?></td>
                <td><?= $task->end_date ?></td>
                <td><?= $task->status ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
