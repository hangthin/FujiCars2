<?php
session_start();

include("../../Controller/config/config.php");

// Hiển thị lỗi PHP để debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

$email = $_SESSION['email_check'] ?? '';
$phone = $_SESSION['phone_check'] ?? '';
$taikhoan = $_SESSION['taikhoan'] ?? '';
$NgayCapNhat = date("Y-m-d H:i:s", time());

if (isset($_POST['btn_change'])) {
    $psw = $_POST['psw'] ?? '';
    $psw_r = $_POST['psw_r'] ?? '';

    // Debug giá trị nhận từ form
    echo "<pre>DEBUG FORM INPUT:\n";
    echo "Tài khoản: $taikhoan\n";
    echo "Email: $email\n";
    echo "Phone: $phone\n";
    echo "Mật khẩu mới: $psw\n";
    echo "Nhập lại mật khẩu: $psw_r\n";
    echo "</pre>";

    if (strlen($psw) < 3) {
    $err1 = "Mật khẩu ít nhất 3 kí tự";
    echo "<p style='color:red;'>$err1</p>";
} elseif ($psw !== $psw_r) {
        $err2 = "Mật khẩu không trùng khớp";
        echo "<p style='color:red;'>$err2</p>";
    } else {
        // Hash mật khẩu trước khi lưu
        $psw_hash = password_hash($psw, PASSWORD_DEFAULT);
        echo "<p>DEBUG: Mật khẩu đã hash: $psw_hash</p>";

        $update_sql = "UPDATE nguoidung 
                       SET MatKhau = '$psw_hash', 
                           email = '$email', 
                           NgayCapNhat = '$NgayCapNhat' 
                       WHERE TenTK = '$taikhoan'";

        echo "<pre>DEBUG SQL UPDATE:\n$update_sql\n</pre>";

        if(mysqli_query($conn, $update_sql)) {
            echo "<p style='color:green;'>Update thành công!</p>";

            // Lấy dữ liệu user mới cập nhật
            $user_sql = "SELECT * FROM nguoidung WHERE TenTK='$taikhoan'";
            echo "<pre>DEBUG SQL SELECT:\n$user_sql\n</pre>";

            $res = mysqli_query($conn, $user_sql);
            if ($res) {
                $user = mysqli_fetch_assoc($res);
                echo "<pre>DEBUG USER DATA:\n";
                print_r($user);
                echo "</pre>";

                // Tạo session đăng nhập
                $_SESSION['ID'] = $user['ID'];
                $_SESSION['TenTK'] = $user['TenTK'];
                $_SESSION['Quyen'] = $user['Quyen'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['HinhAnh'] = $user['HinhAnh'];

                // Xóa session tạm
                unset($_SESSION['email_check']);
                unset($_SESSION['phone_check']);
                unset($_SESSION['otp']);
                unset($_SESSION['taikhoan']);

                echo "<script>alert('Thay đổi mật khẩu thành công!'); window.location='../../index.php';</script>";
                exit();
            } else {
                $err3 = "Lỗi SELECT: " . mysqli_error($conn);
                echo "<p style='color:red;'>$err3</p>";
            }

            mysqli_close($conn);

        } else {
            $err3 = "Lỗi UPDATE: " . mysqli_error($conn);
            echo "<p style='color:red;'>$err3</p>";
        }
    }
}
?>



<div class="main-wrapper">
    <div class="container">
        <div class="form-box">
            <h3 class="form-title">THAY ĐỔI MẬT KHẨU</h3>

            <form action="" method="post" class="login-form" >
                <span class="form-message">
                    <?php if (isset($err1)) echo $err1; ?>
                    <?php if (isset($err2)) echo $err2; ?>
                </span>

                <div class="form-group">
                    <label>Tài khoản đăng nhập</label>
                    <input type="text" value="<?php echo $taikhoan; ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" name="psw" value="<?php if (isset($psw)) echo $psw; ?>" placeholder="Nhập mật khẩu mới" required>
                </div>

                <div class="form-group">
                    <label>Nhập lại mật khẩu</label>
                    <input type="password" name="psw_r" value="<?php if (isset($psw_r)) echo $psw_r; ?>" placeholder="Nhập lại mật khẩu mới" required>
                </div>

                <button type="submit" name="btn_change" class="btn-submit">XÁC NHẬN THAY ĐỔI</button>
                <a href="../../index.php" class="btn-cancel">QUAY LẠI</a>
            </form>
        </div>
    </div>
</div>


<style>
:root {
    --red: #d32f2f;
    --dark: #1a1a1a;
    --gray: #2c2c2c;
    --light: #ffffff;
    --shadow: rgba(255, 0, 0, 0.25);
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, var(--dark), var(--gray));
    margin: 0;
    padding: 0;
    height: 100vh;
}

.main-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.container {
    background: var(--light);
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 8px 25px var(--shadow);
    width: 100%;
    max-width: 480px;
    border-top: 5px solid var(--red);
}

.form-box {
    text-align: center;
}

.form-title {
    font-size: 24px;
    color: var(--red);
    margin-bottom: 20px;
    font-weight: 700;
    letter-spacing: 1px;
}

.form-message {
    color: var(--red);
    font-size: 14px;
    margin-bottom: 15px;
    display: block;
}

.form-group {
    text-align: left;
    margin-bottom: 20px;
}

.form-group label {
    font-weight: 600;
    display: block;
    margin-bottom: 6px;
    color: #111;
}

.form-group input {
    width: 100%;
    padding: 10px;
    font-size: 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background-color: #fafafa;
    transition: border 0.3s, box-shadow 0.3s;
}

.form-group input:focus {
    border-color: var(--red);
    outline: none;
    box-shadow: 0 0 5px rgba(211, 47, 47, 0.3);
}

.btn-submit, .btn-cancel {
    display: inline-block;
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border: none;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s ease-in-out;
    font-weight: 600;
}

/* Nút xác nhận */
.btn-submit {
    background-color: var(--red);
    color: var(--light);
}

.btn-submit:hover {
    background-color: #b71c1c;
}

/* Nút quay lại */
.btn-cancel {
    background-color: var(--light);
    color: var(--red);
    border: 2px solid var(--red);
    margin-top: 10px;
}

.btn-cancel:hover {
    background-color: var(--red);
    color: var(--light);
}

/* Hiệu ứng hover container */
.container:hover {
    transform: translateY(-3px);
    transition: all 0.3s ease-in-out;
}

</style>
