<?php
require_once "database.php";
?>

<?php
class productclass {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function show_cartegory(){
        $query = "SELECT * FROM tbl_cartegory ORDER BY cartegory_id DESC";
        return $this->db->select($query);
    }

    public function show_brand(){
        $query = "SELECT tbl_brand.*, tbl_cartegory.cartegory_name 
                  FROM tbl_brand 
                  INNER JOIN tbl_cartegory 
                  ON tbl_brand.cartegory_id = tbl_cartegory.cartegory_id
                  ORDER BY tbl_brand.brand_id DESC";
        return $this->db->select($query);
    }

    // ================================
    //     INSERT PRODUCT (NO IMG DESC)
    // ================================
    public function insert_product($data, $files){
        $product_name = $this->db->link->real_escape_string($data['product_name']);
        $cartegory_id = $this->db->link->real_escape_string($data['cartegory_id']);
        $brand_id = $this->db->link->real_escape_string($data['brand_id']);
        $product_price = $this->db->link->real_escape_string($data['product_price']);
        $product_sale = $this->db->link->real_escape_string($data['product_sale']);
        $product_desc = $this->db->link->real_escape_string($data['product_desc']);

        // ---------- ẢNH ĐẠI DIỆN ----------
        $product_img_name = $files['product_img']['name'];
        $product_img_tmp = $files['product_img']['tmp_name'];
        $product_img_error = $files['product_img']['error'];
        $product_img_size = $files['product_img']['size'];

        $base_upload_dir = dirname(__DIR__) . "/uploads/";
        $uploaded_img_path_abs = $base_upload_dir . basename($product_img_name);

        if ($product_img_error !== UPLOAD_ERR_OK) {
            return "Lỗi upload ảnh đại diện: " . $product_img_error;
        }

        $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
        $file_extension = strtolower(pathinfo($product_img_name, PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            return "Chỉ cho phép file JPG, JPEG, PNG, GIF.";
        }

        if ($product_img_size > 10000000) {
            return "Kích thước ảnh đại diện không được lớn hơn 10MB.";
        }

        if (!is_dir($base_upload_dir)) {
            mkdir($base_upload_dir, 0777, true);
        }

        if (!move_uploaded_file($product_img_tmp, $uploaded_img_path_abs)) {
            return "Không thể lưu ảnh đại diện.";
        }

        if ($product_sale < 0) return "Giảm giá không được nhỏ hơn 0.";
        if ($product_price < 0) return "Giá sản phẩm không được nhỏ hơn 0.";

        // ---------- INSERT SẢN PHẨM ----------
        $query_product = "INSERT INTO tbl_product(
            product_name,
            cartegory_id,
            brand_id,
            product_price,
            product_price_new,
            product_desc,
            product_img
        ) VALUES(
            '$product_name',
            '$cartegory_id',
            '$brand_id',
            '$product_price',
            '$product_sale',
            '$product_desc',
            '$product_img_name'
        )";

        $result = $this->db->insert($query_product);

        if ($result) {
            return "Thêm sản phẩm thành công!";
        } else {
            return "Thêm sản phẩm thất bại!";
        }
    }

    public function show_brand_ajax($cartegory_id){
        $id = $this->db->link->real_escape_string($cartegory_id);
        $query = "SELECT * FROM tbl_brand WHERE cartegory_id = '$id' ORDER BY brand_id DESC";
        return $this->db->select($query);
    }

    public function show_products_by_cartegory($cartegory_id){
        $id = $this->db->link->real_escape_string($cartegory_id);
        $query = "SELECT * FROM tbl_product WHERE cartegory_id = '$id' ORDER BY product_id DESC";
        return $this->db->select($query);
    }

    public function get_cartegory($cartegory_id){
        $id = $this->db->link->real_escape_string($cartegory_id);
        $query = "SELECT * FROM tbl_cartegory WHERE cartegory_id = '$id'";
        return $this->db->select($query);
    }

    public function update_cartegory($cartegory_name, $cartegory_id){
        $name = $this->db->link->real_escape_string($cartegory_name);
        $id = $this->db->link->real_escape_string($cartegory_id);
        $query = "UPDATE tbl_cartegory SET cartegory_name = '$name' WHERE cartegory_id = '$id'";
        return $this->db->update($query);
    }

    public function get_cartegory_name($cartegory_id) {
    $query = "SELECT cartegory_name FROM tbl_cartegory WHERE cartegory_id = '$cartegory_id'";
    $result = $this->db->select($query);

    if ($result) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

    public function delete_cartegory($cartegory_id){
        $id = $this->db->link->real_escape_string($cartegory_id);
        $query = "DELETE FROM tbl_cartegory WHERE cartegory_id = '$id'";
        return $this->db->delete($query);
    }

    public function get_brand_name($brand_id) {
    $query = "SELECT brand_name FROM tbl_brand WHERE brand_id = '$brand_id' LIMIT 1";
    $result = $this->db->select($query);

    if ($result) {
        return $result->fetch_assoc();
    }
    return null;
}

    public function get_product_by_brand($brand_id){
        $query = "SELECT * FROM tbl_product WHERE brand_id = '$brand_id'";
        return $this->db->select($query);
    }
}
?>