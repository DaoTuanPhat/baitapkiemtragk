<?php
session_start();
include 'connect.php';

if (count($_SESSION['cart']) < 2) {
    echo "<script>
        alert('⚠️ Bạn phải chọn ít nhất 2 học phần để lưu đăng ký!');
        window.location.href='dangky.php';
    </script>";
    exit();
}

$maSV = $_SESSION['MaSV'];
$cart = $_SESSION['cart'];

// Lấy thông tin sinh viên
$sv = $conn->query("SELECT * FROM SinhVien WHERE MaSV = '$maSV'")->fetch_assoc();
$nganh = $conn->query("SELECT TenNganh FROM NganhHoc WHERE MaNganh = '{$sv['MaNganh']}'")->fetch_assoc()['TenNganh'];

$ngayDangKy = date("d/m/Y");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận đăng ký</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 60%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        .info { margin-top: 30px; padding: 15px; border: 1px solid #aaa; width: 400px; }
        .btn { padding: 8px 16px; background: green; color: white; border: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>Thông tin Đăng kí</h2>

    <table>
        <tr><th>MaHP</th><th>Tên Học Phần</th><th>Số Tín Chỉ</th></tr>
        <?php
        $tong = 0;
        foreach ($cart as $maHP) {
            $hp = $conn->query("SELECT * FROM HocPhan WHERE MaHP = '$maHP'")->fetch_assoc();
            $tong += $hp['SoTinChi'];
            echo "<tr><td>{$hp['MaHP']}</td><td>{$hp['TenHP']}</td><td>{$hp['SoTinChi']}</td></tr>";
        }
        ?>
    </table>
    <p style="color:red">Số lượng học phần: <?= count($cart) ?> <br> Tổng số tín chỉ: <?= $tong ?></p>

    <div class="info">
        <p><strong>Mã số sinh viên:</strong> <?= $sv['MaSV'] ?></p>
        <p><strong>Họ Tên:</strong> <?= $sv['HoTen'] ?></p>
        <p><strong>Ngày Sinh:</strong> <?= date('d/m/Y', strtotime($sv['NgaySinh'])) ?></p>
        <p><strong>Ngành Học:</strong> <?= $sv['MaNganh'] ?> - <?= $nganh ?></p>
        <p><strong>Ngày Đăng Ký:</strong> <?= $ngayDangKy ?></p>

        <form method="post" action="xacnhandangky.php">
            <button type="submit" class="btn">Xác Nhận</button>
        </form>
    </div>
</body>
</html>
