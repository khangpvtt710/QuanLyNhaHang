<?php
include "headermain.php";

require_once __DIR__ . "/class/product-class.php";
require_once __DIR__ . "/database.php";

$product = new productclass();
$db = new Database();

//  Kiểm tra có product_id không
if (!isset($_GET['product_id']) || $_GET['product_id'] == '') {
    echo "<h2>Sản phẩm không tồn tại</h2>";
    exit;
}

//  Lấy product_id
$product_id = (int)$_GET['product_id'];

//  Lấy sản phẩm theo ID
$result = $product->get_product_by_id($product_id);

if (!$result || $result->num_rows == 0) {
    echo "<h2>Không tìm thấy sản phẩm</h2>";
    exit;
}

// Lấy dữ liệu
$row = $result->fetch_assoc();
?>

<!-----------------------------------product---------------------------------------->
<section class="product brick">
    <div class="container">
        <div class="product-top row">
            <p><b>Trang chủ</b></p>
            <span>&#10230;</span>
            <p><b><?= $row['product_name'] ?></b></p>
        </div>
    </div>

    <div class="product-content row">
        <div class="product-content-left row">
            <div class="product-content-left-big-img">
                <img src="uploads/<?= $row['product_img'] ?>">
            </div>
        </div>

        <div class="product-content-right">
            <h1><?= $row['product_name'] ?></h1>

            <div class="product-content-right-product-price">
                <p><?= number_format($row['product_price_new']) ?> đ</p>

                <?php if ($row['product_price'] > 0): ?>
                <del><?= number_format($row['product_price']) ?> đ</del>
                <?php endif; ?>
            </div>

            <div class="quantity">
                <p><b>Số lượng</b></p>
                <input type="number" min="1" value="1">
            </div>

            <form method="POST" action="cartmain.php">
                <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                <input type="hidden" name="product_name" value="<?= $row['product_name'] ?>">
                <input type="hidden" name="product_price" value="<?= $row['product_price_new'] ?>">
                <input type="hidden" name="product_img" value="<?= $row['product_img'] ?>">

                <label>Số lượng:</label>
                <input type="number" name="quantity" value="1" min="1">

                <button type="submit" name="add_to_cart">
                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                </button>
            </form>


            <button>
                <i class="fa fa-shopping-cart"></i>
                <a href="cartmain.php?product_id=<?= $row['product_id'] ?>">
                    Mua hàng
                </a>

            </button>

            <div class="product-content-right-botton-content-chitiet">
                <?= nl2br($row['product_desc']) ?>
            </div>
        </div>
    </div>
</section>


<section class="product-related container">
    <div class="product-related-title">
        <p>Sản Phẩm Liên Quan</p>
    </div>

    <div class="product-content row">
        <?php
        $related_sql = "
        SELECT * FROM tbl_product 
        WHERE cartegory_id = '{$product['cartegory_id']}'
        AND product_id != '$product_id'
        LIMIT 5
        ";
        $related = $db->select($related_sql);

        if ($related):
            while ($row = $related->fetch_assoc()):
        ?>
        <div class="product-related-item">
            <a href="product.php?id=<?= $row['product_id'] ?>">
                <img src="uploads/<?= $row['product_img'] ?>" alt="">
                <h1><?= $row['product_name'] ?></h1>
                <p><?= number_format($row['product_price_new']) ?> <sup>đ</sup></p>
            </a>
        </div>
        <?php
            endwhile;
        endif;
        ?>
    </div>
</section>






<!-----------------------------------footer---------------------------------------->
<?php
include "footermain.php"
?>
</body>
<script src="js/index.js"></script>
<script src="js/product.js"></script>

</html>