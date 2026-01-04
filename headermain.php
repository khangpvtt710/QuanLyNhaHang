<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectronicsBuy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/cartegory.css">
    <link rel="stylesheet" href="css/delivery.css">
    <link rel="stylesheet" href="css/payment.css">
    <link rel="stylesheet" href="css/product.css">

</head>
<?php
session_start();
include "class/cartegory-class.php";
include "class/brand-class.php";

?>
<?php
$cartegory = new cartegoryclass;
$brand = new brandclass;
$show_cartegory = $cartegory->show_cartegory();
?>

<body>

    <header>
        <div class="logo">
            <img src="img/logofood.png" alt="">
        </div>
        <div class="menu">

            <?php
            // Kiểm tra xem có danh mục nào được trả về không
            if ($show_cartegory) {
                // Lặp qua từng danh mục
                while ($category_result = $show_cartegory->fetch_assoc()) {
            ?>
            <li>
                <a
                    href="cartegory.php?id=<?php echo $category_result['cartegory_id']; ?>"><?php echo $category_result['cartegory_name']; ?></a>
                <?php
                        // Lấy danh sách loại sản phẩm thuộc danh mục hiện tại
                        $brands_for_category = $brand->get_brands_by_cartegory($category_result['cartegory_id']);

                        // Kiểm tra xem có loại sản phẩm nào cho danh mục này không
                        if ($brands_for_category) {
                        ?>
                <ul class="sub-menu">

                    <?php
                                // Lặp qua từng loại sản phẩm (thương hiệu)
                                while ($brand_result = $brands_for_category->fetch_assoc()) {
                                ?>
                    <li>
                        <a
                            href="cartegorymain.php?brand_id=<?php echo $brand_result['brand_id']; ?>"><?php echo $brand_result['brand_name']; ?></a>
                    </li>
                    <?php
                                }
                                ?>
                </ul>
                <?php
                        }
                        ?>
            </li>
            <?php
                }
            }
            ?>

            <!--_-------------------------------------------->
        </div>


        <div class="others">

            <li><input placeholder="Tìm Kiếm" type="text"> <img src="img/search.png"></li>
            <li><a class="fa fa-home" href="index.php"></a></li>
            <li><a class="fa fa-shopping-bag" href="cartmain.php"></a></li>

            <?php if (isset($_SESSION['user_login'])): ?>

            <!-- HIỂN THỊ TÊN USER -->
            <li style="color:#ff7a00; font-weight:bold;">
                👤 <?php echo $_SESSION['user_login']; ?>
            </li>

            <!-- NÚT QUẢN LÝ CHỈ DÀNH CHO ADMIN -->
            <?php if ($_SESSION['user_login'] === 'admin'): ?>
            <li>
                <a href="admin/index.php" class="login-btn">Quản lý</a>
            </li>
            <?php endif; ?>

            <!-- ĐĂNG XUẤT -->
            <li>
                <a href="logout.php" class="login-btn" style="background:#555;">Đăng xuất</a>
            </li>

            <?php else: ?>

            <!-- CHƯA ĐĂNG NHẬP -->
            <li>
                <button class="login-btn" onclick="window.location.href='login.php'">
                    Đăng nhập
                </button>
            </li>

            <?php endif; ?>

        </div>

        <div>
            <style>
            .login-btn {
                background-color: #ff7a00;
                /* Màu cam */
                color: white;
                padding: 10px 25px;
                border: none;
                border-radius: 8px;
                /* Bo góc */
                font-size: 16px;
                font-weight: bold;
                cursor: pointer;
                float: right;
                /* Căn lề phải */
                margin: 10px;
                transition: 0.3s;
            }

            .login-btn:hover {
                background-color: #e56c00;
                /* Đậm hơn khi hover */
            }
            </style>


        </div>
    </header>