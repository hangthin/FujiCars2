// LOADING CAR XÌN XỊT //
document.addEventListener("DOMContentLoaded", function () {
  const overlay = document.getElementById("loadingOverlay");
  const main = document.getElementById("mainContent");

  // 🔹 Chỉ chạy khi F5 hoặc truy cập lần đầu
  if (performance.navigation.type === performance.navigation.TYPE_RELOAD || performance.navigation.type === performance.navigation.TYPE_NAVIGATE) {
    showCarLoading(() => {
      if (main) main.style.display = "block";
    });
  } else {
    if (main) main.style.display = "block";
  }

  // 🔹 Khi click vào các link chuyển trang (VD: Chi tiết)
  document.querySelectorAll("a.btn-detail, a[data-loading='true']").forEach(link => {
    link.addEventListener("click", e => {
      const href = link.getAttribute("href");
      if (!href || href.startsWith("#")) return;

      e.preventDefault();

      // ✅ Ẩn luôn nội dung trang hiện tại, hiển thị overlay
      if (main) main.style.display = "none";
      overlay.classList.remove("hide");
      overlay.style.display = "flex";

      // 🔹 Sau 3 giây (xe chạy), nhảy thẳng sang trang đích
      setTimeout(() => {
        window.location.href = href;
      }, 500);
    });
  });

  // 🔹 Hàm hiệu ứng xe chạy khi F5 hoặc lần đầu vào
  function showCarLoading(callback) {
    overlay.classList.remove("hide");
    overlay.style.display = "flex";
    if (main) main.style.display = "none";

    setTimeout(() => {
      overlay.classList.add("hide");
      setTimeout(() => {
        overlay.style.display = "none";
        if (callback) callback();
      }, 800);
    }, 800);
  }
});
