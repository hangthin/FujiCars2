// Chức năng: Xử lý giao diện trang cập nhật hóa đơn
// - Click vào dòng để đổ dữ liệu lên form sửa
// - Chọn nhiều hóa đơn để xác nhận / xóa
// - Lọc hóa đơn theo tên
// - Highlight hóa đơn mới thêm
document.addEventListener("DOMContentLoaded", () => {
    // ==========================
    // Lấy các phần tử DOM cần dùng
    // ==========================
    const tableBody = document.querySelector("#invoiceTableNX tbody");   // Body của bảng hóa đơn
    const selectAll = document.getElementById("selectAllNX");            // Checkbox chọn tất cả
    const multiForm = document.getElementById("multiActionForm");        // Form xử lý nhiều hóa đơn
    const multiHiddenInputs = document.getElementById("multiHiddenInputs"); // Nơi sinh input ID ẩn
    const invoiceForm = document.getElementById('invoiceFormNX');        // Form thêm/sửa hóa đơn
    const submitButton = document.getElementById('submitButtonNX');      // Nút thêm/sửa

    // ================================================
    // CLICK VÀO DÒNG BẢNG → ĐỔ DỮ LIỆU LÊN FORM ĐỂ SỬA
    // ================================================
    tableBody.querySelectorAll("tr").forEach(row => {
        row.addEventListener("click", (e) => {

            // Nếu click vào checkbox thì bỏ qua — tránh bật chế độ sửa
            if (e.target.tagName.toLowerCase() === 'input' && e.target.type === 'checkbox') 
                return;

            // ===== ĐỔ DỮ LIỆU LÊN FORM =====
            document.getElementById('invoiceIDNX').value = row.dataset.id;
            document.getElementById('invoiceNameNX').value = row.dataset.name;
            document.getElementById('invoicePhoneNX').value = row.dataset.phone;
            document.getElementById('invoiceAddressNX').value = row.dataset.address;
            document.getElementById('invoiceDateReceiveNX').value = row.dataset.datereceive;

            // Xử lý giờ: cắt bớt giây (HH:MM:SS -> HH:MM)
            let timeValue = row.dataset.timereceive;
            if (timeValue.includes(':')) 
                timeValue = timeValue.substring(0, 5);
            document.getElementById('invoiceTimeReceiveNX').value = timeValue;

            // Chọn đúng phương thức thanh toán
            const methodSelect = document.getElementById('invoiceMethodNX');
            for (let i = 0; i < methodSelect.options.length; i++) {
                if (methodSelect.options[i].value.trim() === row.dataset.method.trim()) {
                    methodSelect.selectedIndex = i;
                    break;
                }
            }

            document.getElementById('invoiceTotalPriceNX').value = row.dataset.total;

            // Chuyển nút "Thêm" thành "Sửa"
            submitButton.textContent = "Sửa hóa đơn";

            // Cuộn tới form cho dễ nhìn
            invoiceForm.scrollIntoView({ behavior: "smooth" });
        });
    });

    // ================================================
    // RESET FORM → MODE THÊM HÓA ĐƠN
    // ================================================
    invoiceForm.addEventListener("reset", () => {
        submitButton.textContent = "Thêm hóa đơn";
    });

    // ================================================
    // CHECKBOX CHỌN TẤT CẢ TRONG BẢNG
    // ================================================
    selectAll.addEventListener("change", () => {
        document.querySelectorAll(".selectNX")
            .forEach(cb => cb.checked = selectAll.checked);
    });

    // ================================================
    // TRƯỚC KHI SUBMIT FORM XỬ LÝ NHIỀU HÓA ĐƠN
    // Tự động tạo input hidden cho từng ID được chọn
    // ================================================
    multiForm.addEventListener("submit", (e) => {

        // Lấy danh sách ID từ những checkbox đang bật
        const selectedIds = Array.from(document.querySelectorAll(".selectNX"))
            .filter(cb => cb.checked)
            .map(cb => cb.closest("tr").dataset.id);

        // Nếu không chọn gì → báo lỗi + không submit
        if (selectedIds.length === 0) {
            alert("Vui lòng chọn ít nhất 1 hóa đơn!");
            e.preventDefault();
            return;
        }

        // Xóa input ẩn cũ
        multiHiddenInputs.innerHTML = "";

        // Tạo input hidden IDs[] cho từng ID
        selectedIds.forEach(id => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "IDs[]";
            input.value = id;
            multiHiddenInputs.appendChild(input);
        });
    });

    // ================================================
    // LỌC HÓA ĐƠN THEO TÊN KHÁCH HÀNG
    // ================================================
    const searchInputNX = document.getElementById('searchInputNX');
    searchInputNX.addEventListener('input', function () {
        const filter = this.value.toLowerCase();

        tableBody.querySelectorAll('tr').forEach(row => {
            const nameCell = row.cells[2]; // Cột Name
            row.style.display = nameCell.textContent.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    // ================================================
    // HIGHLIGHT ĐƠN MỚI (sau khi thêm)
    // newInsertedInvoiceID được PHP sinh ra
    // ================================================
    if (typeof newInsertedInvoiceID !== "undefined" && newInsertedInvoiceID > 0) {
        const newRow = tableBody.querySelector(`tr[data-id='${newInsertedInvoiceID}']`);

        // Chỉ highlight nếu đơn còn trạng thái "chờ xử lý"
        if (newRow && newRow.dataset.status == 0) {
            newRow.classList.add("highlight-new");
        }
    }

    // ================================================
    // NẾU ĐÃ NHẤN "Xác nhận" THÌ BỎ MÀU HIGHLIGHT
    // ================================================
    tableBody.querySelectorAll("button[name='sua']").forEach(btn => {
        btn.addEventListener("click", () => {
            const row = btn.closest("tr");
            row.classList.remove("highlight-new");
        });
    });
});
