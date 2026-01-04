<?php
include "header.php";
include "slider.php";
include "class/brand-class.php";
include "class/cartegory-class.php";
?>

<?php
$brand = new brandclass;
$cartegory = new cartegoryclass;

// LẤY DANH MỤC
$show_cartegory = $cartegory->show_cartegory();

// THÊM BRAND
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartegory_id = $_POST['cartegory_id'] ?? '';
    $brand_name   = $_POST['brand_name'] ?? '';

    if (!empty($cartegory_id) && !empty($brand_name)) {
        $insert_brand = $brand->insert_brand($cartegory_id, $brand_name);
    } else {
        $insert_brand = "<span style='color:red'>Vui lòng nhập đầy đủ thông tin</span>";
    }
}
?>

<style>
select {
    height: 30px;
    width: 200px;
}
</style>

<div class="admin-content-right">
    <div class="admin-content-right-cartegory-add">
        <h1>Thêm Loại Sản Phẩm</h1>

        <?php
        if (isset($insert_brand)) {
            echo $insert_brand;
        }
        ?>

        <form action="" method="POST">
            <select name="cartegory_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php
                if ($show_cartegory) {
                    while ($row = $show_cartegory->fetch_assoc()) {
                ?>
                <option value="<?= $row['cartegory_id'] ?>">
                    <?= $row['cartegory_name'] ?>
                </option>
                <?php
                    }
                }
                ?>
            </select>
            <br><br>

            <input required name="brand_name" type="text" placeholder="Nhập tên loại sản phẩm">
            <br><br>

            <button type="submit">Thêm</button>
        </form>
    </div>
</div>

</section>
</body>

</html>