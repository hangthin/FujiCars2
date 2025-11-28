<?php
session_start();

function is_whitespace($str) {
    return trim($str) === '';
}

if (isset($_POST['btn_signup'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $pass = $_POST['pass'];
    $repass = $_POST['repass'];
    $email = $_POST['email'];

    $sql1 = "SELECT * FROM khachhang WHERE phone = '$phone'";
    $result1 = mysqli_query($conn, $sql1);
    $num1 = mysqli_num_rows($result1);
 
    $sql2 = "SELECT * FROM khachhang WHERE email = '$email'";
    $result2 = mysqli_query($conn, $sql2);
    $num2 = mysqli_num_rows($result2);

    if (!is_whitespace($name)) {
        if ($num1 > 0) {
            $err1 = "Số điện thoại đã tồn tại";
        } else if ($num2 > 0) {
            $err2 = "Email đã tồn tại";
        } else if (strlen($pass) < 8) {
            $err3 = "Mật khẩu ít nhất 8 kí tự";
        } else {
            if ($pass != $repass) {
                $err4 = "Mật khẩu không trùng khớp";
            } else {
                $now = getdate();
                $dayupdate = $now['year'] . "-" . $now['mon'] . "-" . $now['mday'];

                $sql = "INSERT INTO khachhang (HoTen, phone, email, MatKhau, NgayCapNhat, TrangThai) 
                        VALUES ('$name', '$phone', '$email', '$pass', '$dayupdate', '1')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    // Lấy ID khách hàng vừa tạo
                    $sql2 = mysqli_query($conn, "SELECT MAX(MaKH) as maxid FROM khachhang");
                    $id = mysqli_fetch_array($sql2);

                    $_SESSION['MaKH'] = $id['maxid'];
                    $_SESSION['Count_Product'] = 0;
                    $_SESSION['HoTen'] = $name;
                    $_SESSION['Phone'] = $phone;
                    $_SESSION['Quyen'] = 0;

                    echo "<script>toast({ title: 'Success', message: 'Đăng ký thành công!', type: 'success', duration: 3000 });</script>";
                    header("refresh:2;url=index.php");
                    exit();
                } else {
                    echo "Lỗi đăng ký: " . mysqli_error($conn);
                }
            }
        }
    } else {
        $err5 = "Vui lòng nhập họ tên";
    }
}
?>
