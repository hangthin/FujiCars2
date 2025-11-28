

// Nút Mua ngay
document.querySelector('.fx-buy-now-btn')?.addEventListener('click', function() {
    if (!isLoggedIn) {
        alert("Bạn cần đăng nhập để mua hàng!");
        window.location.href = "index.php?n=login";
        return;
    }

    const pid = document.querySelector('input[name="MaSP"]').value;
    const qty = document.getElementById('fx-quantityInput').value;

    if (!pid || !qty) {
        alert("Thiếu thông tin sản phẩm hoặc số lượng!");
        return;
    }

    window.location.href = "./View/layout_user/pay-now.php?n=" + pid + "&SoLuong=" + qty;
});


//cart
document.querySelector('.fx-add-to-cart-btn').addEventListener('click', function () {
    const id = document.querySelector('[name="MaSP"]').value;
    const qty = document.querySelector('[name="SoLuong"]').value;

    fetch('Controller/handle-admin/process_add_to_cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=add&id=' + id + '&qty=' + qty
    })
    .then(r => r.text())
    .then(d => {
        d = d.trim();
        if (d === 'success') {
            alert('🛒 Sản phẩm đã được thêm vào giỏ hàng!');
        } else if (d === 'not_logged') {
            alert('❌ Vui lòng đăng nhập trước khi thêm giỏ hàng!');
            window.location.href = 'index.php?n=Login';
        } else if (d === 'not_found') {
            alert('❌ Không tìm thấy sản phẩm!');
        } else {
            alert('⚠️ Lỗi: ' + d);
        }
    })
    .catch(err => alert('Lỗi kết nối: ' + err));
});



// Đăng ký lái thử với kiểm tra kho + overlay thông báo
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("fx-formDangKy");
    const overlay = document.getElementById("fx-overlay");
    const icon = document.getElementById("fx-icon");
    const text = document.getElementById("fx-text");
    const productID = document.querySelector('input[name="ID"]').value;

    // Hàm hiển thị overlay
    function showOverlay(message, iconClass = "fas fa-spinner fa-spin") {
        overlay.style.display = "flex";
        icon.className = iconClass + " fa-3x";
        text.textContent = message;
    }

    // Hàm ẩn overlay
    function hideOverlay(delay = 3000) {
        setTimeout(() => { overlay.style.display = "none"; }, delay);
    }

    // Hàm kiểm tra kho xe
    async function checkKho(ID) {
        try {
            const resp = await fetch("Controller/handle-admin/process_check-warehouse.php", {
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: "ID=" + ID
            });
            const data = await resp.json();
            return data.SoLuong_CoSan || 0;
        } catch (err) {
            console.error("❌ Lỗi kiểm tra kho:", err);
            return 0;
        }
    }

    // Xử lý submit form
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        if (!productID) {
            alert("Vui lòng chọn xe muốn lái thử!");
            return;
        }

        // Hiển thị overlay loading kiểm tra kho
        showOverlay("Đang kiểm tra kho...");

        const soLuong = await checkKho(productID);

        if (soLuong <= 0) {
            showOverlay("🚨 Xe này hiện tại không còn đủ số lượng lái thử.", "fas fa-exclamation-triangle");
            hideOverlay();
            return;
        }

        // Kho đủ, chuẩn bị gửi đăng ký
        showOverlay("Kho đủ xe, đang gửi đăng ký...");

        const formData = new FormData(form);

        try {
            const response = await fetch("Controller/handle-user/register_test-drive_process.php", {
                method: "POST",
                body: formData
            });
            const result = await response.text();
            console.log("📩 Phản hồi từ server:", result);

            if (result.trim().toLowerCase() === "success") {
                icon.className = "fas fa-check-circle fa-3x success";
                text.textContent = "Đăng ký lái thử thành công!";
                // Nếu dùng anime.js
                if (typeof anime === "function") {
                    anime({
                        targets: '.success',
                        scale: [0, 1.2, 1],
                        duration: 600,
                        easing: 'easeOutElastic(1, .8)'
                    });
                }
                form.reset();
            } else {
                icon.className = "fas fa-exclamation-triangle fa-3x";
                text.textContent = "⚠️ Lỗi từ máy chủ: " + result;
            }
            hideOverlay();
        } catch (err) {
            console.error("❌ Lỗi fetch:", err);
            showOverlay("❌ Không thể kết nối máy chủ!", "fas fa-exclamation-triangle");
            hideOverlay();
        }
    });
});
