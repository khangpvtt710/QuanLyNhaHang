<?php
include "headermain.php";

// ==========================
// 1. NHẬN THÔNG TIN TỪ DELIVERY
// ==========================
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $_SESSION['shipping'] = [
        "fullname" => $_POST['fullname'],
        "phone" => $_POST['phone'],
        "city" => $_POST['city'],
        "district" => $_POST['district'],
        "address" => $_POST['address']
    ];
}

// ==========================
// 2. LẤY GIỎ HÀNG
// ==========================
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// ==========================
// 3. TÍNH TIỀN
// ==========================
$total = 0;
foreach ($cart as $item){
    $total += $item['price'] * $item['quantity'];
}
$vat = $total * 0.1;
$grand_total = $total + $vat;
?>

<!---------------------------Payment------------------------------------------------->
<section class="payment brick">
    <div class="container">

        <h2 style="margin: 10px 0;">Thanh toán đơn hàng</h2>

        <div class="payment-content row">

            <!-- ========== TRÁI: PHƯƠNG THỨC THANH TOÁN ========= -->
            <div class="payment-content-left">

                <form action="order_success.php" method="POST">

                    <div class="payment-content-left-method-delivery">
                        <p style="font-weight:bold;font-size:18px;">Thông tin giao hàng</p>

                        <?php if(isset($_SESSION['shipping'])): ?>
                        <p><b>Họ tên:</b> <?= $_SESSION['shipping']['fullname'] ?></p>
                        <p><b>SĐT:</b> <?= $_SESSION['shipping']['phone'] ?></p>
                        <p><b>Địa chỉ:</b>
                            <?= $_SESSION['shipping']['address'] ?>,
                            <?= $_SESSION['shipping']['district'] ?>,
                            <?= $_SESSION['shipping']['city'] ?>
                        </p>
                        <?php else: ?>
                        <p style="color:red;">⚠ Bạn chưa nhập địa chỉ</p>
                        <?php endif; ?>
                    </div>

                    <hr>

                    <p style="font-weight:bold;">Chọn phương thức thanh toán</p>

                    <label>
                        <input type="radio" name="payment_method" value="COD" checked>
                        Thanh toán khi nhận hàng (COD)
                    </label><br>

                    <label>
                        <input type="radio" name="payment_method" value="ATM">
                        Thẻ ATM / Internet Banking
                    </label><br>

                    <label>
                        <input type="radio" name="payment_method" value="MOMO">
                        Ví MoMo
                    </label><br>

                    <label>
                        <input type="radio" name="payment_method" value="VISA">
                        Thẻ Visa / Mastercard
                    </label><br>

                    <br>

                    <button type="submit"
                        style="padding:12px 25px;background:orangered;color:white;border:none;border-radius:6px;cursor:pointer;">
                        XÁC NHẬN THANH TOÁN
                    </button>

                </form>

            </div>

            <!-- ========== PHẢI: HÓA ĐƠN ========= -->
            <div class="payment-content-right">
                <table border="1" width="100%" cellpadding="5">

                    <tr>
                        <th>Sản phẩm</th>
                        <th>SL</th>
                        <th>Thành tiền</th>
                    </tr>

                    <?php if($cart): foreach($cart as $item): ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'] * $item['quantity']) ?> đ</td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="3" style="text-align:center;">🛒 Giỏ hàng trống</td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td colspan="2"><b>Tạm tính</b></td>
                        <td><b><?= number_format($total) ?> đ</b></td>
                    </tr>

                    <tr>
                        <td colspan="2"><b>VAT 10%</b></td>
                        <td><b><?= number_format($vat) ?> đ</b></td>
                    </tr>

                    <tr>
                        <td colspan="2"><b>Tổng thanh toán</b></td>
                        <td style="color:red;font-size:18px;">
                            <b><?= number_format($grand_total) ?> đ</b>
                        </td>
                    </tr>

                </table>
            </div>

        </div>
    </div>
</section>

<?php include "footermain.php"; ?>