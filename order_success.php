<?php
include "headermain.php";

// LẤY GIỎ HÀNG
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// LẤY ĐỊA CHỈ GIAO HÀNG
$shipping = isset($_SESSION['shipping']) ? $_SESSION['shipping'] : [];

// LẤY PHƯƠNG THỨC THANH TOÁN
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : "COD";

// TÍNH TIỀN
$total = 0;
foreach($cart as $item){
    $total += $item['price'] * $item['quantity'];
}
$vat = $total * 0.1;
$grand_total = $total + $vat;

// TẠO MÃ ĐƠN HÀNG
$order_code = "HD" . rand(100000,999999);
?>

<style>
.invoice-box {
    max-width: 900px;
    margin: 20px auto;
    padding: 25px;
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0, 0, 0, .15);
    font-size: 16px;
    color: #333;
    background: white;
}

.invoice-box table {
    width: 100%;
    line-height: inherit;
    text-align: left;
}

.invoice-box table td {
    padding: 5px;
    vertical-align: top;
}

.invoice-title {
    text-align: center;
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 10px;
}

.invoice-print {
    text-align: center;
    margin-top: 15px;
}

button {
    padding: 10px 20px;
    background: #ff7a00;
    border: none;
    color: white;
    border-radius: 6px;
    cursor: pointer;
}
</style>

<div class="invoice-box">

    <div class="invoice-title">HÓA ĐƠN THANH TOÁN</div>

    <p><b>Mã hóa đơn:</b> <?= $order_code ?></p>
    <p><b>Ngày lập:</b> <?= date("d/m/Y H:i") ?></p>

    <hr>

    <h3>📦 Thông tin giao hàng</h3>
    <?php if($shipping): ?>
    <p><b>Họ tên:</b> <?= $shipping['fullname'] ?></p>
    <p><b>SĐT:</b> <?= $shipping['phone'] ?></p>
    <p><b>Địa chỉ:</b>
        <?= $shipping['address'] ?>,
        <?= $shipping['district'] ?>,
        <?= $shipping['city'] ?>
    </p>
    <?php else: ?>
    <p style="color:red;">Chưa có thông tin giao hàng</p>
    <?php endif; ?>

    <hr>

    <h3>🛒 Chi tiết sản phẩm</h3>

    <table border="1" cellspacing="0">
        <tr>
            <th width="45%">Tên sản phẩm</th>
            <th width="15%">SL</th>
            <th width="20%">Giá</th>
            <th width="20%">Thành tiền</th>
        </tr>

        <?php if($cart): foreach($cart as $item): ?>
        <tr>
            <td><?= $item['name'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= number_format($item['price']) ?> đ</td>
            <td><?= number_format($item['price']*$item['quantity']) ?> đ</td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="4" style="text-align:center;">Không có sản phẩm</td>
        </tr>
        <?php endif; ?>

        <tr>
            <td colspan="3" style="text-align:right;"><b>Tạm tính</b></td>
            <td><b><?= number_format($total) ?> đ</b></td>
        </tr>

        <tr>
            <td colspan="3" style="text-align:right;"><b>VAT 10%</b></td>
            <td><b><?= number_format($vat) ?> đ</b></td>
        </tr>

        <tr>
            <td colspan="3" style="text-align:right;"><b>Tổng thanh toán</b></td>
            <td style="color:red;font-size:18px;">
                <b><?= number_format($grand_total) ?> đ</b>
            </td>
        </tr>
    </table>

    <hr>

    <p><b>Phương thức thanh toán:</b>
        <?php
            switch($payment_method){
                case "COD": echo "Thanh toán khi nhận hàng (COD)"; break;
                case "ATM": echo "Thẻ ATM / Internet Banking"; break;
                case "MOMO": echo "Ví MoMo"; break;
                case "VISA": echo "Visa / Mastercard"; break;
            }
        ?>
    </p>

    <div class="invoice-print">
        <button onclick="window.print()">🖨 In hóa đơn</button>
        <a href="index.php"><button>⬅ Về trang chủ</button></a>
    </div>

</div>

<?php include "footermain.php"; ?>