<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/dist/style.css">
</head>
<body class="flex flex-col items-center justify-center min-h-screen bg-gray-100">

    <?php if (isset($success)) echo "<p class='text-green-600'>$success</p>"; ?>

    <div class="space-x-4 mb-4">
        <a href="/Register" class="text-blue-500 hover:underline">Đăng ký</a>
    </div>

    <form action="/Login" method="POST" class="bg-white p-6 rounded-lg shadow-md w-80">
        <h2 class="text-xl font-bold mb-4 text-center">Đăng nhập</h2>
        <input type="email" name="gmail" placeholder="Email" required 
            class="w-full p-2 border rounded mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="password" name="password" placeholder="Mật khẩu" required 
            class="w-full p-2 border rounded mb-4 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button type="submit" 
            class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Nhập</button>
    </form>

    <?php if (isset($error)) echo "<p class='text-red-600 mt-4'>$error</p>"; ?>

</body>
</html>
