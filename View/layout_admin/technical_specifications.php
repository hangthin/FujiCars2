            <?php
            require_once "Controller/config/config.php";
            /* ================== XỬ LÝ AJAX ================== */
            if(isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];

                // Lấy thông số theo ID sản phẩm
                if($ajax==='get_spec'){
                    $id = intval($_GET['id'] ?? 0);
                    if($id<=0){ echo json_encode([]); exit; }

                    $sql = "SELECT 
                                s.ID AS SanPhamID,
                                s.TenSP,
                                s.HinhAnh,
                                t.LoaiNhienLieu,
                                t.CongSuatHP,
                                t.HopSo,
                                t.TangToc,
                                t.TocDoToiDa,
                                t.TrongLuong,
                                t.ChoNgoi
                            FROM sanpham s
                            LEFT JOIN thongsokithuat t ON t.SanPhamID = s.ID
                            WHERE s.ID = $id LIMIT 1";

                    $res = $conn->query($sql);
                    $row = $res ? $res->fetch_assoc() : null;
                    echo json_encode($row ?: []);
                    exit;
                }

                // Lưu thông số
                if($ajax==='save_spec' && $_SERVER['REQUEST_METHOD']==='POST'){
                    $SanPhamID = intval($_POST['SanPhamID'] ?? 0);
                    $LoaiNhienLieu = trim($_POST['LoaiNhienLieu'] ?? '');
                    $CongSuatHP = trim($_POST['CongSuatHP'] ?? '');
                    $HopSo = trim($_POST['HopSo'] ?? '');
                    $TangToc = trim($_POST['TangToc'] ?? '');
                    $TocDoToiDa = trim($_POST['TocDoToiDa'] ?? '');
                    $TrongLuong = trim($_POST['TrongLuong'] ?? '');
                    $ChoNgoi = trim($_POST['ChoNgoi'] ?? '');

                    if(!$SanPhamID || $CongSuatHP=='' || $LoaiNhienLieu=='' || $HopSo=='' ||
                    $TangToc=='' || $TocDoToiDa=='' || $TrongLuong=='' || $ChoNgoi==''){
                        echo json_encode(['status'=>'error','message'=>'Không được để trống']);
                        exit;
                    }

                    // Kiểm tra tồn tại
                    $check = $conn->prepare("SELECT ID FROM thongsokithuat WHERE SanPhamID=? LIMIT 1");
                    $check->bind_param("i",$SanPhamID);
                    $check->execute();
                    $check->store_result();
                    $hasRow = $check->num_rows>0;
                    $check->close();

                    if($hasRow){
                        $stmt = $conn->prepare("UPDATE thongsokithuat
                                                SET LoaiNhienLieu=?, CongSuatHP=?, HopSo=?, TangToc=?, TocDoToiDa=?, TrongLuong=?, ChoNgoi=?
                                                WHERE SanPhamID=?");
                        $stmt->bind_param("ssssssii",
                            $LoaiNhienLieu, $CongSuatHP, $HopSo, $TangToc, $TocDoToiDa, $TrongLuong, $ChoNgoi, $SanPhamID);
                    }else{
                        $stmt = $conn->prepare("INSERT INTO thongsokithuat
                                                (SanPhamID, LoaiNhienLieu, CongSuatHP, HopSo, TangToc, TocDoToiDa, TrongLuong, ChoNgoi)
                                                VALUES(?,?,?,?,?,?,?,?)");
                        $stmt->bind_param("issssssi",
                            $SanPhamID, $LoaiNhienLieu, $CongSuatHP, $HopSo, $TangToc, $TocDoToiDa, $TrongLuong, $ChoNgoi);
                    }
                    $stmt->execute();
                    echo json_encode(['status'=>'success','message'=>'Cập nhật thành công']);
                    exit;
                }

                echo json_encode(['status'=>'error','message'=>'Lỗi AJAX']); 
                exit;
            }

            /* ================== LẤY DANH SÁCH XE ================== */
            $cars = [];
            $rs = $conn->query("SELECT ID, TenSP, HinhAnh FROM sanpham ORDER BY ID DESC");
            if($rs) while($r = $rs->fetch_assoc()) $cars[] = $r;
            ?>
            <!doctype html>
            <html lang="vi">
            <head>
            <meta charset="utf-8">
            <title>Quản lý thông số kỹ thuật xe</title>
            <meta name="viewport" content="width=device-width,initial-scale=1">
            <link rel="stylesheet" href="View/css/styleCss.css">
            </head>
            <body class="cssBodyWrap cssAllReset">
            <div class="bx210">
            <h1 style="text-align:center;color:#e53935;margin-bottom:20px;font-size:26px;">CẬP NHẬT THÔNG SỐ KĨ THUẬT</h1>
            <div class="lm992">
                <div class="nk551">
                    <h3 class="cs119">Danh Sách Sản Phẩm</h3>
                    <input type="text" id="searchCar" class="hr771" placeholder="Tìm xe...">
                    <div class="vv201" id="carListArea">
                    <?php foreach($cars as $c): 
                        $spec = $conn->query("SELECT * FROM thongsokithuat WHERE SanPhamID=".$c['ID']." LIMIT 1")->fetch_assoc();
                    ?>
                    <div class="qa882" data-id="<?= $c['ID'] ?>" data-name="<?= htmlspecialchars($c['TenSP']) ?>" onclick="selectCar(this)">
                        <img src="View/img/SP/<?= htmlspecialchars($c['HinhAnh']) ?>" alt="<?= htmlspecialchars($c['TenSP']) ?>">
                        <div class="kc332"><?= htmlspecialchars($c['TenSP']) ?></div>
                        <div class="lk093">ID: <?= $c['ID'] ?></div>
                        <?php if($spec): ?>
                        <div class="ks400">
                            <small>Loại NL: <?= htmlspecialchars($spec['LoaiNhienLieu']) ?></small>
                            <small>Công suất: <?= htmlspecialchars($spec['CongSuatHP']) ?> HP</small>
                            <small>Hộp số: <?= htmlspecialchars($spec['HopSo']) ?></small>
                            <small>Tăng tốc: <?= htmlspecialchars($spec['TangToc']) ?> s</small>
                            <small>Tốc độ tối đa: <?= htmlspecialchars($spec['TocDoToiDa']) ?> km/h</small>
                            <small>Trọng lượng: <?= htmlspecialchars($spec['TrongLuong']) ?> kg</small>
                            <small>Số chỗ: <?= htmlspecialchars($spec['ChoNgoi']) ?></small>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                    </div>
                </div>

                <div class="fg881">
                    <h3 class="cs119">Thông Số Kĩ Thuật</h3>
                    <form id="specForm" onsubmit="return false;">
                        <input type="hidden" id="SanPhamID" name="SanPhamID">
                        <div class="tw221">
                            <label>Loại nhiên liệu</label>
                            <select id="LoaiNhienLieu" name="LoaiNhienLieu">
                                <option value="">Chọn</option>
                                <option value="Xăng">Xăng</option>
                                <option value="Điện">Điện</option>
                            </select>
                        </div>
                        <div class="tw221">
                            <label>Công suất (HP)</label>
                            <input type="number" id="CongSuatHP" name="CongSuatHP">
                        </div>
                        <div class="tw221">
                            <label>Hộp số</label>
                            <input type="text" id="HopSo" name="HopSo">
                        </div>
                        <div class="tw221">
                            <label>Tăng tốc (s)</label>
                            <input type="number" id="TangToc" name="TangToc">
                        </div>
                        <div class="tw221">
                            <label>Tốc độ tối đa (km/h)</label>
                            <input type="number" id="TocDoToiDa" name="TocDoToiDa">
                        </div>
                        <div class="tw221">
                            <label>Trọng lượng (kg)</label>
                            <input type="number" id="TrongLuong" name="TrongLuong">
                        </div>
                        <div class="tw221">
                            <label>Số chỗ</label>
                            <input type="number" id="ChoNgoi" name="ChoNgoi">
                        </div>
                    </form>
                </div>

                <div class="jq002">
                    <div class="mz992">
                        <button class="qq321 vx002" id="btnHuy">Hủy</button>
                        <button class="qq321 gb771" id="btnLuu">Cập nhật</button>
                        <button id="btnPrint" class="qq321 gb771" style="margin:10px 0;">In danh sách</button>
                    </div>
                </div>
            </div>
            </div>
            <div id="msgBox" class="ms882"></div>
            <script>
                document.getElementById('btnPrint').onclick = function () {

    const activeCar = document.querySelector('.qa882.active');

    // ================================
    // TRƯỜNG HỢP 1: ĐANG CHỌN XE
    // ================================
    if (activeCar) {

        const img = activeCar.querySelector("img").src;
        const name = activeCar.querySelector(".kc332").textContent;
        const id = activeCar.dataset.id;

        // Lấy thông số đang hiển thị trên form
        const spec = {
            LoaiNhienLieu: LoaiNhienLieu.value,
            CongSuatHP: CongSuatHP.value,
            HopSo: HopSo.value,
            TangToc: TangToc.value,
            TocDoToiDa: TocDoToiDa.value,
            TrongLuong: TrongLuong.value,
            ChoNgoi: ChoNgoi.value
        };

        let html = `
        <html>
        <head>
            <title>In thông số xe</title>
            <style>
                body { font-family: Arial; padding: 20px; }
                img { width: 200px; height: auto; }
                table { width: 100%; border-collapse: collapse; margin-top: 15px; }
                td, th { border: 1px solid #ccc; padding: 8px; }
                h2 { margin-bottom: 10px; }
            </style>
        </head>
        <body>
            <h2>Thông số kỹ thuật xe</h2>
            <img src="${img}">
            <h3>${name} (ID: ${id})</h3>

            <table>
                <tr><th>Loại nhiên liệu</th><td>${spec.LoaiNhienLieu}</td></tr>
                <tr><th>Công suất (HP)</th><td>${spec.CongSuatHP}</td></tr>
                <tr><th>Hộp số</th><td>${spec.HopSo}</td></tr>
                <tr><th>Tăng tốc (s)</th><td>${spec.TangToc}</td></tr>
                <tr><th>Tốc độ tối đa (km/h)</th><td>${spec.TocDoToiDa}</td></tr>
                <tr><th>Trọng lượng (kg)</th><td>${spec.TrongLuong}</td></tr>
                <tr><th>Số chỗ</th><td>${spec.ChoNgoi}</td></tr>
            </table>
        </body>
        </html>
        `;

        const w = window.open("", "", "width=900,height=600");
        w.document.write(html);
        w.document.close();
        w.focus();
        w.print();
        w.close();
        return;
    }

    // =======================================
    // TRƯỜNG HỢP 2: KHÔNG CHỌN XE → IN DANH SÁCH + THÔNG SỐ
    // =======================================
    const visibleItems = [...document.querySelectorAll('.qa882')]
        .filter(div => div.style.display !== 'none');

    if (visibleItems.length === 0) {
        alert("Không có xe nào để in.");
        return;
    }

    let html = `
    <html>
    <head>
        <title>In danh sách xe</title>
        <style>
            body { font-family: Arial; padding: 20px; }
            .item { margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 15px; }
            img { width: 140px; height: auto; float: left; margin-right: 15px; }
            h3 { margin: 0; padding: 0; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            td, th { border: 1px solid #ccc; padding: 6px; }
            .info { overflow: hidden; }
        </style>
    </head>
    <body>
        <h2>Danh sách xe</h2>
    `;

    visibleItems.forEach(el => {

        const img = el.querySelector("img").src;
        const name = el.querySelector(".kc332").textContent;
        const id = el.dataset.id;

        // Lấy thông số từ thẻ ks400
        const specDiv = el.querySelector(".ks400");

        const spec = specDiv ? {
            LoaiNhienLieu: specDiv.querySelectorAll("small")[0]?.textContent.replace("Loại NL: ","") || "",
            CongSuatHP: specDiv.querySelectorAll("small")[1]?.textContent.replace("Công suất: ","").replace(" HP","") || "",
            HopSo: specDiv.querySelectorAll("small")[2]?.textContent.replace("Hộp số: ","") || "",
            TangToc: specDiv.querySelectorAll("small")[3]?.textContent.replace("Tăng tốc: ","").replace(" s","") || "",
            TocDoToiDa: specDiv.querySelectorAll("small")[4]?.textContent.replace("Tốc độ tối đa: ","").replace(" km/h","") || "",
            TrongLuong: specDiv.querySelectorAll("small")[5]?.textContent.replace("Trọng lượng: ","").replace(" kg","") || "",
            ChoNgoi: specDiv.querySelectorAll("small")[6]?.textContent.replace("Số chỗ: ","") || "",
        } : null;

        html += `
            <div class="item">
                <img src="${img}">
                <div class="info">
                    <h3>${name} (ID: ${id})</h3>

                    ${spec ? `
                    <table>
                        <tr><th>Loại nhiên liệu</th><td>${spec.LoaiNhienLieu}</td></tr>
                        <tr><th>Công suất (HP)</th><td>${spec.CongSuatHP}</td></tr>
                        <tr><th>Hộp số</th><td>${spec.HopSo}</td></tr>
                        <tr><th>Tăng tốc (s)</th><td>${spec.TangToc}</td></tr>
                        <tr><th>Tốc độ tối đa (km/h)</th><td>${spec.TocDoToiDa}</td></tr>
                        <tr><th>Trọng lượng (kg)</th><td>${spec.TrongLuong}</td></tr>
                        <tr><th>Số chỗ</th><td>${spec.ChoNgoi}</td></tr>
                    </table>
                    ` : `<p style="color:gray;">Chưa có thông số kỹ thuật.</p>`}
                </div>
                <div style="clear: both;"></div>
            </div>
        `;
    });

    html += "</body></html>";

    const printWin = window.open("", "", "width=900,height=600");
    printWin.document.write(html);
    printWin.document.close();
    printWin.focus();
    printWin.print();
    printWin.close();
};

          


            <?php include "js/update_technical-specifications.js"; ?>
            </script>
            </body>
            </html>
