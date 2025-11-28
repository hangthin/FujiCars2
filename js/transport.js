// View/js/vanchuyen.js

const unqOverlay = document.getElementById('unqOverlay_23');
const unqSpinner = document.getElementById('unqSpinner_23');
const unqCheck = document.getElementById('unqCheck_23');
const unqError = document.getElementById('unqError_23');
const unqTitle = document.getElementById('unqMsgTitle_23');
const unqText = document.getElementById('unqMsgText_23');

function unqShowLoadingOverlay() {
    unqOverlay.style.display = 'flex';
    unqSpinner.style.display = 'block';
    unqCheck.style.display = 'none';
    unqError.style.display = 'none';
    unqTitle.textContent = 'Đang xử lý...';
    unqText.textContent = 'Vui lòng chờ trong giây lát';
}

function unqShowOverlayResult(success, message) {
    unqSpinner.style.display = 'none';
    if (success) {
        unqCheck.style.display = 'block';
        unqError.style.display = 'none';
        unqCheck.classList.remove('unq_animate_stroke_23'); void unqCheck.offsetWidth;
        unqCheck.classList.add('unq_animate_stroke_23');
        unqTitle.textContent = 'Thành công';
    } else {
        unqCheck.style.display = 'none';
        unqError.style.display = 'block';
        unqError.classList.remove('unq_animate_stroke_23'); void unqError.offsetWidth;
        unqError.classList.add('unq_animate_stroke_23');
        unqTitle.textContent = 'Thất bại';
    }
    unqText.textContent = message;
    setTimeout(() => unqOverlay.style.display = 'none', 1500);
}

// Nếu có message từ PHP
if (typeof VANCHUYEN_MESSAGE !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        unqShowLoadingOverlay();
        setTimeout(() => {
            unqShowOverlayResult(VANCHUYEN_ISERROR === false, VANCHUYEN_MESSAGE);
        }, 800);
    });
}
