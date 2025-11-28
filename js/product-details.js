document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("fx-formDangKy");
  const overlay = document.getElementById("fx-overlay");
  const icon = document.getElementById("fx-icon");
  const text = document.getElementById("fx-text");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const ID = document.getElementById("ID").value;
    if (!ID) {
      alert("Vui lòng chọn xe muốn lái thử!");
      return;
    }

    // Hiển thị overlay loading
    overlay.style.display = "flex";
    icon.className = "fas fa-spinner fa-spin fa-3x";
    text.textContent = "Đang kiểm tra kho...";

    try {
      // Kiểm tra kho
      const checkResponse = await fetch("Controller/handle-admin/process_check-warehouse.php", {
        method: "POST",
        body: new URLSearchParams({ ID })
      });
      const checkResult = await checkResponse.json();

      if (checkResult.SoLuong_CoSan > 0) {
        text.textContent = "Kho đủ xe, đang gửi đăng ký...";

        // Gửi đăng ký
        const formData = new FormData(form);
        const response = await fetch("Controller/handle-user/register_test-drive_process.php", {
          method: "POST",
          body: formData
        });

        const result = await response.text();
        console.log("📩 Phản hồi từ server:", result);

        if (result.trim().toLowerCase() === "success") {
          icon.className = "fas fa-check-circle fa-3x success";
          text.textContent = "✅ Đăng ký lái thử thành công!";
          anime({
            targets: '.success',
            scale: [0, 1.2, 1],
            duration: 600,
            easing: 'easeOutElastic(1, .8)'
          });
          form.reset();
        } else {
          icon.className = "fas fa-exclamation-triangle fa-3x";
          text.textContent = "⚠️ Lỗi từ máy chủ: " + result;
        }
      } else {
        icon.className = "fas fa-exclamation-triangle fa-3x";
        text.textContent = "🚨 Xe này hiện tại không còn đủ số lượng lái thử.";
      }

      // Ẩn overlay sau 3s
      setTimeout(() => overlay.style.display = "none", 3000);

    } catch (err) {
      console.error("❌ Lỗi fetch:", err);
      icon.className = "fas fa-exclamation-triangle fa-3x";
      text.textContent = "❌ Không thể kết nối máy chủ!";
      setTimeout(() => overlay.style.display = "none", 3000);
    }
  });
});




document.querySelector('.fx-buy-now-btn')?.addEventListener('click', function() {
  const pid = document.querySelector('input[name="MaSP"]').value;
  const qty = document.getElementById('fx-quantityInput').value;

  if (!pid || !qty) {
    alert("Thiếu thông tin sản phẩm hoặc số lượng!");
    return;
  }

  // ✅ đổi từ MaSP thành n (đúng với code thanhtoan_muangay.php)
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
