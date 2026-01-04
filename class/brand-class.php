<?php
require_once __DIR__ . "/../database.php";


class brandclass {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // ================== THÊM THƯƠNG HIỆU ==================
    public function insert_brand($cartegory_id, $brand_name) {

    if (empty($cartegory_id) || empty($brand_name)) {
        return "Dữ liệu không hợp lệ";
    }

    $cartegory_id = (int)$cartegory_id;
    $brand_name = trim($brand_name);

    // Kiểm tra danh mục có tồn tại không
    $check = $this->db->select(
        "SELECT cartegory_id FROM tbl_cartegory WHERE cartegory_id = '$cartegory_id'"
    );

    if (!$check) {
        return "Danh mục không tồn tại!";
    }

    $query = "
        INSERT INTO tbl_brand (cartegory_id, brand_name)
        VALUES ('$cartegory_id', '$brand_name')
    ";

    return $this->db->insert($query);
}


    // ================== HIỂN THỊ DANH MỤC ==================
    public function show_cartegory() {
        $query = "SELECT * FROM tbl_cartegory ORDER BY cartegory_id DESC";
        return $this->db->select($query);
    }

    // ================== HIỂN THỊ THƯƠNG HIỆU ==================
    public function show_brand() {
        $query = "
            SELECT tbl_brand.*, tbl_cartegory.cartegory_name
            FROM tbl_brand
            INNER JOIN tbl_cartegory 
                ON tbl_brand.cartegory_id = tbl_cartegory.cartegory_id
            ORDER BY tbl_brand.brand_id DESC
        ";
        return $this->db->select($query);
    }

    // ================== LẤY 1 THƯƠNG HIỆU ==================
    public function get_brand($brand_id) {
        $brand_id = (int)$brand_id;
        $query = "SELECT * FROM tbl_brand WHERE brand_id = '$brand_id'";
        return $this->db->select($query);
    }

    // ================== CẬP NHẬT THƯƠNG HIỆU ==================
    public function update_brand($cartegory_id, $brand_name, $brand_id) {

        $cartegory_id = (int)$cartegory_id;
        $brand_id = (int)$brand_id;
        $brand_name = trim($brand_name);

        $query = "
            UPDATE tbl_brand
            SET cartegory_id = '$cartegory_id',
                brand_name = '$brand_name'
            WHERE brand_id = '$brand_id'
        ";

        return $this->db->update($query);
    }

    // ================== XÓA THƯƠNG HIỆU ==================
    public function delete_brand($brand_id) {
        $brand_id = (int)$brand_id;
        $query = "DELETE FROM tbl_brand WHERE brand_id = '$brand_id'";
        return $this->db->delete($query);
    }

    // ================== LẤY BRAND THEO DANH MỤC ==================
    public function get_brands_by_cartegory($cartegory_id) {
        $cartegory_id = (int)$cartegory_id;
        $query = "
            SELECT * FROM tbl_brand
            WHERE cartegory_id = '$cartegory_id'
            ORDER BY brand_id DESC
        ";
        return $this->db->select($query);
    }

    public function get_product_by_id($product_id){
    $id = $this->db->getLink()->real_escape_string($product_id);

    $query = "SELECT 
                tbl_product.*, 
                tbl_cartegory.cartegory_name,
                tbl_brand.brand_name
              FROM tbl_product
              INNER JOIN tbl_cartegory ON tbl_product.cartegory_id = tbl_cartegory.cartegory_id
              INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
              WHERE tbl_product.product_id = '$id'
              LIMIT 1";

    return $this->db->select($query);
}

    
}