<?php
include "headermain.php";
include "class/product-class.php";

$product = new productclass();

// kiểm tra có cartegory_id hoặc brand_id hay không
$breadcrumb = "Tất cả sản phẩm";
$get_products = null;

// lọc theo brand
if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];
    $get_products = $product->get_product_by_brand($brand_id);

    $brand = $product->get_brand_name($brand_id);
    $breadcrumb = $brand ? $brand['brand_name'] : "Thương hiệu";
}

// lọc theo category
elseif (isset($_GET['cartegory_id'])) {
    $cartegory_id = $_GET['cartegory_id'];
    $get_products = $product->get_product_by_cartegory($cartegory_id);

    $category = $product->get_cartegory_name($cartegory_id);
    $breadcrumb = $category ? $category['cartegory_name'] : "Danh mục";
}

// nếu không có gì
else{
    echo "<h3>Không có danh mục hoặc thương hiệu hợp lệ</h3>";
}
?>


<?php
require_once "class/product-class.php";
$product = new productclass();
$cartegories = $product->show_cartegory();
$brands = $product->show_brand();
?>


<style>
.cartegory-right-content {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.cartegory-right-contant-item {
    width: 240px;
    /* chiều rộng sản phẩm */
    height: 330px;
    /* chiều cao sản phẩm */
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background: #fff;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
}

.cartegory-right-contant-item img {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

.cartegory-right-contant-item h1 {
    font-size: 16px;
    margin: 10px 0 5px 0;
    line-height: 1.2;
}

.cartegory-right-contant-item p {
    font-size: 15px;
    color: #e60000;
    margin-top: auto;
}
</style>

<!-- -----------------------------------cartegory---------------------------------------- -->
<section class="cartegory brick">
    <div class="container">
        <div class="container-top row">
            <p><b> Trang chủ </b></p> <span>&#10230;</span>
            <p><b> <?= $breadcrumb ?> </b></p>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <!-- ----------- MENU BÊN TRÁI ---------------- -->
            <div class="cartegory-left">
                <ul>
                    <?php 
        if ($cartegories) {
            while ($cat = $cartegories->fetch_assoc()) { 
        ?>
                    <li>
                        <a class="cartegory-left-li">
                            <?= $cat['cartegory_name'] ?>
                        </a>

                        <!-- Lấy brand theo cartegory -->
                        <ul>
                            <?php
                    $catId = $cat['cartegory_id'];
                    $brandsByCat = $product->show_brand_ajax($catId);

                    if ($brandsByCat) {
                        while ($brand = $brandsByCat->fetch_assoc()) {
                    ?>
                            <li>
                                <a href="cartegorymain.php?brand_id=<?= $brand['brand_id'] ?>">
                                    <?= $brand['brand_name'] ?>
                                </a>
                            </li>
                            <?php 
                        }} else { 
                    ?>
                            <!-- Nếu danh mục không có thương hiệu thì dùng chính category -->
                            <li>
                                <a href="cartegorymain.php?cartegory_id=<?= $catId ?>">
                                    <?= $cat['cartegory_name'] ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php 
            }
        }
        ?>
                </ul>
            </div>


            <!-- ----------- NỘI DUNG BÊN PHẢI ---------------- -->
            <div class="cartegory-right row">

                <div class="cartegogy-right-top-item">

                </div>

                <div class="cartegory-right-content">

                    <?php
if ($get_products) {

    while($row = $get_products->fetch_assoc()){
?>

                    <div class="cartegory-right-contant-item">
                        <a href="productmain.php?product_id=<?= $row['product_id'] ?>">
                            <img src="uploads/<?= $row['product_img'] ?>" alt="">
                            <h1><?= $row['product_name'] ?></h1>
                            <p><?= number_format($row['product_price_new']) ?><sup>đ</sup></p>
                        </a>
                    </div>

                    <?php
    }

} else {
    echo "<p>Không tìm thấy sản phẩm nào!</p>";
}
?>

                </div>


            </div>

        </div>
    </div>
</section>

<?php include "footermain.php"; ?>