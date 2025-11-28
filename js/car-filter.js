// Khi trang tải xong
document.addEventListener("DOMContentLoaded", function() {
  const tabs = document.querySelectorAll(".tab");
  const containers = document.querySelectorAll(".products-container");

  tabs.forEach(tab => {
    tab.addEventListener("click", function() {
      const tabName = this.getAttribute("data-tab");

      // Xóa class active khỏi tất cả tab và container
      tabs.forEach(t => t.classList.remove("active"));
      containers.forEach(c => c.classList.remove("active"));

      // Thêm active cho tab hiện tại và container tương ứng
      this.classList.add("active");
      const activeContainer = document.getElementById("tab-" + tabName);
      if (activeContainer) activeContainer.classList.add("active");
    });
  });
});
