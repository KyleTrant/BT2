<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lỗi <?php echo htmlspecialchars($errorCode); ?></title>
</head>
<body>
    <h1>Mã lỗi: <?php echo htmlspecialchars($errorCode); ?></h1>
    <p><?php echo htmlspecialchars($errorMessage); ?></p>
    <a href="/">Quay lại trang chủ</a>
</body>
</html>
