
$(document).ready(function () {
    $("#show-form").click(function () {
            $("#task-form-container").slideDown();
        });

        $("#hide-form").click(function () {
            $("#task-form-container").slideUp();
        });
    $("#task-form").on("submit", function (e) {
        e.preventDefault();
        let data = {
            title: $("#title").val(),
            description: $("#description").val(),
            start_date: $("#start_date").val(),
            start_time: $("#start_time").val(),
            end_date: $("#end_date").val(),
            end_time: $("#end_time").val(),
            status: $("#status").val()
        };
        $.post("/Tasks/Create", data, function (response) {
    let result;
    try {
        result = JSON.parse(response);
        if (result.success) {
            alert("Công việc đã được cập nhật!");
        } else {
            alert("Cập nhật thất bại: " + result.message);
        }

    } catch (error) {
        console.error("Lỗi khi parse JSON:", error, "Response từ server:", response);
        return;
    }
    let newTask = parsedResponse.task;

    $("#task-list").append(`
        <tr data-id="${newTask.id}">
           <td class="hidden"><?= ${newTask.id}?></td>
            <td contenteditable="true" class="editable title">${newTask.title}</td>
            <td contenteditable="true" class="editable description">${newTask.description}</td>
            <td><input type="date" class="editable start_date" value="${newTask.start_date || ''}"></td>
            <td><input type="time" class="editable start_time" value="${newTask.start_time || ''}"></td>
            <td><input type="date" class="editable end_date" value="${newTask.end_date || ''}"></td>
            <td><input type="time" class="editable end_time" value="${newTask.end_time || ''}"></td>
            <td>
                <select class="editable status border p-2 rounded">
                    <option value="pending" ${newTask.status == 'pending' ? 'selected' : ''}>Pending</option>
                    <option value="in_progress" ${newTask.status == 'in_progress' ? 'selected' : ''}>In Progress</option>
                    <option value="completed" ${newTask.status == 'completed' ? 'selected' : ''}>Completed</option>
                </select>
            </td>
            <td><button class="delete-task">Xóa</button></td>
        </tr>
    `);
});

    });
  $(document).on("blur", ".editable", function () {
    let row = $(this).closest("tr");
    let taskId = row.data("id");
    let updatedData = {
        title: row.find(".title").text().trim(),
        description: row.find(".description").text().trim(),
        start_date: row.find(".start_date").val(),
        start_time: row.find(".start_time").val(),
        end_date: row.find(".end_date").val(),
        end_time: row.find(".end_time").val(),
        status: row.find(".status").val()
    };
    $.post(`/Tasks/Update/${taskId}`, updatedData, function (response) {
        try {
            let result = JSON.parse(response);
            if (result.success) {
                alert("Công việc đã được cập nhật!");
            } else {
                alert("Cập nhật thất bại: " + result.message);
            }
        } catch (error) {
            console.error("Lỗi khi xử lý JSON:", error, "Response:", response);
            alert("Có lỗi xảy ra khi cập nhật!");
        }
    }).fail(function (xhr) {
        console.error("Lỗi AJAX:", xhr.responseText);
        alert("Lỗi khi kết nối server!");
    });
});

    $(document).on("click", ".delete-task", function () {
        if (confirm("Bạn có chắc muốn xóa công việc này?")) {
            let row = $(this).closest("tr");
            let taskId = row.data("id");
            $.post("/Tasks/Delete/" + taskId, function () {
                row.remove();
            });
        }
    });
});