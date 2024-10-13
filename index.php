<?php
session_start();
$servername = "localhost";
$username = "your_username"; // Your MySQL username
$password = "your_password"; // Your MySQL password
$dbname = "resume_database"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM resumes WHERE user_id = '$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Của Tôi</title>
</head>
<body>
    <h1>Hồ Sơ Của Tôi</h1>
    <a href="logout.php">Đăng Xuất</a>
    <h2>Danh Sách Hồ Sơ</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['resume_title']) . " - " . htmlspecialchars($row['resume_content']) . "</li>";
            }
        } else {
            echo "<li>Chưa có hồ sơ nào.</li>";
        }
        ?>
    </ul>
    <a href="edit.php">Chỉnh Sửa Hồ Sơ</a>
    <a href="delete.php">Xóa Hồ Sơ</a>
</body>
</html>
