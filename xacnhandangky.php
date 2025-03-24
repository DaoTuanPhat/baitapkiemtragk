<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['MaSV']) || !isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    header("Location: dangky.php");
    exit();
}

$maSV = $_SESSION['MaSV'];
$cart = $_SESSION['cart'];

// Kiểm tra MaDK có chưa
$get = $conn->query("SELECT MaDK FROM DangKy WHERE MaSV = '$maSV'");
if ($get->num_rows > 0) {
    $maDK = $get->fetch_assoc()['MaDK'];
} else {
    // Tạo mới
    $conn->query("INSERT INTO DangKy (NgayDK, MaSV) VALUES (CURDATE(), '$maSV')");
    $maDK = $conn->insert_id;
}

// Lưu vào ChiTietDangKy nếu chưa có
foreach ($cart as $maHP) {
    $check = $conn->query("SELECT * FROM ChiTietDangKy WHERE MaDK = '$maDK' AND MaHP = '$maHP'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$maDK', '$maHP')");

        $conn->query("UPDATE HocPhan SET Soluong = Soluong - 1 WHERE MaHP = '$maHP' AND Soluong > 0");

    }
}

// Xóa giỏ hàng
unset($_SESSION['cart']);

echo "<script>alert('Đăng ký thành công!'); window.location='thongbao.php';</script>";
