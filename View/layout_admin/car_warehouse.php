<?php
include("Controller/config/config.php");
ini_set('display_errors',1);
error_reporting(E_ALL);

// ======= THÔNG BÁO =======
$message = "";

// ======= XỬ LÝ CẬP NHẬT KHO =======
if (isset($_POST['capnhat'])) {

    $MaXe = intval($_POST['MaXe']);
    $CoSan = intval($_POST['CoSan'] ?? 0);
    $LaiThu = intval($_POST['LaiThu'] ?? 0);
    $BaoTri = intval($_POST['BaoTri'] ?? 0);
    $NgayCapNhat = date('Y-m-d H:i:s');

    if($MaXe > 0){
        $check = $conn->query("SELECT * FROM kho_xe_laythu WHERE MaXe=$MaXe")->fetch_assoc();

        if($check){
            $sql = "UPDATE kho_xe_laythu 
                    SET SoLuong_CoSan=$CoSan,
                        SoLuong_LaiThu=$LaiThu,
                        SoLuong_BaoTri=$BaoTri,
                        NgayCapNhat='$NgayCapNhat'
                    WHERE MaXe=$MaXe";
        } else {
            $sql = "INSERT INTO kho_xe_laythu(MaXe, NgayCapNhat, SoLuong_CoSan, SoLuong_LaiThu, SoLuong_BaoTri)
                    VALUES($MaXe,'$NgayCapNhat',$CoSan,$LaiThu,$BaoTri)";
        }

        if($conn->query($sql)){
            $message = "Cập nhật kho xe thành công!";
        } else {
            $message = "Lỗi khi cập nhật kho!";
        }
    } else {
        $message="Vui lòng chọn xe!";
    }
}

// ======= LẤY DỮ LIỆU =======
$sqlSanPham = "SELECT * FROM sanpham";
$resSanPham = $conn->query($sqlSanPham);
$danhSachSanPham = [];
while($sp = $resSanPham->fetch_assoc()){
    $danhSachSanPham[$sp['ID']] = $sp;
}

$sqlKho = "SELECT * FROM kho_xe_laythu";
$resKho = $conn->query($sqlKho);
$xeKho = [];
while($row=$resKho->fetch_assoc()){
    $xeKho[$row['MaXe']] = $row;
}

$orders = [];
foreach($danhSachSanPham as $id=>$sp){
    $orders[] = [
        "id"=>$id,
        "car"=>$sp['TenSP'],
        "img"=>"View/img/SP/" . ($sp['HinhAnh'] ?? 'default.png'),
        "coSan"=>$xeKho[$id]['SoLuong_CoSan'] ?? 0,
        "laiThu"=>$xeKho[$id]['SoLuong_LaiThu'] ?? 0,
        "baoTri"=>$xeKho[$id]['SoLuong_BaoTri'] ?? 0
    ];
}

$jsonOrders = json_encode($orders, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Kho xe</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
/* ====== RESET & CHUNG ====== */
.kxAll * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
.kxBody { margin:0; background:#f0f2f5; color:#333; }

/* ====== WRAPPER ====== */
.kxWrap { width:95%; max-width:1400px; margin:0 auto; padding:20px 0; background:#000; }

/* ====== LAYOUT ====== */
.kxLayout { display:grid; grid-template-columns:30% 70%; gap:15px; height:calc(100vh - 80px); }
.kxLeft, .kxRight { border-radius:10px; }
.kxLeft { background:#fff; border-right:1px solid #e0e0e0; padding:20px; overflow-y:auto; box-shadow:0 2px 8px rgba(0,0,0,0.05);}
.kxRight { padding:20px; overflow-x:auto; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.05); }

/* ====== FORM LEFT INPUT & SELECT ====== */
.kxLeft form { display:flex; flex-direction:column; gap:12px; }
.kxLeft label { font-weight:600; color:#111; font-size:14px; }
.kxLeft select,
.kxLeft input[type="number"] {
    padding:10px 12px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
    transition: all 0.25s ease;
}
.kxLeft select:focus,
.kxLeft input[type="number"]:focus {
    border-color:#1976d2;
    outline:none;
    box-shadow:0 2px 8px rgba(25,118,210,0.25);
}

/* ====== BUTTON ====== */
.kxBtn { padding:8px 14px; background:#1976d2; color:#fff; border:none; border-radius:8px; cursor:pointer; font-weight:600; transition:all 0.25s ease; }
.kxBtn:hover { background:#1565c0; }

/* ====== ORDER CARD ====== */
.kxOrderCard {
    display:flex; gap:12px; padding:14px; border-radius:12px; border:1px solid #e0e0e0;
    margin-bottom:12px; cursor:pointer; background:#fafafa; transition:all 0.25s ease;
}
.kxOrderCard:hover { background:#f1f5f9; transform:translateY(-2px); }
.kxOrderCard img { width:130px; height:60px; border-radius:8px; object-fit:cover; }
.kxOrderCard b { font-size:16px; color:#111; }
.kxOrderCard small { font-size:13px; color:#666; }
.kxOrderCard span { width: 100px; height:20px; text-align:center; font-size:15px; font-weight:600; padding:2px 6px; border-radius:6px; display:inline-block; }

/* ====== STATUS COLORS ====== */
.kxPending { background:#ffc107; color:#000; }
.kxDoing { background:#4caf50; color:#000; }
.kxDone { background:#4caf50; color:#fff; }
.kxCancel { background:#f44336; color:#000; }

/* ====== STATUS LEGEND ====== */
.kxStatusLegend { margin-top:20px; padding:12px; background:#fff; border:1px solid #e0e0e0; border-radius:12px; display:flex; gap:15px; flex-wrap:wrap; font-size:13px; }
.kxStatusLegend div { display:flex; align-items:center; gap:6px; }
.kxStatusColor { width:18px; height:16px; border-radius:4px; }
.kxPendingColor { background:#ffc107; }
.kxDoingColor { background:#4caf50; }
.kxDoneColor { background:#4caf50; }
.kxCancelColor { background:#f44336; }

/* ====== MESSAGE ====== */
.kxMsg { margin:15px 0; text-align:center; color:#388e3c; font-weight:600; }

/* ====== FILTER PANEL ====== */
.kxFilterPanel { margin-bottom:20px; display:flex; gap:12px; flex-wrap:wrap; }
.kxFilterPanel input,
.kxFilterPanel select { flex:1; padding:10px 12px; border-radius:8px; border:1px solid #ccc; font-size:14px; transition:all 0.25s ease; }
.kxFilterPanel input:focus,
.kxFilterPanel select:focus { border-color:#1976d2; outline:none; }

/* ====== RESPONSIVE ====== */
@media (max-width:900px){
  .kxLayout { grid-template-columns: 1fr; height:auto; }
  .kxWrap { padding:12px 8px; }
}
</style>
</head>
<body class="kxBody">
<div class="kxWrap">
    <h1 style="text-align:center;color:white;margin-bottom:10px;">KHO XE LÁI THỬ</h1>

    <p style="text-align:center;margin-top:0;margin-bottom:25px;font-size:15px;color:#ccc;">Quản lý danh sách kho
         xe đăng ký lái thử theo dõi và cập nhật số lượng có sẵn, đang lái thử và bảo trì.</p>
    
<?php if($message): ?>
    <p id="messageBox" class="kxMsg"><?= $message ?></p>
<?php endif; ?>

    <div class="kxLayout">
        <!-- LEFT: form -->
        <div class="kxLeft">
            </br>
            <h3 style="margin-top:0;color:blue;">Cập Nhật Kho Xe</h3>
            <form method="POST">
                
                <select name="MaXe" id="MaXeSelect">
                    <option value="">Chọn xe</option>
                    <?php foreach($danhSachSanPham as $sp): ?>
                        <option value="<?= $sp['ID'] ?>"><?= htmlspecialchars($sp['TenSP']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label style="font-size:16px;">Số lượng còn sẵn</label>
                <input type="number" name="CoSan" id="CoSanInput" min="0">

                <label style="font-size:16px;">Số lượng lái thử</label>
                <input type="number" name="LaiThu" id="LaiThuInput" min="0">

                <label style="font-size:16px;">Số lượng bảo trì</label>
                <input type="number" name="BaoTri" id="BaoTriInput" min="0">

                <div style="margin-top:12px;">
                    <button type="submit" name="capnhat" class="kxBtn">Cập nhật kho xe</button>
                </div>
            </form>
        </div>

        <!-- RIGHT: danh sách -->
        <div class="kxRight">
           <h2 style="font-size:20px;font-weight:600;color:red;margin-bottom:10px;">Danh Sách Số Lượng Tình Trạng Xe</h2>
                        <div class="kxStatusLegend" style="margin-top:18px; font-size:15px;">
                <div><div class="kxStatusColor kxPendingColor"></div> Còn sẵn</div>
                <div><div class="kxStatusColor kxDoingColor"></div> Lái thử</div>
                <div><div class="kxStatusColor kxCancelColor"></div> Bảo trì</div>
            </div>
             
                    </br>
                  
            <div class="kxFilterPanel" style="padding:0 0 12px 0;">
                <input type="text" id="searchBox" placeholder="Tìm theo tên xe...">
                <select id="statusFilter">
                    <option value="">Tất cả trạng thái</option>
                    <option value="coSan">Còn sẵn</option>
                    <option value="laiThu">Lái thử</option>
                    <option value="baoTri">Bảo trì</option>
                </select>
            </div>
  
               
            <div id="orderCards"></div>
        </div>
    </div>
</div>

<script>
let orders = <?= $jsonOrders ?>;
let filtered = [...orders];

function escapeHtml(text){
    if(!text) return '';
    return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function renderOrders(){
    const box = document.getElementById("orderCards");
    box.innerHTML = "";
    if(filtered.length===0){
        box.innerHTML = '<p style="color:#666">Không có xe phù hợp.</p>';
        return;
    }
    filtered.forEach(o=>{
        box.innerHTML += `
        <div class="kxOrderCard" data-id="${o.id}">
            <img src="${o.img}" alt="${o.car}">
            <div>
                <b>${escapeHtml(o.car)}</b><br>
                <small>
                    <span class="kxPending"> ${o.coSan}</span>
                    &nbsp;
                    <span class="kxDoing"> ${o.laiThu}</span>
                    &nbsp;
                    <span class="kxCancel"> ${o.baoTri}</span>
                </small>
            </div>
        </div>`;
    });

    document.querySelectorAll('.kxOrderCard').forEach(card=>{
        card.addEventListener('click', ()=>{
            const id = card.getAttribute('data-id');
            const o = orders.find(x=>x.id == id);
            if(o){
                document.getElementById('MaXeSelect').value = o.id;
                document.getElementById('CoSanInput').value = o.coSan;
                document.getElementById('LaiThuInput').value = o.laiThu;
                document.getElementById('BaoTriInput').value = o.baoTri;
                window.scrollTo({top:0, behavior:'smooth'});
            }
        });
    });
}

function applyFilters(){
    const searchVal = document.getElementById('searchBox').value.toLowerCase();
    const statusVal = document.getElementById('statusFilter').value;

    filtered = orders.filter(o => {
        let matchSearch = (o.car||'').toLowerCase().includes(searchVal);
        let matchStatus = true;
        if(statusVal === "coSan") matchStatus = o.coSan > 0;
        if(statusVal === "laiThu") matchStatus = o.laiThu > 0;
        if(statusVal === "baoTri") matchStatus = o.baoTri > 0;
        return matchSearch && matchStatus;
    });

    renderOrders();
}

document.getElementById('searchBox').addEventListener('keyup', applyFilters);
document.getElementById('statusFilter').addEventListener('change', applyFilters);

renderOrders();

const msgBox = document.getElementById('messageBox');
if(msgBox){
    setTimeout(()=>{ 
        msgBox.style.transition = "opacity 0.5s";
        msgBox.style.opacity = "0"; 
    }, 2000);
}
</script>
</body>
</html>
