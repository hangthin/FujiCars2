// update-invoice.js - Nhận realtime đơn hàng mới và hiển thị thông báo (Render Optimized)

document.addEventListener("DOMContentLoaded", () => {

    // ============================
    // PHẦN TỬ GIAO DIỆN
    // ============================
    const chatbox = document.getElementById('orderChatbox');
    const badge = document.getElementById('orderBadge');
    const popup = document.getElementById('orderPopup');
    const popupContent = document.getElementById('popupContent');
    const notification = document.getElementById('orderNotification');
    const orderCount = document.getElementById('orderCount');
    const viewDetail = document.getElementById('viewDetail');

    // ============================
    // HÀNG ĐỢI ĐƠN CHƯA XEM (LocalStorage)
    // ============================
    let orderQueue = JSON.parse(localStorage.getItem("orderQueue") || "[]");

    const saveQueue = () =>
        localStorage.setItem("orderQueue", JSON.stringify(orderQueue));

    const updateBadge = () => {
        if (orderQueue.length > 0) {
            badge.textContent = orderQueue.length;
            badge.style.display = "flex";
        } else {
            badge.style.display = "none";
        }
    };

    updateBadge();

    // ============================
    // SOCKET.IO (Render Optimized)
    // ============================

    const socket = io("https://nodejs-53zg.onrender.com", {
        transports: ["websocket"],        // BẮT BUỘC CHO RENDER FREE
        reconnection: true,
        reconnectionAttempts: Infinity,
        reconnectionDelay: 1000,
        secure: true
    });

    socket.on("connect", () => {
        console.log(">> Realtime connected:", socket.id);
    });

    socket.on("disconnect", () => {
        console.warn(">> Mất kết nối realtime. Đang thử reconnect...");
    });

    // ============================
    // SỰ KIỆN NHẬN ĐƠN MỚI
    // ============================
    socket.on("newOrder", (order) => {

    // Thêm đơn vào queue
    orderQueue.push(order);
    saveQueue();
    updateBadge();
    pulseBadge();

    // Lưu ID mới để highlight ở trang update-invoice
    const newInvoices = JSON.parse(localStorage.getItem("newInvoices") || "[]");
    if (!newInvoices.includes(order.ID)) {
        newInvoices.push(order.ID);
        localStorage.setItem("newInvoices", JSON.stringify(newInvoices));
    }

    // Thông báo nhỏ dạng banner
    orderCount.textContent = `Bạn có ${orderQueue.length} đơn hàng mới!`;
    showNotification();

    // ❌ KHÔNG HIỆN POPUP NỮA
    // popup.style.display = "block";
    // popupContent.innerHTML = "...";  // bỏ luôn
});


    // ============================
    // HÀM XÓA TRẠNG THÁI CHƯA ĐỌC
    // ============================
    const clearUnread = () => {
        orderQueue = [];
        saveQueue();
        updateBadge();
    };

    // ============================
    // CHUYỂN TRANG UPDATE-INVOICE
    // ============================
    const goToInvoice = () => {
        clearUnread();
        window.location.href = "index.php?n=update-invoice";
    };

    chatbox.addEventListener("click", goToInvoice);
    viewDetail.addEventListener("click", goToInvoice);

    // ============================
    // THÔNG BÁO BUNG TỪ TRÊN XUỐNG
    // ============================
    function showNotification() {
        notification.style.display = "block";

        // Reset animation để chạy lại
        notification.classList.remove("animate__bounceInDown");
        void notification.offsetWidth;
        notification.classList.add("animate__bounceInDown");

        // Auto hide
        setTimeout(() => { notification.style.display = "none"; }, 1800);
    }

    // ============================
    // HIỆU ỨNG NHỊP TIM CHO BADGE
    // ============================
    function pulseBadge() {
        badge.animate(
            [
                { transform: "scale(1)" },
                { transform: "scale(1.25)" },
                { transform: "scale(1)" }
            ],
            { duration: 500, iterations: 1 }
        );
    }

    // ============================
    // ĐÓNG POPUP
    // ============================
    window.closeOrderPopup = () => {
        popup.style.display = "none";
    };
});
