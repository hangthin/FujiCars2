    <?php
    include("Controller/config/config.php");
    session_start();

    // KIỂM TRA ĐĂNG NHẬP
    $isLoggedIn = false;
    if (isset($_SESSION['TenTK'])) {
        $TenTK = $_SESSION['TenTK'];
        $stmtUser = $conn->prepare("SELECT * FROM nguoidung WHERE TenTK = ?");
        $stmtUser->bind_param("s", $TenTK);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();
        if ($resultUser->num_rows > 0) {
            $isLoggedIn = true;
            $user = $resultUser->fetch_assoc();
        }
        $stmtUser->close();
    }

    // LẤY THÔNG TIN SẢN PHẨM
    $product = null;
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM sanpham WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
    }

    // TÍNH GIẢM GIÁ
    $discountPercent = 0;
    if ($product) {
        switch ($product['ID']) {
            case 1:
            case 5:
            case 12:
            case 16:
                $discountPercent = 10;
                break;
            case 3:
            case 14:
                $discountPercent = 15;
                break;
        }
        $giaGoc = $product['Gia'];
        $giaGiam = $giaGoc;
        if ($discountPercent > 0) {
            $giaGiam = $giaGoc - ($giaGoc * $discountPercent / 100);
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $product ? htmlspecialchars($product['TenSP']) : 'Chi Tiết Sản Phẩm'; ?></title>
        <link rel="stylesheet" href="View/css/styleCss.css">
        <style>
    /* ========================= */
    /*   CSS HOÀN TOÀN ĐỔI TÊN   */
    /* ========================= */

    .ux-shell-block {
        width: 100%;
        max-width: 1200px;
        margin: 35px auto;
        border: 1px solid #ececec;
        border-radius: 9px;
        overflow: hidden;
        background: #ffffff;
    }

    .ux-header-zone {
        padding: 22px;
        font-size: 22px;
        font-weight: 700;
        background: #fff;
    }

    .ux-grid-table {
        width: 100%;
        border-collapse: collapse;
    }

    .ux-grid-table th,
    .ux-grid-table td {
        padding: 18px 22px;
        text-align:center;
        border-bottom: 1px solid #eeeeee;
        font-size: 15px;
    }

    .ux-row-label {
        background: #fafafa;
        text-align:center;
        font-weight: 700;
        width: 260px;
    }

    .ux-col-title {
        text-align: center;
        font-weight: 700;
        background: #ffffff !important;
        border-bottom: 2px solid #dcdcdc;
        font-size: 17px;
    }

    .ux-top-header th {
        background: #ffffff !important;
        border-bottom: 2px solid #ddd;
    }

    </style>
    </head>
    <body>
    <div class="fx-body fx-root">
        <div class="fx-main">
            <?php if ($product): ?>
            <div class="fx-car-detail">
                <div class="fx-car-left">
                    <img src="View/img/SP/<?php echo htmlspecialchars($product['HinhAnh']); ?>" alt="<?php echo htmlspecialchars($product['TenSP']); ?>">
                </div>
                <div class="fx-car-right">
                    <h1 class="fx-car-name"><?php echo htmlspecialchars($product['TenSP']); ?></h1>
                    <p class="fx-car-slogan"><?php echo htmlspecialchars($product['LoaiSP']); ?></p>
                    <div class="fx-car-specs">
                        <div class="fx-spec-item"><span class="fx-label">Số lượng còn</span><span class="fx-value"><?php echo htmlspecialchars($product['SoLuong']); ?></span></div>
                        <div class="fx-spec-item"><span class="fx-label">Nhiên liệu</span><span class="fx-value"><?php echo htmlspecialchars($product['NhienLieu']); ?></span></div>
                        <div class="fx-spec-item"><span class="fx-label">Xuất xứ</span><span class="fx-value"><?php echo htmlspecialchars($product['XuatXu']); ?></span></div>
                        <div class="fx-spec-item fx-price"><span class="fx-label">Giá bán</span><span class="fx-value"><?php echo number_format($giaGiam, 0, ',', '.'); ?> VNĐ</span></div>
                    </div>
                    <div class="fx-action-buttons">
                        <button type="button" class="fx-buy-now-btn">Mua ngay</button>
                        <button type="button" class="fx-add-to-cart-btn">Thêm vào giỏ hàng</button>
                    </div>
                    <form id="fx-productForm" class="fx-hidden">
                        <input type="hidden" name="MaSP" value="<?php echo $product['ID']; ?>">
                        <input type="hidden" id="fx-quantityInput" name="SoLuong" value="1">
                    </form>
                </div>
            </div>

            <!-- ĐIỂM NỔI BẬT -->
            <section class="fx-features">
                <h3 style="text-align:left; font-size:28px">NHỮNG ĐIỂM NỔI BẬT CỦA FUJICARS <?php echo htmlspecialchars($product['TenSP']); ?></h3>
                <div class="fx-features-grid">
                    <div class="fx-card"><img src="View/img/SP/noibat1.avif"><div class="fx-text"><b>Diện mạo năng động</b><br>Thiết kế thể thao và hiện đại...</div></div>
                    <div class="fx-card"><img src="View/img/SP/noibat2.avif"><div class="fx-text"><b>Hệ thống Digital Light</b><br>Công nghệ chiếu sáng thông minh...</div></div>
                    <div class="fx-card"><img src="View/img/SP/noibat3.webp"><div class="fx-text"><b>Định nghĩa mới của sự tiện nghi</b><br>Nội thất sang trọng và đẳng cấp...</div></div>
                    <div class="fx-card"><img src="View/img/SP/noibat4.webp"><div class="fx-text"><b>Chất an toàn từ Mercedes</b><br>Hệ thống an toàn cao cấp...</div></div>
                    <div class="fx-card"><img src="View/img/SP/noibat5.avif"><div class="fx-text"><b>Khoang ghế rộng rãi</b><br>Không gian thoải mái cho mọi hành khách...</div></div>
                </div>
            </section>
            </br>
            </br>
            <!-- THÔNG SỐ KĨ THUẬT -->
        <?php
        include("Controller/config/config.php");
        // LẤY ID SẢN PHẨM HIỆN TẠI
        $SanPhamID = $product['ID'];
        $sql = "SELECT 
                    ID,
                    SanPhamID,
                    LoaiNhienLieu,
                    CongSuatHP,
                    HopSo,
                    TangToc,
                    TocDoToiDa,
                    TrongLuong,
                    ChoNgoi
                FROM thongsokithuat
                WHERE SanPhamID = $SanPhamID";

        $result = mysqli_query($conn, $sql);

        $versions = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $versions[] = $row;
        }
        ?>
            <div class="ux-shell-block">
        <div class="ux-header-zone" style="margin: 10px 0;margin-top: 40px;">&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;THÔNG SỐ KĨ THUẬT</div>
        <table class="ux-grid-table">
           <tr class="ux-top-header">
            <th></th>
            <?php foreach ($versions as $v): ?>
                <th class="ux-col-title"><?= $product["TenSP"] ?></th>
            <?php endforeach; ?>
        </tr>

            <tr>
                <td class="ux-row-label">Loại nhiên liệu</td>
                <?php foreach ($versions as $v): ?>
                    <td><?= $v["LoaiNhienLieu"] ?></td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td class="ux-row-label">Công suất (HP)</td>
                <?php foreach ($versions as $v): ?>
                    <td><?= $v["CongSuatHP"] . " HP" ?></td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td class="ux-row-label">Hộp số</td>
                <?php foreach ($versions as $v): ?>
                    <td><?= $v["HopSo"] ?></td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td class="ux-row-label">Tăng tốc 0–100 km/h</td>
                <?php foreach ($versions as $v): ?>
                    <td><?= $v["TangToc"] . " giây" ?></td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td class="ux-row-label">Tốc độ tối đa</td>
                <?php foreach ($versions as $v): ?>
                    <td><?= $v["TocDoToiDa"] . " km/h" ?></td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td class="ux-row-label">Trọng lượng</td>
                <?php foreach ($versions as $v): ?>
                    <td><?= $v["TrongLuong"] . " kg" ?></td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td class="ux-row-label">Số chỗ ngồi</td>
                <?php foreach ($versions as $v): ?>
                    <td><?= $v["ChoNgoi"] . " chỗ" ?></td>
                <?php endforeach; ?>
            </tr>

        </table>
    </div>
            <!-- NỘI THẤT -->
            <section class="fx-interior">
                <h3 style="font-size:28px; text-align:left">KHÁM PHÁ NỘI THẤT CỦA FUJICARS
                <?php echo htmlspecialchars($product['TenSP']); ?></h3>
                </br>
                </br>
                <img src="View/img/noithat.avif" alt="Nội thất xe">
            </section>
        </br>
        </br>
            <!-- ĐĂNG KÝ LÁI THỬ -->
            <section class="fx-form-section" style="width: 100%; max-width: 1000px; margin: 0 auto;">
            </br>
            </br>
                <h3>ĐĂNG KÝ LÁI THỬ XE</h3>
                <form id="fx-formDangKy">
                    <input type="hidden" name="ID" value="<?php echo htmlspecialchars($product['ID']); ?>">
                    <input type="text" value="<?php echo htmlspecialchars($product['TenSP']); ?>" readonly style="font-weight:bold; color:#e60000;">
                    <input type="text" name="hoten" placeholder="Họ và tên của bạn *" required>
                    <input type="email" name="email" placeholder="Email của bạn *" required>
                    <input type="tel" name="sdt" placeholder="Số điện thoại liên hệ *" required>
                    <input type="date" name="ngay" required>
                    <select name="gio" required>
                        <option value="">Chọn giờ</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                    </select>
                    <input type="text" name="diachi" placeholder="Nhập địa chỉ lái thử *" required>
                    <div class="fx-checkbox-group">
                        <input type="checkbox" checked required>
                        Tôi đồng ý với <a href="#">chính sách bảo mật</a>
                    </div>
                    <button type="submit" class="fx-submit" style="height:40px">Đăng ký lái thử</button>
                </form>
                </br>
                </br>
                </br>
            </section>

            <?php else: ?>
                <p>Không tìm thấy sản phẩm!</p>
            <?php endif; ?>
        </div>
        <!-- Overlay loading + thông báo -->
        <div id="fx-overlay" style="display:none;">
            <div class="fx-message">
                <i id="fx-icon" class="fas fa-spinner fa-spin fa-3x"></i>
                <p id="fx-text">Đang gửi đăng ký...</p>
            </div>
        </div>
        <!-- Truyền biến login cho JS -->
        <script>
            const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
        </script>
        <script src="js/product_details.js"></script>
    </div>
    </body>
    </html>
