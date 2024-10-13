<?php
session_start();
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "resume_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Kiểm tra email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Địa chỉ email không hợp lệ.";
    } else {
        // Cập nhật thông tin email trong cơ sở dữ liệu
        // Cần thêm logic cập nhật ở đây
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Thông Tin</title>
</head>
<body>
    <h1>Chỉnh Sửa Thông Tin</h1>
    <form action="edit.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <input type="submit" value="Cập Nhật">
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
