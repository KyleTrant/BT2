<?php 
    require_once __DIR__ . '/app/Models/UserModel.php';
    $data = [
        'name' => 'John Doe',
        'email' => 'john.doe4123@example.com',
        'password' => 'password123'
    ];
   
    $user = User::create($data);
    echo "Created User: \n";
    var_dump($user); // In ra đối tượng người dùng vừa tạo
    
    // Kiểm tra việc tìm kiếm người dùng theo ID
    $foundUser = User::find($user->getAttributes()['id']);
    echo "Found User by ID: \n";
    var_dump($foundUser);
    
    // Kiểm tra việc cập nhật thông tin người dùng
    $updatedData = [
        'name' => 'Updated John',
        'email' => 'updated.john@example.com'
    ];
    $updatedUser = User::update($user->getAttributes()['id'], $updatedData);
    echo "Updated User: \n";
    var_dump($updatedUser);
    
    // Kiểm tra việc xóa người dùng
    $userIdToDelete = $updatedUser->getAttributes()['id'];
    User::delete($userIdToDelete);
    echo "Deleted User. Trying to find again: \n";
    $deletedUser = User::find($userIdToDelete);
    var_dump($deletedUser); // Kết quả phải là null
?>
