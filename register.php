<?php include "header.php"; ?>
<?php 
include "database.php"; 
$db = new Database();
?>
<style>
.register-box {
    width: 360px;
    margin: 80px auto;
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.register-box h2 {
    text-align: center;
    margin-bottom: 20px;
}

.register-box input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.register-box button {
    width: 100%;
    padding: 12px;
    background: #28a745;
    border: none;
    color: #fff;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
}

.register-box .error {
    color: red;
    text-align: center;
}

.register-box .success {
    color: green;
    text-align: center;
}
</style>

<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if ($username == "" || $password == "") {
        $message = "<p class='error'>Vui lòng nhập đầy đủ thông tin.</p>";
    } else {

        // Kiểm tra trùng username
        $query_check = "SELECT * FROM tbl_user WHERE username='$username'";
        $check = $db->select($query_check);

        if ($check) {
            $message = "<p class='error'>Tên đăng nhập đã tồn tại.</p>";
        } else {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $query_insert = "INSERT INTO tbl_user(username, password) 
                             VALUES('$username', '$password_hashed')";

            $insert = $db->insert($query_insert);

            if ($insert) {
                $message = "<p class='success'>Đăng ký thành công! 
                <a href='login.php'>Đăng nhập ngay</a></p>";
            } else {
                $message = "<p class='error'>Đã xảy ra lỗi khi đăng ký.</p>";
            }
        }
    }
}
?>

<div class="register-box">
    <h2>Đăng ký tài khoản</h2>

    <?= $message ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>

        <button type="submit">Đăng ký</button>
    </form>
</div>