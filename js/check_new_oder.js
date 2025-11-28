// update-invoice.js - Nhận realtime đơn hàng mới và hiển thị thông báo

document.addEventListener("DOMContentLoaded", () => {

    // ============================
    // CÁC PHẦN TỬ GIAO DIỆN CHATBOX / POPUP / THÔNG BÁO
    // ============================
    const chatbox = document.getElementById('orderChatbox');     // Icon chat / nút mở xem đơn mới
    const badge = document.getElementById('orderBadge');         // Hiện số lượng đơn chưa đọc
    const popup = document.getElementById('orderPopup');         // Popup hiển thị đơn ngay khi đến
    const popupContent = document.getElementById('popupContent'); // Nội dung popup
    const notification = document.getElementById('orderNotification'); // Thông báo đầu màn hình
    const orderCount = document.getElementById('orderCount');    // Nội dung số lượng đơn trong thông báo
    const viewDetail = document.getElementById('viewDetail');    // Nút xem chi tiết hóa đơn

    // ============================
    // KHÔI PHỤC DANH SÁCH ĐƠN CHƯA XEM TỪ LOCALSTORAGE
    // ============================
    let orderQueue = JSON.parse(localStorage.getItem("orderQueue") || "[]");

    function updateBadge() {
        // Hiển thị số đơn chưa xem dưới dạng badge đỏ
        if (orderQueue.length > 0) {
            badge.textContent = orderQueue.length;
            badge.style.display = "flex";
        } else {
            badge.style.display = "none";
        }
    }

    // Lưu Queue vào LocalStorage
    function saveQueue() {
        localStorage.setItem("orderQueue", JSON.stringify(orderQueue));
    }

    updateBadge();

    // ============================
    // KẾT NỐI SOCKET.IO TỚI SERVER REALTIME
    // ============================
    const socket = io("http://localhost:3000", {
        transports: ["polling", "websocket"] // fallback để đảm bảo kết nối luôn chạy
    });

    // ============================
    // SỰ KIỆN: NHẬN ĐƠN HÀNG MỚI TỪ SOCKET.IO
    // ============================
    socket.on("newOrder", (order) => {

        // Thêm vào hàng đợi (mục đích để hiện badge)
        orderQueue.push(order);
        saveQueue();
        updateBadge();
        pulseBadge(); // Hiệu ứng nhịp nháy khi có đơn mới

        // Lưu ID đơn vào localStorage để highlight bên trang update-invoice
        let newInvoices = JSON.parse(localStorage.getItem("newInvoices") || "[]");
        if (!Array.isArray(newInvoices)) newInvoices = [];
        if (!newInvoices.includes(order.id)) {
            newInvoices.push(order.id);
            localStorage.setItem("newInvoices", JSON.stringify(newInvoices));
        }

        // Hiện notification nhỏ ở đầu màn hình
        orderCount.textContent = `Bạn có ${orderQueue.length} đơn hàng mới!`;
        showNotification();

        // Hiển thị nội dung chi tiết của popup đơn hàng
        popupContent.innerHTML = `
            <p><strong>Mã đơn:</strong> ${order.id}</p>
            <p><strong>Khách hàng:</strong> ${order.name}</p>
            <p><strong>Điện thoại:</strong> ${order.phone}</p>
            <p><strong>Địa chỉ:</strong> ${order.address}</p>
            <p><strong>Ngày đặt:</strong> ${order.created}</p>
            <p><strong>Tổng tiền:</strong> ${Number(order.total).toLocaleString()} đ</p>
        `;
    });

    // ============================
    // HÀM XÓA TRẠNG THÁI CHƯA ĐỌC
    // ============================
    function clearUnread() {
        orderQueue = [];
        saveQueue();
        updateBadge();
    }

    // ============================
    // CLICK XEM CHI TIẾT — CHUYỂN TRANG update-invoice
    // ============================
    viewDetail.addEventListener("click", () => {
        clearUnread();
        window.location.href = "index.php?n=update-invoice";
    });

    chatbox.addEventListener("click", () => {
        clearUnread();
        window.location.href = "index.php?n=update-invoice";
    });

    // ============================
    // THÔNG BÁO BUNG TỪ TRÊN XUỐNG
    // ============================
    function showNotification() {
        notification.style.display = "block";
        notification.classList.remove("animate__bounceInDown");
        
        // Reset animation → bắt buộc để chạy lại animation
        void notification.offsetWidth;

        notification.classList.add("animate__bounceInDown");
    }

    function hideNotification() {
        notification.style.display = "none";
    }

    notification.addEventListener("animationend", () => {
        setTimeout(hideNotification, 1500); // Tự tắt sau 1.5 giây
    });

    // ============================
    // HIỆU ỨNG NHỊP TIM CHO BADGE KHI CÓ ĐƠN MỚI
    // ============================
    function pulseBadge() {
        badge.animate(
            [
                { transform: "scale(1)" },
                { transform: "scale(1.3)" },
                { transform: "scale(1)" }
            ],
            {
                duration: 800,
                iterations: 1
            }
        );
    }

    // ============================
    // ĐÓNG POPUP
    // ============================
    window.closeOrderPopup = function () {
        popup.style.display = "none";
    };
});
