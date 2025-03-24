<?php
include 'connect.php';

if (!isset($_GET['MaSV'])) {
    die("Thiếu mã sinh viên");
}

$MaSV = $_GET['MaSV'];

// Truy vấn dữ liệu sinh viên + ngành
$sql = "SELECT sv.*, nh.TenNganh 
        FROM SinhVien sv 
        LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
        WHERE sv.MaSV = '$MaSV'";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết sinh viên</title>
</head>
<body>
    <h2>Thông tin chi tiết</h2>
    <p><strong>Họ tên:</strong> <?= $row['HoTen'] ?></p>
    <p><strong>Giới tính:</strong> <?= $row['GioiTinh'] ?></p>
    <p><strong>Ngày sinh:</strong> <?= date('d/m/Y', strtotime($row['NgaySinh'])) ?></p>
    <p><strong>Hình:</strong><br><img src="<?= $row['Hinh'] ?>" width="150"></p>
    <p><strong>Mã ngành:</strong> <?= $row['MaNganh'] ?> - <?= $row['TenNganh'] ?></p>

    <br>
    <a href="edit.php?MaSV=<?= $row['MaSV'] ?>">Edit</a> |
    <a href="sinhvien.php">Back to List</a>
</body>
</html>