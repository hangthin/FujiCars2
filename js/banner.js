// =================== BANNER CAROUSEL ===================
let slideIndex = 0;
const slides = document.querySelectorAll(".carousel .slide");
showSlide(slideIndex);

// Chuyển slide thủ công khi bấm nút ❮ ❯
function changeSlide(n) {
  slideIndex += n;
  if (slideIndex >= slides.length) slideIndex = 0;
  if (slideIndex < 0) slideIndex = slides.length - 1;
  updateSlides();
}

// Hiển thị slide hiện tại
function updateSlides() {
  slides.forEach((slide, i) => {
    slide.style.display = i === slideIndex ? "block" : "none";
  });
}

// Chạy tự động sau mỗi 4 giây
setInterval(() => {
  slideIndex++;
  if (slideIndex >= slides.length) slideIndex = 0;
  updateSlides();
}, 3000);

// Hàm khởi tạo slide đầu tiên
function showSlide(n) {
  slides.forEach((slide, i) => {
    slide.style.display = i === n ? "block" : "none";
  });
}
