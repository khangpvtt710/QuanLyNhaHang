<?php
session_start();
include "header.php";
require_once "database.php";

$db = new Database();
?>

<style>
/* CSS GIỮ NGUYÊN */
.login-container {
    max-width: 400px;
    margin: 60px auto;
    padding: 30px;
    border-radius: 8px;
    border: 1px solid #ccc;
    background: #fff;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
}

.login-container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.login-container input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #999;
}

.login-container button {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border: none;
    border-radius: 5px;
    background: #ff8400ff;
    color: white;
    cursor: pointer;
}

.login-container button:hover {
    opacity: 0.9;
}

.error {
    color: red;
    text-align: center;
    margin-bottom: 10px;
}
</style>

<div class="login-container">
    <h2>Đăng nhập</h2>

    <?php
if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "" || $password == "") {
        echo "<div class='error'>Vui lòng nhập đầy đủ thông tin</div>";
    } else {

        // Escape chống SQL Injection
        $username = $db->escape($username);

        $sql = "SELECT * FROM tbl_user WHERE username = '$username' LIMIT 1";
        $result = $db->select($sql);

        if ($result) {

            $user = $result->fetch_assoc();

            // ✅ GÁN HASH Ở ĐÂY (QUAN TRỌNG)
            $hash = $user['password'];

            // So sánh mật khẩu
            if (password_verify($password, $hash)) {

                // ✅ LƯU SESSION
                $_SESSION['user_login'] = $user['username'];

                if ($user['username'] === "admin") {
                    echo "<script>
                        alert('Đăng nhập Admin thành công!');
                        window.location='cartegoryadd.php';
                    </script>";
                    exit;
                }

                echo "<script>
                    alert('Đăng nhập thành công!');
                    window.location='index.php';
                </script>";
                exit;

            } else {
                echo "<div class='error'>Sai mật khẩu!</div>";
            }

        } else {
            echo "<div class='error'>Tài khoản không tồn tại!</div>";
        }
    }
}
?>

    <form method="POST">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit" name="login">Đăng nhập</button>
        <button type="button" onclick="window.location='register.php'">Đăng ký</button>
    </form>
</div>