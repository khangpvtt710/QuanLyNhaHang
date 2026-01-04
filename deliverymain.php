<?php
include "headermain.php";

// GIỎ HÀNG NẰM TRONG SESSION
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// TÍNH TỔNG
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
$vat = $total * 0.1;
$grand_total = $total + $vat;
?>

<!-----------------------------------delivery----------------------------------------->
<section class="delivery brick">
    <div class="container">
        <div class="delivery-top-swap">
            <div class="delivery-top">
                <div class="delivery-top-delivery delivery-top-item">
                    <a href="cartmain.php"><i class="fas fa-shopping-cart"></i></a>
                </div>
                <div class="delivery-top-adress delivery-top-item">
                    <a href="deliverymain.php"><i class="fas fa-map-marker-alt"></i></a>
                </div>
                <div class="delivery-top-payment delivery-top-item">
                    <a href="paymentmain.php"><i class="fas fa-money-check-alt"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="delivery-content row">

            <!-- FORM GIAO HÀNG -->
            <div class="delivery-content-left">
                <form action="paymentmain.php" method="POST">

                    <p>Vui lòng chọn địa chỉ giao hàng</p>

                    <div class="delivery-content-left-khachle row">
                        <input name="loaikhach" type="radio" checked>
                        <p><b>Khách lẻ</b></p>
                    </div>

                    <div class="delivery-content-left-input-top row">
                        <div class="delivery-content-left-input-top-item">
                            <label>Họ tên *</label>
                            <input type="text" name="fullname" required>
                        </div>
                        <div class="delivery-content-left-input-top-item">
                            <label>Điện thoại *</label>
                            <input type="text" name="phone" required>
                        </div>
                        <div class="delivery-content-left-input-top-item">
                            <label>Tỉnh / TP *</label>
                            <input type="text" name="city" required>
                        </div>
                        <div class="delivery-content-left-input-top-item">
                            <label>Quận / Huyện *</label>
                            <input type="text" name="district" required>
                        </div>
                    </div>

                    <div class="delivery-content-left-input-botton">
                        <label>Địa chỉ *</label>
                        <input type="text" name="address" required>
                    </div>

                    <div class="delivery-content-left-button">
                        <a href="cartmain.php">◄ Quay lại giỏ hàng</a>

                        <button type="submit">
                            THANH TOÁN & GIAO HÀNG
                        </button>
                    </div>

                </form>
            </div>

            <!-- BÊN PHẢI: DANH SÁCH SẢN PHẨM -->
            <div class="delivery-content-right">
                <table>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>

                    <?php if (!$cart): ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            🛒 Giỏ hàng đang trống
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php foreach ($cart as $id => $item): ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td><?= number_format($item['price']) ?> đ</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'] * $item['quantity']) ?> đ</td>
                    </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="3"><b>Tạm tính</b></td>
                        <td><b><?= number_format($total) ?> đ</b></td>
                    </tr>

                    <tr>
                        <td colspan="3"><b>VAT 10%</b></td>
                        <td><b><?= number_format($vat) ?> đ</b></td>
                    </tr>

                    <tr>
                        <td colspan="3"><b>Tổng tiền</b></td>
                        <td style="color:red; font-weight:bold;">
                            <?= number_format($grand_total) ?> đ
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</section>

<?php include "footermain.php"; ?>