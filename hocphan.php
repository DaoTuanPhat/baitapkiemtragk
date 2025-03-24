<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

// Xử lý khi bấm nút đăng ký học phần
if (isset($_GET['MaHP'])) {
    $maHP = $_GET['MaHP'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (!in_array($maHP, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $maHP;
    }
    header("Location: dangky.php");
    exit();
}

// Lấy danh sách học phần
$sql = "SELECT * FROM HocPhan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head><title>Học phần</title></head>
<body>
    <h2>Danh sách học phần</h2>
    <table border="1">
        <tr><th>MaHP</th><th>Tên Học Phần</th><th>Số TC</th><th>Thao tác</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['MaHP'] ?></td>
                <td><?= $row['TenHP'] ?></td>
                <td><?= $row['SoTinChi'] ?></td>
                <td><a href="hocphan.php?MaHP=<?= $row['MaHP'] ?>">Đăng ký</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>