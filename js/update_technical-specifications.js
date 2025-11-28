// ==== JS overlay ====
const nxuOverlay = document.getElementById('nxuOverlay');
const nxuSpinner = document.getElementById('nxuSpinner');
const nxuCheck = document.getElementById('nxuCheck');
const nxuError = document.getElementById('nxuError');
const nxuTitle = document.getElementById('nxuMsgTitle');
const nxuText = document.getElementById('nxuMsgText');

function nxuShowLoadingOverlay() {
    nxuOverlay.style.display = 'flex';
    nxuSpinner.style.display = 'block';
    nxuCheck.style.display = 'none';
    nxuError.style.display = 'none';
    nxuTitle.textContent = 'Đang xử lý...';
    nxuText.textContent = 'Vui lòng chờ trong giây lát';
}

function nxuShowOverlayResult(success, message) {
    nxuSpinner.style.display = 'none';
    if(success) {
        nxuCheck.style.display = 'block';
        nxuError.style.display = 'none';
        nxuCheck.classList.remove('nxu_animate-stroke');
        void nxuCheck.offsetWidth;
        nxuCheck.classList.add('nxu_animate-stroke');
        nxuTitle.textContent = 'Thành công';
    } else {
        nxuCheck.style.display = 'none';
        nxuError.style.display = 'block';
        nxuError.classList.remove('nxu_animate-stroke');
        void nxuError.offsetWidth;
        nxuError.classList.add('nxu_animate-stroke');
        nxuTitle.textContent = 'Thất bại';
    }
    nxuText.textContent = message;
    setTimeout(() => nxuOverlay.style.display = 'none', 1500);
}

// ==== JS hỗ trợ edit row ====
function editRow(data){
    document.getElementById('id').value = data.ID;
    document.getElementById('TenSP').value = data.TenSP;
    document.getElementById('MoTa').value = data.MoTa;
    document.getElementById('LoaiSP').value = data.LoaiSP;
    document.getElementById('Gia').value = data.Gia;
    document.getElementById('SoLuong').value = data.SoLuong;
    document.getElementById('NhienLieu').value = data.NhienLieu;
    document.getElementById('XuatXu').value = data.XuatXu;
    document.getElementById('HinhAnh').value = data.HinhAnh;
    document.getElementById('PreviewImg').src = data.HinhAnh || '';
    document.getElementById('CongSuat').value = data.CongSuat;
    document.getElementById('HopSo').value = data.HopSo;
    document.getElementById('TangToc').value = data.TangToc;
    document.getElementById('TocDoToiDa').value = data.TocDoToiDa;
    document.getElementById('TrongLuong').value = data.TrongLuong;
}

// ==== JS preview ảnh ====
document.getElementById('HinhAnhFile').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(ev){
            document.getElementById('PreviewImg').src = ev.target.result;
            document.getElementById('HinhAnh').value = file.name;
        }
        reader.readAsDataURL(file);
    }
});

function resetForm(){
    document.getElementById('productForm').reset();
    document.getElementById('PreviewImg').src = '';
}



// ==== JS tìm kiếm realtime ====
const searchInput = document.querySelector('input[name="search"]');
searchInput.addEventListener('input', function(){
    const val = this.value.trim().toLowerCase();
    document.querySelectorAll('.tableData tbody tr').forEach(tr=>{
        const name = tr.children[1].textContent.toLowerCase();
        const type = tr.children[3].textContent.toLowerCase();
        if(name.includes(val) || type.includes(val)){
            tr.style.display = '';
        } else {
            tr.style.display = 'none';
        }
    });
});
// ==== JS in danh sách ====
function printTable(){
    const table = document.querySelector('.tableData').outerHTML;
    const style = `
        <style>
            body { font-family: "Segoe UI", sans-serif; color: #000; background: #fff; }
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #333; padding: 8px; text-align: center; }
            th { background: #ff2e2e; color: #fff; }
            tr:nth-child(even) { background: #f2f2f2; }
        </style>
    `;
    const win = window.open('', '', 'width=1200,height=800');
    win.document.write('<h2 style="text-align:center;">Danh sách sản phẩm</h2>');
    win.document.write(style + table);
    win.document.close();
    win.focus();
    win.print();
}





function deleteCurrentProduct(){
    const id = document.getElementById('id').value;

    if (!id || id == "0") {
        nxuShowOverlayResult(false, "Bạn chưa chọn sản phẩm để xóa!");
        return;
    }

    if (!confirm("Bạn chắc chắn muốn xóa sản phẩm này?")) return;

    nxuShowLoadingOverlay();

    fetch("", {
        method: "POST",
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: "xoa=1&ID=" + encodeURIComponent(id)
    })
    .then(res => res.text())
    .then(() => {
        nxuShowOverlayResult(true, "Đã xóa sản phẩm!");

        // Xóa hàng khỏi bảng theo ID
        const rows = document.querySelectorAll('.tableData tbody tr');
        rows.forEach(tr=>{
            if(tr.children[0].textContent == id){
                tr.remove();
            }
        });

        resetForm();
    })
    .catch(err => {
        nxuShowOverlayResult(false, "Lỗi xóa: " + err);
    });
}






