    <?php
    session_start();
    include "../../Controller/config/config.php";

    // Lấy dữ liệu từ form
    $cartData = isset($_POST['cartData']) ? $_POST['cartData'] : null;
    $tongTien = isset($_POST['TongTien']) ? (int)$_POST['TongTien'] : 0;
    if (!$cartData || $tongTien <= 0) {
        die("Dữ liệu đơn hàng không hợp lệ.");
    }

    // Decode JSON giỏ hàng
    $cartItems = json_decode($cartData, true);
    if (!$cartItems) die("Lỗi dữ liệu giỏ hàng!");

    // 🔹 Tạo nội dung chuyển khoản từ tên sản phẩm
    $productNames = array_map(function($item){
        return $item['TenSP'] . " x" . $item['SoLuong'];
    }, $cartItems);

    $description = "Thanh toán sản phẩm: " . implode(", ", $productNames);

    // 🏦 Thông tin tài khoản nhận
    $account_name   = "VO THIEN NHI";
    $account_number = "2021052004";
    $bank_code      = "970407"; // MBBank
    $transaction_id = "CG" . time(); // CG = Checkout Giỏ hàng

    // 🌐 Gọi API VietQR
    $clientId = "d0ffc373-045f-48ee-bbd3-8fceb98de72b";
    $apiKey   = "e336cccd-251e-4b78-bd11-493bd2f7d209";
    $endpoint = "https://api.vietqr.io/v2/generate";

    $body = array(
        "accountNo"   => $account_number,
        "accountName" => $account_name,
        "acqId"       => $bank_code,
        "amount"      => $tongTien,
        "addInfo"     => $description,
        "template"    => "compact"
    );

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "x-client-id: {$clientId}",
        "x-api-key: {$apiKey}"
    ));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $response = curl_exec($ch);

    if($response === false){
        die("Curl lỗi: " . curl_error($ch));
    }

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Debug chi tiết nếu lỗi
    if ($httpcode !== 200) {
        die("Lỗi VietQR: HTTP code $httpcode, response: $response");
    }

    // Decode response an toàn
    $data = json_decode($response, true);
    if (!$data) {
        die("Không thể decode JSON từ VietQR: $response");
    }

    $qrDataUrl = (isset($data['data']['qrDataURL']) && $data['data']['qrDataURL']) ? $data['data']['qrDataURL'] : null;
    if (!$qrDataUrl) {
        die("VietQR trả về dữ liệu không hợp lệ: $response");
    }

    // 🔒 Lưu session giao dịch
    $_SESSION['bank_txn'] = array(
        'transaction_id' => $transaction_id,
        'cartItems'      => $cartItems,
        'total'          => $tongTien
    );
    ?>

    <!DOCTYPE html>
    <html lang="vi">
    <head>
    <meta charset="UTF-8">
    <title>Thanh toán giỏ hàng</title>
    <style>

    /* THANH TOÁN ONLINE */
.payment-page {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    padding: 20px;
    /* gradient trắng – đen – đỏ */
    background: linear-gradient(135deg, #ffffff 0%, #0b0b0b 50%, #ff2e2e 100%);
}

.payment-card {
    width: 100%;
    max-width: 480px;
    max-height: 90vh;
    background: linear-gradient(135deg, #1e1e1e 0%, #0b0b0b 50%, #ff2e2e 100%);
    border-radius: 20px;
    padding: 32px 28px;
    text-align: center;
    border: 1px solid #ff2e2e;
    box-shadow: 0 8px 30px rgba(255, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    justify-content: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.payment-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(255, 0, 0, 0.45);
}

h2 {
    color: #ff2e2e;
    font-size: 26px;
    margin-bottom: 24px;
    text-shadow: 0 0 6px #ff2e2e, 0 0 12px rgba(255, 46, 46, 0.3);
}

.info-row {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    padding: 10px 0;
    font-size: 15px;
}

.label {
    color: #ccc;
}

.amount {
    color: #ff2e2e;
    font-weight: 700;
}

.note {
    color: #aaa;
    font-style: italic;
    word-break: break-word;
    text-align: right;
    font-size: 13px;
}

.qr-box {
    margin: 24px 0;
}

.qr-frame {
    display: inline-block;
    padding: 18px;
    background: #1e1e1e;
    border-radius: 14px;
    border: 2px solid #ff2e2e;
    box-shadow: 0 4px 15px rgba(255, 0, 0, 0.25);
}

.qr-frame img {
    max-width: 200px;
    display: block;
    border-radius: 10px;
}

.btn-confirm {
    margin-top: 20px;
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    background: linear-gradient(90deg, #ffffff, #0b0b0b, #ff2e2e);
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 0, 0, 0.35);
}

.btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(255, 0, 0, 0.55);
}
 /* CUỐI THANH TOÁN ONLINE */

    </style>
    </head>
    <body>
    <div class="payment-page">
    <div class="payment-card">
        <h2>Thanh toán chuyển khoản</h2>
        <div class="bank-info">
            <div class="info-row"><span class="label">Người nhận</span><span><?=htmlspecialchars($account_name)?></span></div>
            <div class="info-row"><span class="label">Số tài khoản</span><span><?=htmlspecialchars($account_number)?></span></div>
            <div class="info-row"><span class="label">Ngân hàng</span><span><?=htmlspecialchars($bank_code)?></span></div>
            <div class="info-row"><span class="label">Tổng tiền</span><span class="amount"><?=number_format($tongTien)?> VND</span></div>
            <div class="info-row"><span class="label">Nội dung CK</span><span class="note"><?=htmlspecialchars($description)?></span></div>
        </div>

        <div class="qr-box">
            <?php if ($qrDataUrl): ?>
                <p>Quét mã QR để thanh toán</p>
                <div class="qr-frame"><img src="<?=htmlspecialchars($qrDataUrl)?>" alt="VietQR"></div>
            <?php else: ?>
                <p>Lỗi tạo QR</p>
            <?php endif; ?>
        </div>
        <form method="POST" action="../../Controller/handle-user/payment_callback.php">
        <input type="hidden" name="transaction_id" value="<?=htmlspecialchars($transaction_id)?>">
        <button type="submit" name="action" value="simulate_success" class="btn-confirm">Xác nhận đã chuyển khoản</button>
        </form>
    </div>
    </div>
    </body>
    </html>
