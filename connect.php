<?php
$host = "localhost";
$user = "root";
$pass = ""; // sửa nếu có mật khẩu
$db = "Test1"; // thay bằng tên CSDL của bạn

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>