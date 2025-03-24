<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$maSV = $_SESSION['MaSV'];

// Lấy thông tin sinh viên
$sv = $conn->query("SELECT * FROM SinhVien WHERE MaSV = '$maSV'")->fetch_assoc();
$nganh = $conn->query("SELECT TenNganh FROM NganhHoc WHERE MaNganh = '{$sv['MaNganh']}'")->fetch_assoc()['TenNganh'];

// Lấy thông tin đăng ký gần nhất
$dk = $conn->query("SELECT * FROM DangKy WHERE MaSV = '$maSV' ORDER BY MaDK DESC LIMIT 1")->fetch_assoc();
$maDK = $dk['MaDK'];
$ngayDK = date('d/m/Y', strtotime($dk['NgayDK']));

// Lấy danh sách học phần đã lưu
$dsHP = $conn->query("SELECT h.MaHP, h.TenHP, h.SoTinChi 
                      FROM ChiTietDangKy ct
                      JOIN HocPhan h ON ct.MaHP = h.MaHP
                      WHERE ct.MaDK = '$maDK'");

$tongTC = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thông Tin Học Phần Đã Lưu</title>
    <style>
        body { font-family: Arial; padding: 40px; text-align: center; }
        h2 { color: green; margin-bottom: 30px; }
        table { margin: 0 auto; border-collapse: collapse; width: 70%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        .info { margin-top: 30px; }
        a { text-decoration: none; color: #007bff; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>

    <h2>✅ Thông Tin Học Phần Đã Lưu</h2>

    <div class="info">
        <p><strong>Mã số sinh viên:</strong> <?= $sv['MaSV'] ?></p>
        <p><strong>Họ tên:</strong> <?= $sv['HoTen'] ?></p>
        <p><strong>Ngày sinh:</strong> <?= date('d/m/Y', strtotime($sv['NgaySinh'])) ?></p>
        <p><strong>Ngành:</strong> <?= $sv['MaNganh'] ?> - <?= $nganh ?></p>
        <p><strong>Ngày đăng ký:</strong> <?= $ngayDK ?></p>
    </div>

    <br>
    <table>
        <tr><th>Mã HP</th><th>Tên Học Phần</th><th>Số Tín Chỉ</th></tr>
        <?php while ($hp = $dsHP->fetch_assoc()): 
            $tongTC += $hp['SoTinChi'];
        ?>
            <tr>
                <td><?= $hp['MaHP'] ?></td>
                <td><?= $hp['TenHP'] ?></td>
                <td><?= $hp['SoTinChi'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <p style="color:red; font-weight: bold;">Tổng số tín chỉ: <?= $tongTC ?></p>

    <a href="login.php">↩ Về trang chủ</a>

</body>
</html>
