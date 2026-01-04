<?php
include "headermain.php";

// Tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* ===============================
   1. THÊM SẢN PHẨM VÀO GIỎ HÀNG
=================================*/
if (isset($_POST['add_to_cart'])) {

    $id = $_POST['product_id'];

    // Nếu sản phẩm đã tồn tại -> tăng số lượng
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $_POST['quantity'];
    } 
    // Nếu sản phẩm chưa tồn tại -> thêm mới
    else {
        $_SESSION['cart'][$id] = [
            'name' => $_POST['product_name'],
            'price' => $_POST['product_price'],
            'img' => $_POST['product_img'],
            'quantity' => $_POST['quantity']
        ];
    }

    echo "<script>window.location='cartmain.php'</script>";
    exit;

}

/* ===============================
   2. XÓA SẢN PHẨM KHỎI GIỎ
=================================*/
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cartmain.php");
    exit;
}

/* ===============================
   3. CẬP NHẬT SỐ LƯỢNG
=================================*/
if (isset($_POST['update_cart'])) {

    foreach ($_POST['qty'] as $id => $quantity) {

        if ($quantity <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
        }
    }

    header("Location: cartmain.php");
    exit;
}
?>

<!----------------------------------- CART UI ---------------------------------------->
<section class="cart brick">
    <div class="container">
        <div class="cart-top-swap">
            <div class="cart-top">
                <div class="cart-top-cart card-top-item">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="cart-top-adress card-top-item">
                    <a href="deliverymain.php"><i class="fas fa-map-marker-alt"></i></a>
                </div>
                <div class="cart-top-payment card-top-item">
                    <a href="paymentmain.php"><i class="fas fa-money-check-alt"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form method="POST">

            <div class="cart-content row">
                <div class="cart-content-left">
                    <table>
                        <tr>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Xóa</th>
                        </tr>

                        <?php
                        $total = 0;

                        if (!empty($_SESSION['cart'])) {

                            foreach ($_SESSION['cart'] as $id => $item) {

                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                        ?>
                        <tr>
                            <td><img src="uploads/<?= $item['img'] ?>" width="90"></td>

                            <td><?= $item['name'] ?></td>

                            <td><?= number_format($item['price']) ?> đ</td>

                            <td>
                                <input type="number" min="1" name="qty[<?= $id ?>]" value="<?= $item['quantity'] ?>">
                            </td>

                            <td><?= number_format($subtotal) ?> đ</td>

                            <td>
                                <a href="cartmain.php?remove=<?= $id ?>" style="color:red;font-weight:bold;">X</a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center;'>🛒 Giỏ hàng trống</td></tr>";
                        }
                        ?>
                    </table>

                    <button style="margin-top:10px;" type="submit" name="update_cart">
                        Cập nhật giỏ hàng
                    </button>
                </div>

                <div class="cart-content-right">
                    <table>
                        <tr>
                            <th colspan="2">Tổng tiền giỏ hàng</th>
                        </tr>

                        <tr>
                            <td>Tổng sản phẩm</td>
                            <td><?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?></td>
                        </tr>

                        <tr>
                            <td>Tổng tiền hàng</td>
                            <td><?= number_format($total) ?> đ</td>
                        </tr>

                        <tr>
                            <td>Tạm tính</td>
                            <td style="font-weight:bold;color:black;">
                                <?= number_format($total) ?> đ
                            </td>
                        </tr>
                    </table>

                    <div class="cart-content-right-button">
                        <button><a href="cartegorymain.php">Tiếp tục mua hàng</a></button>

                        <?php if ($total > 0): ?>
                        <button><a href="deliverymain.php">Thanh toán</a></button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </form>
    </div>
</section>

<?php include "footermain.php"; ?>