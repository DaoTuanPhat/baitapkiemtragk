<?php
include 'connect.php';

if (!isset($_GET['MaSV'])) {
    die("Thiếu mã sinh viên");
}

$MaSV = $_GET['MaSV'];

// Nếu người dùng xác nhận xoá
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM SinhVien WHERE MaSV='$MaSV'";
    if ($conn->query($sql) === TRUE) {
        header("Location: sinhvien.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Lấy dữ liệu sinh viên
$sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Xóa sinh viên</title>
</head>
<body>
    <h2>XÓA THÔNG TIN</h2>
    <p>Are you sure you want to delete this?</p>
    <p><strong>Họ tên:</strong> <?= $row['HoTen'] ?></p>
    <p><strong>Giới tính:</strong> <?= $row['GioiTinh'] ?></p>
    <p><strong>Ngày sinh:</strong> <?= $row['NgaySinh'] ?></p>
    <p><img src="<?= $row['Hinh'] ?>" width="120"></p>
    <p><strong>Ngành:</strong> <?= $row['MaNganh'] ?></p>

    <form method="post">
        <button type="submit">Xóa</button>
        <a href="sinhvien.php">Back to List</a>
    </form>
</body>
</html>