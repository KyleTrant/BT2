<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/dist/style.css">
</head>
<body class="flex flex-col items-center justify-center min-h-screen bg-gray-100">

    <a href="/Login" class="mb-4 text-blue-500 hover:underline">Quay lại</a>

    <form action="/Register" method="POST" class="bg-white p-6 rounded-lg shadow-md w-80">
        <h2 class="text-xl font-bold mb-4 text-center text-gray-700">Đăng ký</h2>

        <input type="text" name="name" placeholder="Họ và tên" required 
            class="w-full p-2 border rounded mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="email" name="gmail" placeholder="Email" required 
            class="w-full p-2 border rounded mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="password" name="password" placeholder="Mật khẩu" required 
            class="w-full p-2 border rounded mb-4 focus:outline-none focus:ring-2 focus:ring-blue-400">

        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
            Đăng ký
        </button>
    </form>

    <?php if (isset($error)) echo "<p class='text-red-600 mt-4'>$error</p>"; ?>

</body>
</html>
