<style>
.footer {
    background: #111;
    height: 220px;
    color: #eee;
    margin-top: 40px;
    font-family: Arial, Helvetica, sans-serif;
}

/* đảm bảo không chồng chữ */
.footer * {
    line-height: 1.6;
    box-sizing: border-box;
}

/* ---- top ---- */
.footer-top {
    display: flex;
    flex-wrap: wrap;
    /* QUAN TRỌNG – tự xuống dòng */
    gap: 30px;
    /* tạo khoảng cách giữa cột */
    padding: 30px 60px 10px 60px;
}

/* logo */
.footer-logo img {
    width: 250px;
    height: 200px;
}

/* ---- columns ---- */
.footer-col {
    flex: 1;
    /* chia đều cột */
    min-width: 230px;
    /* không nhỏ hơn */
}

/* tiêu đề */
.footer-col h3 {
    color: #ff7a00;
    margin-bottom: 10px;
}

/* danh sách link */
.footer-col ul {
    padding: 0;
    list-style: none;
    margin: 0;
}

.footer-col ul li {
    margin: 6px 0;
}

.footer-col ul li a {
    color: #ccc;
    text-decoration: none;
    display: inline-block;
}

.footer-col ul li a:hover {
    color: #ff7a00;
}

/* ---- newsletter ---- */
.footer-subscribe input {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: none;
    margin-top: 5px;
}

.footer-subscribe button {
    margin-top: 8px;
    padding: 9px 18px;
    border-radius: 6px;
    border: none;
    background: #ff7a00;
    color: #fff;
    cursor: pointer;
}

.footer-subscribe button:hover {
    opacity: .9;
}

/* ---- social ---- */
.social-icons a {
    margin-right: 10px;
    color: #fff;
    font-size: 22px;
}

.social-icons a:hover {
    color: #ff7a00;
}

/* ---- bottom ---- */
.footer-bottom {
    background: #000;
    text-align: center;
    padding: 12px 5px;
    color: #aaa;
    font-size: 14px;
}
</style>

<footer class="footer">

    <div class="footer-top">

        <!-- logo -->
        <div class="footer-logo">
            <img src="img/logofood.png">
        </div>

        <!-- thông tin -->
        <div class="footer-col">
            <h3>Thông tin</h3>
            <ul>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Tuyển dụng</a></li>
                <li><a href="#">Điều khoản dịch vụ</a></li>
                <li><a href="#">Chính sách bảo mật</a></li>
            </ul>
        </div>

        <!-- hỗ trợ -->
        <div class="footer-col">
            <h3>Hỗ trợ khách hàng</h3>
            <ul>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Hướng dẫn mua hàng</a></li>
                <li><a href="#">Chính sách đổi trả</a></li>
                <li><a href="#">Chăm sóc khách hàng</a></li>
            </ul>
        </div>

        <!-- nhận tin -->
        <div class="footer-col footer-subscribe">
            <h3>Nhận ưu đãi & khuyến mãi</h3>
            <input type="text" placeholder="Nhập email của bạn...">
            <button>Đăng ký</button>

            <p style="margin-top:10px;">Kết nối với chúng tôi</p>

            <div class="social-icons">
                <a href="#" class="fa fa-facebook"></a>
                <a href="#" class="fa fa-instagram"></a>
                <a href="#" class="fa fa-github"></a>
            </div>
        </div>

    </div>



</footer>