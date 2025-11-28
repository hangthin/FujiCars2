// ================== JS LỌC SẢN PHẨM ================== //
document.addEventListener("DOMContentLoaded", function() {
    filterSelection("all");
});

function filterSelection(type) {
    const items = document.getElementsByClassName("spx-col");

    for (let i = 0; i < items.length; i++) {
        let cls = items[i].className.toLowerCase();

        if (type === "all" || cls.includes(type.toLowerCase())) {
            items[i].classList.add("spx-show");
        } else {
            items[i].classList.remove("spx-show");
        }
    }
}

const btnBox = document.getElementById("spx-btn-box");
const buttons = btnBox.getElementsByClassName("spx-btn");

for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", function() {
        const current = btnBox.getElementsByClassName("spx-btn-active");
        if (current[0]) current[0].classList.remove("spx-btn-active");
        this.classList.add("spx-btn-active");
    });
}

// ===================== ZOOM EFFECT ======================
document.querySelectorAll('.ux-img').forEach(img => {
  const box = img.parentElement;

  box.addEventListener('mousemove', (e) => {
    const r = box.getBoundingClientRect();
    const x = ((e.clientX - r.left) / r.width) * 100;
    const y = ((e.clientY - r.top) / r.height) * 100;
    img.style.transformOrigin = `${x}% ${y}%`;
    img.style.transform = "scale(2)";
  });

  box.addEventListener('mouseleave', () => {
    img.style.transformOrigin = "center center";
    img.style.transform = "scale(1)";
  });
});


// ================== JS SẢN PHẨM ================== //
document.querySelectorAll('.ux-img').forEach(img => {
  const box = img.parentElement;

  box.addEventListener('mousemove', (e) => {
    const r = box.getBoundingClientRect();
    const x = ((e.clientX - r.left) / r.width) * 100;
    const y = ((e.clientY - r.top) / r.height) * 100;
    img.style.transformOrigin = `${x}% ${y}%`;
    img.style.transform = "scale(2)";
  });

  box.addEventListener('mouseleave', () => {
    img.style.transformOrigin = "center center";
    img.style.transform = "scale(1)";
  });
});