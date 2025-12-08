// update-invoice.js - Nhận realtime đơn hàng mới + âm thanh + banner

document.addEventListener("DOMContentLoaded", () => {

    // ======================================================
    // 🚀 AUTO UNLOCK AUDIO (Chrome / iPhone / Android)
    // ======================================================
    let audioAllowed = false;

    const unlocker = document.getElementById("audioUnlocker");

    if (unlocker) {
        unlocker.onplay = () => {
            audioAllowed = true;
            console.log("✔ Auto-Unlock âm thanh thành công");
            unlocker.muted = false; // cho phép phát tiếng về sau
        };

        // Chạy autoplay muted → unlock audio
        unlocker.play().catch(() => {
            console.warn("Autoplay bị chặn → sẽ fallback bằng click");
        });
    }

    // Fallback khi user click vào trang
    document.body.addEventListener("mousedown", () => {
        if (!audioAllowed) {
            audioAllowed = true;
            unlocker.muted = false;
            console.log("✔ Âm thanh đã được kích hoạt bằng click");
        }
    });

    document.body.addEventListener("touchstart", () => {
        if (!audioAllowed) {
            audioAllowed = true;
            unlocker.muted = false;
            console.log("✔ Âm thanh đã được kích hoạt bằng touch");
        }
    });


    // ============================
    // GIAO DIỆN
    // ============================
    const chatbox = document.getElementById('orderChatbox');
    const badge = document.getElementById('orderBadge');
    const notification = document.getElementById('orderNotification');
    const orderCount = document.getElementById('orderCount');
    const viewDetail = document.getElementById('viewDetail');


    // ============================
    // HÀNG ĐỢI ĐƠN MỚI
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
    // SOCKET.IO
    // ============================
    const socket = io("https://nodejs-53zg.onrender.com", {
        transports: ["websocket"],
        reconnection: true,
        reconnectionAttempts: Infinity,
        reconnectionDelay: 1000,
        secure: true
    });

    socket.on("connect", () => {
        console.log(">> Realtime connected:", socket.id);
    });

    socket.on("disconnect", () => {
        console.warn(">> Mất kết nối realtime. Đang reconnect...");
    });


    // ============================
    // 🔥 KHI CÓ ĐƠN MỚI
    // ============================
    socket.on("newOrder", (order) => {

        console.log("🔥 ĐƠN MỚI:", order);

        // =============================
        // 🔊 PHÁT ÂM THANH
        // =============================
        if (audioAllowed) {
            unlocker.currentTime = 0;
            unlocker.play().catch(err => console.warn("Không phát được:", err));
        } else {
            console.warn("⚠ Audio chưa unlock (trình duyệt chặn).");
        }

        // Thêm vào queue
        orderQueue.push(order);
        saveQueue();
        updateBadge();
        pulseBadge();

        // Lưu highlight
        const newInvoices = JSON.parse(localStorage.getItem("newInvoices") || "[]");
        if (!newInvoices.includes(order.ID)) {
            newInvoices.push(order.ID);
            localStorage.setItem("newInvoices", JSON.stringify(newInvoices));
        }

        // Banner báo đơn mới
        orderCount.textContent = `Bạn có ${orderQueue.length} đơn hàng mới!`;
        showNotification();
    });


    // ============================
    // BANNER THÔNG BÁO
    // ============================
    function showNotification() {
        notification.style.display = "block";

        notification.classList.remove("animate__bounceInDown");
        void notification.offsetWidth;
        notification.classList.add("animate__bounceInDown");

        setTimeout(() => {
            notification.style.display = "none";
        }, 2000);
    }


    // ============================
    // HIỆU ỨNG NHỊP TIM
    // ============================
    function pulseBadge() {
        badge.animate(
            [
                { transform: "scale(1)" },
                { transform: "scale(1.2)" },
                { transform: "scale(1)" }
            ],
            { duration: 500, iterations: 1 }
        );
    }


    // ============================
    // CHUYỂN TRANG UPDATE-INVOICE
    // ============================
    const clearUnread = () => {
        orderQueue = [];
        saveQueue();
        updateBadge();
    };

    const goToInvoice = () => {
        clearUnread();
        window.location.href = "index.php?n=update-invoice";
    };

    chatbox.addEventListener("click", goToInvoice);
    viewDetail.addEventListener("click", goToInvoice);

});
