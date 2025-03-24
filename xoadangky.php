<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];

// Tìm MaDK của sinh viên đang đăng nhập
$sql = "SELECT MaDK FROM DangKy WHERE MaSV = '$MaSV'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $maDK = $row['MaDK'];

    // Xóa các học phần trong ChiTietDangKy
    $conn->query("DELETE FROM ChiTietDangKy WHERE MaDK = '$maDK'");

    // (tuỳ chọn) Xoá luôn bản ghi trong bảng DangKy nếu bạn muốn "reset hoàn toàn"
    // $conn->query("DELETE FROM DangKy WHERE MaSV = '$MaSV'");
}

header("Location: dangky.php");
exit();
?>