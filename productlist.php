<?php
include "header.php";
include "slider.php";
include "class/product-class.php";
?>

<?php
$product = new productclass();
$show_product = $product->show_product();
?>

<div class="admin-content-right">
    <div class="admin-content-right-cartegory-list">
        <h1>Danh sách sản phẩm</h1>

        <table>
            <tr>
                <th>Stt</th>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Thương hiệu</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Tùy biến</th>
            </tr>

            <?php
            if ($show_product) {
                $i = 0;
                while ($result = $show_product->fetch_assoc()) {
                    $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $result['product_id'] ?></td>
                <td><?php echo $result['product_name'] ?></td>
                <td><?php echo $result['cartegory_name'] ?></td>
                <td><?php echo $result['brand_name'] ?></td>
                <td><?php echo number_format($result['product_price_new']) ?> đ</td>

                <td>
                    <img src="uploads/<?php echo $result['product_img'] ?>" width="70">
                </td>

                <td>
                    <a href="productedit.php?product_id=<?php echo $result['product_id'] ?>">Sửa</a> |
                    <a onclick="return confirm('Bạn có chắc muốn xóa?')"
                        href="productdelete.php?product_id=<?php echo $result['product_id'] ?>">Xóa</a>
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
</div>

</section>
</body>

</html>