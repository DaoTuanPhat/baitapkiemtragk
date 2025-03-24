<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

// Xử lý xoá 1 học phần trong giỏ
if (isset($_GET['remove'])) {
    $removeMaHP = $_GET['remove'];
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($hp) use ($removeMaHP) {
            return $hp !== $removeMaHP;
        });
    }
    header("Location: dangky.php");
    exit();
}

// Xử lý xoá toàn bộ giỏ
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: dangky.php");
    exit();
}

$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng Ký Học Phần</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        h2 { margin-top: 30px; }
        .action a { color: red; text-decoration: none; }
        .summary { color: red; font-weight: bold; }
        .link-action { margin-right: 10px; }
    </style>
</head>
<body>
    <h2>Đăng Ký Học Phần</h2>

    <?php if (count($cart) === 0): ?>
        <p class="summary">Số học phần: 0</p>
        <p class="summary">Tổng số tín chỉ: 0</p>
    <?php else: ?>
        <table>
            <tr>
                <th>MaHP</th>
                <th>Tên Học Phần</th>
                <th>Số Tín Chỉ</th>
                <th>Thao tác</th>
            </tr>
            <?php
            $tongTC = 0;
            foreach ($cart as $maHP):
                $hp = $conn->query("SELECT * FROM HocPhan WHERE MaHP = '$maHP'")->fetch_assoc();
                $tongTC += $hp['SoTinChi'];
            ?>
            <tr>
                <td><?= $hp['MaHP'] ?></td>
                <td><?= $hp['TenHP'] ?></td>
                <td><?= $hp['SoTinChi'] ?></td>
                <td class="action">
                    <a href="dangky.php?remove=<?= $hp['MaHP'] ?>" onclick="return confirm('Xoá học phần này?')">Xoá</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <p class="summary">Số học phần: <?= count($cart) ?></p>
        <p class="summary">Tổng số tín chỉ: <?= $tongTC ?></p>

        <a class="link-action" href="dangky.php?clear=1" onclick="return confirm('Xoá toàn bộ học phần trong giỏ?')">Xoá Đăng Ký</a>
        <a class="link-action" href="luudangky.php">Lưu đăng ký</a>
    <?php endif; ?>
</body>
</html>