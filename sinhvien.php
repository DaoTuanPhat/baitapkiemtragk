<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

// Lấy dữ liệu sinh viên + ngành
$sql = "SELECT sv.*, nh.TenNganh 
        FROM SinhVien sv 
        LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang Sinh Viên</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        h2 {
            color: #333;
        }

        .top-right {
            text-align: right;
            margin-bottom: 15px;
        }

        a {
            text-decoration: none;
            color: #0066cc;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        img {
            width: 80px;
            height: auto;
            border-radius: 6px;
        }

        .action-links a {
            margin: 0 4px;
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
        }

        .edit { background-color: #007bff; }
        .detail { background-color: #28a745; }
        .delete { background-color: #dc3545; }
    </style>
</head>
<body>

    <div class="top-right">
        Xin chào, <strong><?= $_SESSION['MaSV'] ?></strong> | 
        <a href="logout.php">Đăng xuất</a>
    </div>

    <h2>TRANG SINH VIÊN</h2>
    <p><a href="add_sinhvien.php">+ Add Student</a></p>

    <table>
        <tr>
            <th>MaSV</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Hình</th>
            <th>Ngành</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['MaSV'] ?></td>
            <td><?= $row['HoTen'] ?></td>
            <td><?= $row['GioiTinh'] ?></td>
            <td><?= date('d/m/Y', strtotime($row['NgaySinh'])) ?></td>
            <td><img src="<?= $row['Hinh'] ?>" alt="Ảnh sinh viên"></td>
            <td><?= $row['MaNganh'] ?></td>
            <td class="action-links">
                <a href="edit.php?MaSV=<?= $row['MaSV'] ?>" class="edit">Edit</a>
                <a href="detail.php?MaSV=<?= $row['MaSV'] ?>" class="detail">Details</a>
                <a href="delete.php?MaSV=<?= $row['MaSV'] ?>" class="delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
