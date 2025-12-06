// DOM Elements
const specForm = document.getElementById('specForm');
const SanPhamID = document.getElementById('SanPhamID');
const LoaiNhienLieu = document.getElementById('LoaiNhienLieu');
const CongSuatHP = document.getElementById('CongSuatHP');
const HopSo = document.getElementById('HopSo');
const TangToc = document.getElementById('TangToc');
const TocDoToiDa = document.getElementById('TocDoToiDa');
const TrongLuong = document.getElementById('TrongLuong');
const ChoNgoi = document.getElementById('ChoNgoi');

function showMessage(text, type){
    const box = document.getElementById('msgBox');
    box.textContent = text;
    box.className = 'ms882 ' + type;
    box.style.display = 'block';
    setTimeout(()=> box.style.display='none', 2000);
}

function selectCar(el){
    document.querySelectorAll('.qa882').forEach(i=>i.classList.remove('active'));
    el.classList.add('active');
    const id = el.dataset.id;
    if(!id) return;

    const specDiv = el.querySelector('.ks400');
    if(specDiv){
        LoaiNhienLieu.value = specDiv.querySelector('small:nth-child(1)')?.textContent.replace('Loại NL: ','') || '';
        CongSuatHP.value = specDiv.querySelector('small:nth-child(2)')?.textContent.replace('Công suất: ','').replace(' HP','') || '';
        HopSo.value = specDiv.querySelector('small:nth-child(3)')?.textContent.replace('Hộp số: ','') || '';
        TangToc.value = specDiv.querySelector('small:nth-child(4)')?.textContent.replace('Tăng tốc: ','').replace(' s','') || '';
        TocDoToiDa.value = specDiv.querySelector('small:nth-child(5)')?.textContent.replace('Tốc độ tối đa: ','').replace(' km/h','') || '';
        TrongLuong.value = specDiv.querySelector('small:nth-child(6)')?.textContent.replace('Trọng lượng: ','').replace(' kg','') || '';
        ChoNgoi.value = specDiv.querySelector('small:nth-child(7)')?.textContent.replace('Số chỗ: ','') || '';
        SanPhamID.value = id;
        return;
    }

    fetch('index.php?n=technical_specifications&ajax=get_spec&id=' + id)
    .then(r=>r.json())
    .then(d=>{
        if(!d || !d.SanPhamID) return;
        SanPhamID.value = d.SanPhamID || '';
        LoaiNhienLieu.value = d.LoaiNhienLieu || '';
        CongSuatHP.value = d.CongSuatHP || '';
        HopSo.value = d.HopSo || '';
        TangToc.value = d.TangToc || '';
        TocDoToiDa.value = d.TocDoToiDa || '';
        TrongLuong.value = d.TrongLuong || '';
        ChoNgoi.value = d.ChoNgoi || '';
    });
}

document.getElementById('btnHuy').onclick = function(){
    specForm.reset();
    SanPhamID.value = '';
    document.querySelectorAll('.qa882').forEach(i=>i.classList.remove('active'));
}

document.getElementById('btnLuu').onclick = function(){
    if(!SanPhamID.value){
        showMessage('Vui lòng chọn xe','error');
        return;
    }

    const fd = new FormData(specForm);
    const required = ['SanPhamID','LoaiNhienLieu','CongSuatHP','HopSo','TangToc','TocDoToiDa','TrongLuong','ChoNgoi'];
    for(const f of required){
        if(!fd.get(f).trim()){
            showMessage('Không được để trống','error');
            return;
        }
    }

    fetch('index.php?n=technical_specifications&ajax=save_spec', {
    method:'POST',
    body: fd
})    .then(r=>r.json())
    .then(d=>{
        showMessage(d.message, d.status);
        if(d.status==='success'){
            const activeCar = document.querySelector('.qa882.active');
            if(!activeCar) return;

            let carSpecDiv = activeCar.querySelector('.ks400');
            const html = `
                <small>Loại NL: ${LoaiNhienLieu.value}</small>
                <small>Công suất: ${CongSuatHP.value} HP</small>
                <small>Hộp số: ${HopSo.value}</small>
                <small>Tăng tốc: ${TangToc.value} s</small>
                <small>Tốc độ tối đa: ${TocDoToiDa.value} km/h</small>
                <small>Trọng lượng: ${TrongLuong.value} kg</small>
                <small>Số chỗ: ${ChoNgoi.value}</small>
            `;
            if(!carSpecDiv){
                carSpecDiv = document.createElement('div');
                carSpecDiv.className = 'ks400';
                activeCar.appendChild(carSpecDiv);
            }
            carSpecDiv.innerHTML = html;
        }
    })
    .catch(err=>{
        console.error(err);
        showMessage('Lỗi khi lưu dữ liệu','error');
    });
};

document.getElementById('searchCar').oninput = function(){
    const k = this.value.toLowerCase();
    document.querySelectorAll('.qa882').forEach(i=>{
        i.style.display = i.dataset.name.toLowerCase().includes(k) ? 'inline-block' : 'none';
    });
};