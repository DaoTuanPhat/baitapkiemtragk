<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Xử lý ảnh
    $target_dir = "Content/images/";
    $file_name = basename($_FILES["Hinh"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh)
                VALUES ('$MaSV', '$HoTen', '$GioiTinh', '$NgaySinh', '$target_file', '$MaNganh')";

        if ($conn->query($sql) === TRUE) {
            echo "Thêm sinh viên thành công. <a href='sinhvien.php'>Quay lại danh sách</a>";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    } else {
        echo "Lỗi upload hình.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm Sinh Viên</title>
</head>
<body>
    <h2>THÊM SINH VIÊN</h2>
    <form action="add_sinhvien.php" method="post" enctype="multipart/form-data">
        <label>MaSV:</label><br>
        <input type="text" name="MaSV" required><br><br>

        <label>HoTen:</label><br>
        <input type="text" name="HoTen" required><br><br>

        <label>GioiTinh:</label><br>
        <input type="text" name="GioiTinh" required><br><br>

        <label>NgaySinh:</label><br>
        <input type="date" name="NgaySinh" required><br><br>

        <label>Hinh:</label><br>
        <input type="file" name="Hinh" accept="image/*" required><br><br>

        <label>MaNganh:</label><br>
        <input type="text" name="MaNganh" required><br><br>

        <button type="submit">Create</button>
        <a href="sinhvien.php">Cancel</a>
    </form>
</body>
</html>