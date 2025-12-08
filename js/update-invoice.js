// Chức năng: Xử lý giao diện trang cập nhật hóa đơn
// - Click vào dòng để đổ dữ liệu lên form sửa
// - Chọn nhiều hóa đơn để xác nhận / xóa
// - Lọc hóa đơn theo tên
// - Highlight hóa đơn mới thêm (PHP + Realtime)
document.addEventListener("DOMContentLoaded", () => {

    // ==========================
    // DOM Elements
    // ==========================
    const tableBody = document.querySelector("#invoiceTableNX tbody");
    const selectAll = document.getElementById("selectAllNX");
    const multiForm = document.getElementById("multiActionForm");
    const multiHiddenInputs = document.getElementById("multiHiddenInputs");
    const invoiceForm = document.getElementById('invoiceFormNX');
    const submitButton = document.getElementById('submitButtonNX');

    // ================================
    // ÂM THANH THÔNG BÁO ĐƠN HÀNG MỚI
    // ================================
    const newOrderSound = new Audio("View/sound/new-order.mp3");
    newOrderSound.volume = 1; // chỉnh volume

    // ================================
    // CLICK VÀO DÒNG → LOAD FORM SỬA
    // ================================
    tableBody.querySelectorAll("tr").forEach(row => {
        row.addEventListener("click", (e) => {

            if (e.target.tagName.toLowerCase() === 'input' && e.target.type === 'checkbox')
                return;

            document.getElementById('invoiceIDNX').value = row.dataset.id;
            document.getElementById('invoiceNameNX').value = row.dataset.name;
            document.getElementById('invoicePhoneNX').value = row.dataset.phone;
            document.getElementById('invoiceAddressNX').value = row.dataset.address;
            document.getElementById('invoiceDateReceiveNX').value = row.dataset.datereceive;

            let timeValue = row.dataset.timereceive;
            if (timeValue.includes(':'))
                timeValue = timeValue.substring(0, 5);
            document.getElementById('invoiceTimeReceiveNX').value = timeValue;

            const methodSelect = document.getElementById('invoiceMethodNX');
            for (let i = 0; i < methodSelect.options.length; i++) {
                if (methodSelect.options[i].value.trim() === row.dataset.method.trim()) {
                    methodSelect.selectedIndex = i;
                    break;
                }
            }

            document.getElementById('invoiceTotalPriceNX').value = row.dataset.total;

            submitButton.textContent = "Sửa hóa đơn";
            invoiceForm.scrollIntoView({ behavior: "smooth" });
        });
    });

    // ================================
    // RESET FORM → MODE THÊM
    // ================================
    invoiceForm.addEventListener("reset", () => {
        submitButton.textContent = "Thêm hóa đơn";
    });

    // ================================
    // CHECKBOX CHỌN TẤT CẢ
    // ================================
    selectAll.addEventListener("change", () => {
        document.querySelectorAll(".selectNX")
            .forEach(cb => cb.checked = selectAll.checked);
    });

    // ======================================================
    // XỬ LÝ NHIỀU HÓA ĐƠN → TẠO INPUT HIDDEN IDs[]
    // ======================================================
    multiForm.addEventListener("submit", (e) => {

        const selectedIds = Array.from(document.querySelectorAll(".selectNX"))
            .filter(cb => cb.checked)
            .map(cb => cb.closest("tr").dataset.id);

        if (selectedIds.length === 0) {
            alert("Vui lòng chọn ít nhất 1 hóa đơn!");
            e.preventDefault();
            return;
        }

        multiHiddenInputs.innerHTML = "";

        selectedIds.forEach(id => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "IDs[]";
            input.value = id;
            multiHiddenInputs.appendChild(input);
        });
    });

    // ================================
    // LỌC THEO TÊN
    // ================================
    const searchInputNX = document.getElementById('searchInputNX');
    searchInputNX.addEventListener('input', function () {
        const filter = this.value.toLowerCase();

        tableBody.querySelectorAll('tr').forEach(row => {
            const nameCell = row.cells[2];
            row.style.display = nameCell.textContent.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    // ================================
    // HIGHLIGHT ĐƠN MỚI TỪ PHP
    // ================================
    if (typeof newInsertedInvoiceID !== "undefined" && newInsertedInvoiceID > 0) {
        const newRow = tableBody.querySelector(`tr[data-id='${newInsertedInvoiceID}']`);
        if (newRow && newRow.dataset.status == 0) {
            newRow.classList.add("highlight-new");
        }
    }

    // ================================
    // NHẤN "Xác nhận" → BỎ HIGHLIGHT
    // ================================
    tableBody.querySelectorAll("button[name='sua']").forEach(btn => {
        btn.addEventListener("click", () => {
            const row = btn.closest("tr");
            row.classList.remove("highlight-new");
        });
    });



    // =================================================================
    //  🔥 REALTIME: NHẬN ĐƠN MỚI TỪ NODE.JS + PHÁT ÂM THANH
    // =================================================================
    const socket = io("https://nodejs-53zg.onrender.com", {
        transports: ["websocket"],
        reconnection: true,
        reconnectionAttempts: Infinity,
        reconnectionDelay: 1200
    });

    socket.on("connect", () => {
        console.log(">> update-invoice: realtime connected", socket.id);
    });

    socket.on("newOrder", (order) => {
        console.log(">> Realtime: thêm hóa đơn vào bảng:", order);

        // 🔊 PHÁT ÂM THANH
        newOrderSound.play().catch(()=>{});

        // 🔥 TẠO DÒNG MỚI
        const tr = document.createElement("tr");
        tr.dataset.id = order.ID;
        tr.dataset.name = order.Name;
        tr.dataset.phone = order.Phone;
        tr.dataset.address = order.Address;
        tr.dataset.datereceive = order.DateReceive ?? "";
        tr.dataset.timereceive = order.TimeReceive ?? "";
        tr.dataset.method = order.Method;
        tr.dataset.total = order.TotalPrice;
        tr.dataset.status = 0;
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
                <div class="btncolstyle">
                    <form method="POST" style="margin:0;">
                        <input type="hidden" name="ID" value="${order.ID}">
                        <input type="hidden" name="Status" value="1">
                        <button type="submit" name="sua" class="btnedit">
                            <i class="fa-solid fa-check"></i> Xác nhận
                        </button>
                    </form>
                    <form method="POST" style="margin:0;">
                        <input type="hidden" name="ID" value="${order.ID}">
                        <button type="submit" name="xoa" class="btndel">
                            <i class="fa-solid fa-trash"></i> Xóa
                        </button>
                    </form>
                </div>
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

}); // END DOM READY



// =============================
// NÚT PRINT
// =============================
document.getElementById('printButtonNX').addEventListener('click', function() {
    const table = document.getElementById('invoiceTableNX');
    const newWin = window.open('', '', 'width=1200,height=800');

    newWin.document.write('<html><head><title>In danh sách hóa đơn</title>');
    newWin.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">');
    newWin.document.write('<style>table{width:100%;border-collapse:collapse;} th, td{border:1px solid #ccc;padding:8px;text-align:center;} th{background:#f2f2f2;}</style>');
    newWin.document.write('</head><body>');
    newWin.document.write('<h2>Danh sách hóa đơn</h2>');
    newWin.document.write(table.outerHTML);
    newWin.document.write('</body></html>');

    newWin.document.close();
    newWin.focus();
    newWin.print();
    newWin.close();
});
