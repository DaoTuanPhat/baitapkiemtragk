<?php
session_start();
include 'connect.php';

// Nếu đã đăng nhập → chuyển hướng sang trang chính
if (isset($_SESSION['MaSV'])) {
    header("Location: sinhvien.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];

    $sql = "SELECT * FROM SinhVien WHERE MaSV = '$MaSV'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['MaSV'] = $MaSV; // lưu mã SV vào session
        header("Location: sinhvien.php"); // chuyển hướng sau đăng nhập
        exit();
    } else {
        $error = "❌ Mã sinh viên không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
</head>
<body>
    <h2>ĐĂNG NHẬP</h2>
    <form method="post">
        <label>MaSV:</label><br>
        <input type="text" name="MaSV" required><br><br>

        <button type="submit">Đăng Nhập</button>
    </form>

    <?php if ($error): ?>
        <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

    <a href="sinhvien.php">Back to List</a>
</body>
</html>