<?php
include 'connect.php';

if (!isset($_GET['MaSV'])) {
    die("Thiếu mã sinh viên");
}

$MaSV = $_GET['MaSV'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Kiểm tra upload ảnh mới
    if (!empty($_FILES["Hinh"]["name"])) {
        $target_dir = "Content/images/";
        $file_name = basename($_FILES["Hinh"]["name"]);
        $target_file = $target_dir . $file_name;
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file);
        $hinh_sql = ", Hinh='$target_file'";
    } else {
        $hinh_sql = "";
    }

    $sql = "UPDATE SinhVien 
            SET HoTen='$HoTen', GioiTinh='$GioiTinh', NgaySinh='$NgaySinh', MaNganh='$MaNganh' $hinh_sql 
            WHERE MaSV='$MaSV'";

    if ($conn->query($sql) === TRUE) {
        header("Location: sinhvien.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Load dữ liệu sinh viên
$sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa thông tin sinh viên</title>
</head>
<body>
    <h2>Hiệu chỉnh thông tin sinh viên</h2>
    <form method="post" enctype="multipart/form-data">
        Họ tên: <input type="text" name="HoTen" value="<?= $row['HoTen'] ?>"><br><br>
        Giới tính: <input type="text" name="GioiTinh" value="<?= $row['GioiTinh'] ?>"><br><br>
        Ngày sinh: <input type="date" name="NgaySinh" value="<?= $row['NgaySinh'] ?>"><br><br>
        Hình: <input type="file" name="Hinh"><br>
        <img src="<?= $row['Hinh'] ?>" width="120"><br><br>
        Mã ngành: <input type="text" name="MaNganh" value="<?= $row['MaNganh'] ?>"><br><br>

        <button type="submit">Save</button>
        <a href="sinhvien.php">Back</a>
    </form>
</body>
</html>