<?php
include '../../Controller/config/config.php';
header("Content-Type: text/html; charset=UTF-8");

$question = strtolower(trim($_POST['question'] ?? ''));
if ($question === '') exit("❓ Bạn hãy nhập câu hỏi nhé!");

// ================== PHÂN TÍCH GIÁ TIỀN (CHUẨN HÓA ĐƠN VỊ) ==================
$limitPrice = 0;

if (preg_match('/(\d+([.,]?\d+)*)\s*(tỷ|tỉ|ty|ti|t|triệu|trieu|tr)?/iu', $question, $m)) {
    $numRaw = str_replace(',', '.', $m[1]);  // chuyển 1,2 -> 1.2
    $num = floatval($numRaw);
    $unit = isset($m[3]) ? mb_strtolower(trim($m[3]), 'UTF-8') : '';

    // ✅ Chuẩn hóa đơn vị: mọi dạng "tỉ", "ty", "ti", "t" => "tỷ"
    if (in_array($unit, ['tỷ', 'tỉ', 'ty', 'ti', 't'])) {
        $limitPrice = $num * 1000000000; // ✅ 1 tỉ = 1 tỷ = 1e9
    } elseif (in_array($unit, ['triệu', 'trieu', 'tr'])) {
        $limitPrice = $num * 1000000; // ✅ 1 triệu = 1e6
    } else {
        // Nếu không có đơn vị -> coi là đồng
        $limitPrice = $num;
    }

    // ép kiểu an toàn thành integer (đồng)
    $limitPrice = (int) round($limitPrice);
}

// ================== TRUY VẤN CƠ SỞ DỮ LIỆU ==================
if ($limitPrice > 0) {
    $sql = "SELECT TenSP, Gia, LoaiSP, MoTa 
            FROM sanpham 
            WHERE Gia <= $limitPrice 
            ORDER BY Gia ASC";
    $rs = mysqli_query($conn, $sql);

    if ($rs && mysqli_num_rows($rs) > 0) {
        echo "🚗 Các mẫu xe dưới " . number_format($limitPrice, 0, ',', '.') . "₫:<br><br>";
        while ($row = mysqli_fetch_assoc($rs)) {
            echo "<b>" . htmlspecialchars($row['TenSP']) . "</b><br>";
            echo "Giá: " . number_format($row['Gia'], 0, ',', '.') . "₫<br>";
            echo "Loại: " . htmlspecialchars($row['LoaiSP']) . "<br>";
            echo "Mô tả: " . htmlspecialchars($row['MoTa']) . "<br><hr>";
        }
    } else {
        echo "😔 Không có mẫu xe nào dưới " . number_format($limitPrice, 0, ',', '.') . "₫.";
    }
} else {
    echo "❓ Không nhận diện được mức giá. Bạn có thể nhập như: <b>xe dưới 1 tỷ</b> hoặc <b>xe dưới 800 triệu</b>.";
}
?>
