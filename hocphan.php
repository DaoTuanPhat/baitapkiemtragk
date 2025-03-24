<?php
include 'connect.php';

$sql = "SELECT * FROM HocPhan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách học phần</title>
    <style>
        table { width: 70%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        .btn { padding: 6px 12px; background: green; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; }
    </style>
</head>
<body>
    <h2>DANH SÁCH HỌC PHẦN</h2>
    <table>
        <tr>
            <th>Mã Học Phần</th>
            <th>Tên Học Phần</th>
            <th>Số Tín Chỉ</th>
            <th>Thao tác</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['MaHP'] ?></td>
                <td><?= $row['TenHP'] ?></td>
                <td><?= $row['SoTinChi'] ?></td>
                <td>
                    <a href="dangky.php?MaHP=<?= $row['MaHP'] ?>" class="btn">Đăng ký</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>