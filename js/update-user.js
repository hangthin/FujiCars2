// ===== IN DANH SÁCH =====
function nxuPrintTable() {
    let printContents = document.querySelector('.nxu_tbl').outerHTML;

    let win = window.open('', '', 'width=1000,height=700');
    win.document.write(`
        <html>
        <head>
            <title>Danh sách người dùng</title>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-family: Arial, sans-serif;
                    font-size: 14px;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background: #ddd;
                }
                h2 {
                    text-align: center;
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <h2>DANH SÁCH NGƯỜI DÙNG</h2>
            ${printContents}
        </body>
        </html>
    `);

    win.document.close();
    win.focus();
    win.print();
    win.close();
}

// ===== CẬP NHẬT DANH SÁCH =====
function nxuEditRow(user) {
    document.getElementById('nxuId').value = user.ID || '';
    document.getElementById('nxuTenTK').value = user.TenTK || '';
    document.getElementById('nxuMatKhau').value = '';
    document.getElementById('nxuQuyen').value = user.Quyen || '';
    document.getElementById('nxuDiaChi').value = user.DiaChi || '';
    document.getElementById('nxuPhone').value = user.phone || '';
    document.getElementById('nxuEmail').value = user.email || '';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ===== OVERLAY =====
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

// ===== LỌC DANH SÁCH =====
const nxuSearchInput = document.getElementById('nxuSearchInput');
const nxuBtnReset = document.getElementById('nxuBtnReset');
const nxuTable = document.querySelector('.nxu_tbl tbody');

function nxuFilterTable() {
    const filter = nxuSearchInput.value.toLowerCase();
    nxuTable.querySelectorAll('tr').forEach(tr => {
        const txt = tr.children[1].textContent.toLowerCase();
        tr.style.display = txt.includes(filter) ? '' : 'none';
    });
}

nxuSearchInput.addEventListener('input', nxuFilterTable);

nxuBtnReset.addEventListener('click', () => {
    document.getElementById('nxuUserForm').reset();
    document.getElementById('nxuId').value = '';
    nxuSearchInput.value = '';
    nxuFilterTable();
});
