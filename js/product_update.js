// ===== FILL FORM =====
function nxFillForm(row){
    const c = row.cells;
    document.getElementById("ID").value = c[0].innerText.trim();
    document.getElementById("TenSP").value = c[1].innerText.trim();
    document.getElementById("MoTa").value = c[2].innerText.trim();
    document.getElementById("NgayCapNhat").value = c[3].innerText.trim();
    document.getElementById("HinhAnh").value = c[4].innerText.trim();
    document.getElementById("LoaiSP").value = c[5].innerText.trim();
    document.getElementById("Gia").value = c[6].innerText.trim();
    document.getElementById("SoLuong").value = c[7].innerText.trim();
    document.getElementById("NhienLieu").value = c[8].innerText.trim();
    document.getElementById("XuatXu").value = c[9].innerText.trim();

    const src = c[4].innerText.trim();
    if(src) document.getElementById("PreviewImg").src = 
        src.startsWith("http") ? src : "View/img/SP/" + src;
}

// ===== CLICK ROW TABLE =====
document.querySelectorAll('#productTable tr:not(:first-child)').forEach(tr=>{
    tr.addEventListener('click',()=> nxFillForm(tr));
});

// ===== PREVIEW IMAGE =====
const fileInput = document.getElementById("HinhAnhFile");
const urlInput = document.getElementById("HinhAnhURL");
const previewImg = document.getElementById("PreviewImg");

fileInput.addEventListener("change", e=>{
    if(e.target.files && e.target.files[0]){
        const reader = new FileReader();
        reader.onload = ev => previewImg.src = ev.target.result;
        reader.readAsDataURL(e.target.files[0]);
        urlInput.value = '';
    }
});

urlInput.addEventListener("input", e=>{
    if(e.target.value){
        previewImg.src = e.target.value;
        fileInput.value = '';
    }
});

// ===== DELETE AJAX (DELEGATION) =====
document.getElementById('productTable').addEventListener('click', e=>{
    if(e.target.closest('.btnDelete')){
        const btn = e.target.closest('.btnDelete');
        const id = btn.dataset.id;
        if(!confirm("Bạn chắc chắn muốn xóa sản phẩm này?")) return;

        const overlay = document.getElementById('successEffect');
        const check = overlay.querySelector('.checkIcon');
        const text = overlay.querySelector('.textSuccess');
        const spin = overlay.querySelector('.spinnerEffect');

        overlay.style.display = 'flex';
        spin.style.display = 'block';
        check.style.display = 'none';
        text.style.display = 'none';

        fetch('Controller/handle-admin/delete_product.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'id='+encodeURIComponent(id)
        }).then(res=>res.text()).then(data=>{
            spin.style.display='none';
            if(data.trim()==='success'){
                btn.closest('tr').remove();
                check.style.display='block';
                text.innerText='Xóa sản phẩm thành công!';
                text.style.display='block';
                setTimeout(()=>overlay.style.display='none',2000);
            } else {
                text.style.display='block';
                text.innerText='Xóa thất bại: '+data;
            }
        }).catch(err=>{
            spin.style.display='none';
            alert("Lỗi JS: "+err);
        });
    }
});

// ===== SEARCH REALTIME =====
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.querySelector('.nxadmin-search');
  const tableRows = document.querySelectorAll('.nxadmin-table tr:not(:first-child)');
  
  if (searchInput) {
    searchInput.addEventListener('keyup', () => {
      const keyword = searchInput.value.toLowerCase().trim();
      tableRows.forEach(row => {
        const tenSP = row.cells[1].innerText.toLowerCase();
        row.style.display = tenSP.includes(keyword) ? '' : 'none';
      });
    });
  }
});

// ===== FORMAT GIÁ =====
const giaInput = document.getElementById('Gia');
function formatNumber(value){
    return value.replace(/\D/g,'').replace(/\B(?=(\d{3})+(?!\d))/g,'.');
}
if(giaInput){
    window.addEventListener('DOMContentLoaded', ()=> giaInput.value = formatNumber(giaInput.value));
    giaInput.addEventListener('input', function(){
        const cursor = giaInput.selectionStart;
        const oldLength = giaInput.value.length;
        giaInput.value = formatNumber(giaInput.value);
        const newLength = giaInput.value.length;
        giaInput.selectionEnd = cursor + (newLength - oldLength);
    });
}

// ===== SUBMIT REMOVE DOTS =====
const productForm = document.getElementById('productForm');
if(productForm){
    productForm.addEventListener('submit', ()=>{
        giaInput.value = giaInput.value.replace(/\./g,'');
    });
}


// ===== SUBMIT FORM + OVERLAY =====
if(productForm){
    productForm.addEventListener('submit', function(e){
        // xóa dấu chấm khỏi giá trước submit
        if(giaInput) giaInput.value = giaInput.value.replace(/\./g,'');

        // hiển thị overlay
        const overlay = document.getElementById('successEffect');
        const spinner = overlay.querySelector('.spinnerEffect');
        const check = overlay.querySelector('.checkIcon');
        const text = overlay.querySelector('.textSuccess');

        overlay.style.display = 'flex';
        spinner.style.display = 'block';
        check.style.display = 'none';
        text.style.display = 'none';
        text.innerText = "Cập nhật sản phẩm thành công!";

        // animation spinner → checkmark
        setTimeout(()=>{
            spinner.style.display = 'none';
            check.style.display = 'block';
            text.style.display = 'block';
        }, 1500);

        // đóng overlay sau 3 giây và submit thật
        setTimeout(()=>{
            overlay.style.display = 'none';
            productForm.submit(); // submit thật
        }, 3000);

        e.preventDefault(); // ngăn submit ngay lập tức
    });
}



document.addEventListener('DOMContentLoaded', function() {
    const btnHuy = document.getElementById('btnHuy');

    btnHuy.addEventListener('click', function() {
        // Reset các input text và hidden
        ['ID','TenSP','Gia','SoLuong','HinhAnh','HinhAnhURL','NgayCapNhat'].forEach(id => {
            const el = document.getElementById(id);
            if(el) el.value = '';
        });

        // Reset các select về option đầu tiên
        ['LoaiSP','NhienLieu','XuatXu','MoTa'].forEach(id => {
            const el = document.getElementById(id);
            if(el) el.selectedIndex = 0;
        });

        // Reset preview hình
        const preview = document.getElementById('PreviewImg');
        if(preview) preview.src = 'View/img/SP/mau.png';

        // Xóa file input hiện tại
        const fileInput = document.getElementById('HinhAnhFile');
        if(fileInput) fileInput.value = '';

        // Nếu muốn reset overlay/ thông báo (nếu có)
        const overlay = document.getElementById('nxOverlay');
        if(overlay) overlay.style.display = 'none';
    });
});








