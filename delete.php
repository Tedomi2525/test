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

if (isset($_GET['id'])) {
    $resume_id = $_GET['id'];
    // Hiển thị xác nhận xóa
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "DELETE FROM resumes WHERE id = '$resume_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Hồ sơ đã được xóa.";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
} else {
    echo "Không tìm thấy hồ sơ để xóa.";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xóa Hồ Sơ</title>
</head>
<body>
    <h1>Xóa Hồ Sơ</h1>
    <p>Bạn có chắc chắn muốn xóa hồ sơ này không?</p>
    <form action="delete.php?id=<?php echo $resume_id; ?>" method="POST">
        <input type="submit" value="Xóa">
    </form>
    <a href="index.php">Trở Về</a>
</body>
</html>
