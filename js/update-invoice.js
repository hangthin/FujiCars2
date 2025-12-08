// ===============================================================
// UPDATE INVOICE PAGE – FULL FUNCTIONAL VERSION (OPTIMIZED)
// ===============================================================

document.addEventListener("DOMContentLoaded", () => {

    // ==========================
    // DOM ELEMENTS
    // ==========================
    const tableBody = document.querySelector("#invoiceTableNX tbody");
    const statusFilter = document.getElementById("statusFilterNX");
    const searchInputNX = document.getElementById("searchInputNX");
    const selectAll = document.getElementById("selectAllNX");
    const multiForm = document.getElementById("multiActionForm");
    const multiHiddenInputs = document.getElementById("multiHiddenInputs");
    const invoiceForm = document.getElementById("invoiceFormNX");
    const submitButton = document.getElementById("submitButtonNX");

    // ================================
    // ÂM THANH ĐƠN HÀNG MỚI
    // ================================
    const newOrderSound = new Audio("View/sound/new-order.mp3");
    newOrderSound.volume = 1;

    function playNewOrderSound() {
        newOrderSound.currentTime = 0;
        newOrderSound.play().catch(() => {});
    }

    // ===============================================================
    // CLICK VÀO DÒNG → ĐỔ DỮ LIỆU LÊN FORM
    // ===============================================================
    tableBody.querySelectorAll("tr").forEach(row => {
        row.addEventListener("click", (e) => {
            if (e.target.tagName.toLowerCase() === 'input') return;

            const d = row.dataset;

            invoiceForm.querySelector("#invoiceIDNX").value = d.id;
            invoiceForm.querySelector("#invoiceNameNX").value = d.name;
            invoiceForm.querySelector("#invoicePhoneNX").value = d.phone;
            invoiceForm.querySelector("#invoiceAddressNX").value = d.address;
            invoiceForm.querySelector("#invoiceDateReceiveNX").value = d.datereceive;

            let timeValue = d.timereceive;
            if (timeValue?.includes(":")) timeValue = timeValue.substring(0, 5);
            invoiceForm.querySelector("#invoiceTimeReceiveNX").value = timeValue;

            invoiceForm.querySelector("#invoiceMethodNX").value = d.method;
            invoiceForm.querySelector("#invoiceTotalPriceNX").value = d.total;

            submitButton.textContent = "Sửa hóa đơn";
            invoiceForm.scrollIntoView({ behavior: "smooth" });
        });
    });

    // ===============================================================
    // RESET FORM → CHẾ ĐỘ THÊM
    // ===============================================================
    invoiceForm.addEventListener("reset", () => {
        submitButton.textContent = "Thêm hóa đơn";
    });

    // ===============================================================
    // CHỌN TẤT CẢ CHECKBOX
    // ===============================================================
    selectAll.addEventListener("change", () => {
        const checked = selectAll.checked;
        document.querySelectorAll(".selectNX").forEach(cb => cb.checked = checked);
    });

    // ===============================================================
    // SUBMIT NHIỀU HÓA ĐƠN
    // ===============================================================
    multiForm.addEventListener("submit", (e) => {
        const selected = [...document.querySelectorAll(".selectNX")]
            .filter(cb => cb.checked)
            .map(cb => cb.closest("tr").dataset.id);

        if (selected.length === 0) {
            alert("Vui lòng chọn ít nhất 1 hóa đơn!");
            e.preventDefault();
            return;
        }

        multiHiddenInputs.innerHTML = "";
        selected.forEach(id => {
            multiHiddenInputs.insertAdjacentHTML(
                "beforeend",
                `<input type="hidden" name="IDs[]" value="${id}">`
            );
        });
    });

    // ===============================================================
    // LỌC THEO TÊN
    // ===============================================================
    searchInputNX.addEventListener("input", () => {
        const filter = searchInputNX.value.toLowerCase();

        tableBody.querySelectorAll("tr").forEach(row => {
            const nameCell = row.cells[2]?.textContent?.toLowerCase() ?? "";
            row.style.display = nameCell.includes(filter) ? "" : "none";
        });
    });

    // ===============================================================
    // HIGHLIGHT HÓA ĐƠN MỚI TỪ PHP
    // ===============================================================
    if (typeof newInsertedInvoiceID !== "undefined" && newInsertedInvoiceID > 0) {
        const newRow = tableBody.querySelector(`tr[data-id="${newInsertedInvoiceID}"]`);
        if (newRow && newRow.dataset.status == "0") newRow.classList.add("highlight-new");
    }

    // ===============================================================
    // BỎ HIGHLIGHT KHI XÁC NHẬN
    // ===============================================================
    tableBody.querySelectorAll("button[name='sua']").forEach(btn => {
        btn.addEventListener("click", () => {
            btn.closest("tr").classList.remove("highlight-new");
        });
    });

    // ===============================================================
    // LỌC TRẠNG THÁI + AUTO NHẢY QUA CÁC TRANG
    // ===============================================================
    function applyStatusFilter() {
        const filterValue = statusFilter.value; // all | 0 | 1
        let shownItems = 0;

        tableBody.querySelectorAll("tr").forEach(row => {
            const match = (filterValue === "all" || row.dataset.status === filterValue);
            row.style.display = match ? "" : "none";
            if (match) shownItems++;
        });

        if (shownItems > 0 || filterValue === "all") return;

        // Nếu KHÔNG có dữ liệu → thử sang trang tiếp theo
        const url = new URL(window.location.href);
        const currentPage = parseInt(url.searchParams.get("page") || "1");

        for (let nextPage = currentPage + 1; nextPage <= TOTAL_PAGES; nextPage++) {
            window.location.href =
                `index.php?n=update-invoice&page=${nextPage}&status=${filterValue}`;
            return;
        }

        console.warn(">>> Không có trang nào chứa trạng thái này!");
    }

    statusFilter.addEventListener("change", applyStatusFilter);

    // ===============================================================
    // AUTO ÁP DỤNG LỌC TỪ URL (QUAN TRỌNG)
    // ===============================================================
    const url = new URL(window.location.href);
    const statusFromURL = url.searchParams.get("status");

    if (statusFromURL) {
        statusFilter.value = statusFromURL;
        applyStatusFilter();
    }

    // ===============================================================
    // REALTIME NEW ORDER
    // ===============================================================
    const socket = io("https://nodejs-53zg.onrender.com", {
        transports: ["websocket"],
        reconnection: true,
        reconnectionAttempts: Infinity,
        reconnectionDelay: 1200
    });

    socket.on("connect", () => {
        console.log(">> update-invoice realtime connected :", socket.id);
    });

    socket.on("newOrder", (order) => {
        playNewOrderSound();

        const tr = document.createElement("tr");
        tr.dataset.id = order.ID;
        tr.dataset.name = order.Name;
        tr.dataset.phone = order.Phone;
        tr.dataset.address = order.Address;
        tr.dataset.datereceive = order.DateReceive ?? "";
        tr.dataset.timereceive = order.TimeReceive ?? "";
        tr.dataset.method = order.Method;
        tr.dataset.total = order.TotalPrice;
        tr.dataset.status = "0";
        tr.classList.add("highlight-new");

        tr.innerHTML = `
            <td><input type="checkbox" class="selectNX"></td>
            <td>${order.ID}</td>
            <td>${order.Name}</td>
            <td>${order.Phone}</td>
            <td>${order.Address}</td>
            <td>${order.DateReceive ?? ""}</td>
            <td>${order.TimeReceive ?? ""}</td>
            <td>${order.Method}</td>
            <td><i class="fa-solid fa-hourglass-half" style="color:red"></i> Đang xử lý</td>
            <td>${Number(order.TotalPrice).toLocaleString()} VND</td>
            <td>${order.DateCreate ?? ""}</td>

            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="ID" value="${order.ID}">
                    <input type="hidden" name="Status" value="1">
                    <button type="submit" name="sua" class="btnedit">
                        <i class="fa-solid fa-check"></i> Xác nhận
                    </button>
                </form>

                <form method="POST" style="display:inline;">
                    <input type="hidden" name="ID" value="${order.ID}">
                    <button type="submit" name="xoa" class="btndel"
                        onclick="return confirm('Bạn chắc chắn muốn xóa?');">
                        <i class="fa-solid fa-trash"></i> Xóa
                    </button>
                </form>
            </td>
        `;

        tableBody.prepend(tr);

        tr.scrollIntoView({ behavior: "smooth", block: "center" });

        tr.animate(
            [
                { backgroundColor: "#fff3cd" },
                { backgroundColor: "#ffe8a1" },
                { backgroundColor: "#fff3cd" }
            ],
            { duration: 1200 }
        );
    });
});

// ===============================================================
// NÚT PRINT
// ===============================================================
document.getElementById("printButtonNX").addEventListener("click", () => {
    window.print();
});
